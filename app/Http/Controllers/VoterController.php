<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Vote;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VoterController extends Controller
{
    public function index()
    {
        return view('voter.overview');
    }

    public function castVote()
    {
        $user = Auth::user();

        // Fetch the active election
        $election = Election::where('is_active', true)
            ->whereIn('type', ['national assembly', 'provincial assembly', 'general assembly'])
            ->first();

        if (!$election) {
            return response()->json([
                'status' => 'error',
                'message' => 'No active election available at the moment.'
            ], 404);
        }

        // Get relevant assembly IDs
        $assemblyIds = [];

        if ($election->type === 'national assembly' && $user->na_constituency_id) {
            $assemblyIds[] = $user->na_constituency_id;
        } elseif ($election->type === 'provincial assembly' && $user->pa_constituency_id) {
            $assemblyIds[] = $user->pa_constituency_id;
        } elseif ($election->type === 'general assembly') {
            if ($user->na_constituency_id) $assemblyIds[] = $user->na_constituency_id;
            if ($user->pa_constituency_id) $assemblyIds[] = $user->pa_constituency_id;
        }

        if (empty($assemblyIds)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No valid assembly found for your constituency.'
            ], 404);
        }

        // Fetch candidates assigned to this election and user's assemblies via pivot
        $candidates = Candidate::whereHas('elections', function ($query) use ($election, $assemblyIds) {
            $query->where('election_candidate.election_id', $election->id)
                ->whereIn('election_candidate.assembly_id', $assemblyIds);
        })
        ->with([
            'politicalParty.images',
            'elections' => function ($query) use ($election) {
                $query->where('election_candidate.election_id', $election->id);
            },
            'assemblies' // Make sure this relationship exists
        ])->get();

        if ($candidates->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No candidates available for this election in your constituency.'
            ], 404);
        }

        // Attach assembly_type manually to each candidate
        foreach ($candidates as $candidate) {
            $assemblyId = $candidate->elections->first()?->pivot->assembly_id;
            $candidate->assembly_type = \App\Models\Assembly::find($assemblyId)?->type;
        }

        $maxVotes = $election->type === 'general assembly' ? 2 : 1;

        return view('voter.castVote', compact('election', 'candidates', 'user', 'maxVotes'));
    }

    public function storeVote(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'election_id' => 'required|exists:elections,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $election = Election::findOrFail($request->election_id);

            if (!$election->is_active) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This election is not active currently.'
                ], 403);
            }

            // Handle General Election (2 votes)
            if ($election->type === 'general assembly') {
                // PA
                if ($request->pa_candidate_id) {
                    $paCandidate = Candidate::findOrFail($request->pa_candidate_id);
                    $paAssemblyId = $request->pa_assembly_id;

                    $alreadyVotedPA = Vote::where([
                        ['voter_id', $user->id],
                        ['election_id', $election->id],
                        ['assembly_id', $paAssemblyId],
                    ])->exists();

                    if (!$alreadyVotedPA) {
                        Vote::create([
                            'voter_id' => $user->id,
                            'candidate_id' => $paCandidate->id,
                            'election_id' => $election->id,
                            'assembly_id' => $paAssemblyId,
                            'voted_at' => now(),
                        ]);
                    }
                }

                // NA
                if ($request->na_candidate_id) {
                    $naCandidate = Candidate::findOrFail($request->na_candidate_id);
                    $naAssemblyId = $request->na_assembly_id;

                    $alreadyVotedNA = Vote::where([
                        ['voter_id', $user->id],
                        ['election_id', $election->id],
                        ['assembly_id', $naAssemblyId],
                    ])->exists();

                    if (!$alreadyVotedNA) {
                        Vote::create([
                            'voter_id' => $user->id,
                            'candidate_id' => $naCandidate->id,
                            'election_id' => $election->id,
                            'assembly_id' => $naAssemblyId,
                            'voted_at' => now(),
                        ]);
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Your vote(s) have been cast successfully.'
                ]);
            }

            // Handle Single Vote (NA or PA)
            if ($request->candidate_id) {
                $candidate = Candidate::findOrFail($request->candidate_id);

                // Get the assembly from pivot table
                $assemblyId = $request->assembly_id;

                $alreadyVoted = Vote::where([
                    ['voter_id', $user->id],
                    ['election_id', $election->id],
                    ['assembly_id', $assemblyId],
                ])->exists();

                if ($alreadyVoted) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You have already voted in this election.'
                    ], 409);
                }

                Vote::create([
                    'voter_id' => $user->id,
                    'candidate_id' => $candidate->id,
                    'election_id' => $election->id,
                    'assembly_id' => $assemblyId,
                    'voted_at' => now(),
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Your vote has been cast successfully.'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'No vote data was submitted.'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }


}
