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
        // Get the current active election relevant to the user's constituency
        $election = Election::where('is_active', true)
            ->where(function ($query) use ($user) {
                $query->where('type', 'national assembly')
                    ->orWhere('type', 'provincial assembly')
                    ->orWhere('type', 'general assembly');
            })
            ->first();

        if (!$election) {
            return response()->json([
                'status' => 'error',
                'message' => 'No active election for your constituency at the moment.'
            ], 404);
        }

        $assembly = null;

        // Determine which assembly applies to the user based on the election type
        if ($election->type === 'national assembly') {
            $assembly = Assembly::find($user->na_constituency_id);
        } elseif ($election->type === 'provincial assembly') {
            $assembly = Assembly::find($user->pa_constituency_id);
        } elseif ($election->type === 'general assembly') {
            // For general elections, you might want to handle both NA and PA
            $naAssembly = Assembly::find($user->na_constituency_id);
            $paAssembly = Assembly::find($user->pa_constituency_id);
            $assembly = collect([$naAssembly, $paAssembly])->filter(); // just in case one is null
        }

        if (!$assembly) {
            return response()->json([
                'status' => 'error',
                'message' => 'Assembly information not found for the active election.'
            ], 404);
        }

        // Get candidates for the relevant assembly or both
        $candidates = Candidate::whereIn('constituency_id', [
            $user->na_constituency_id,
            $user->pa_constituency_id
        ])->with('politicalParty')->get();

        if ($candidates->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No candidates available for this election in your constituency.'
            ], 404);
        }

        // Determine how many votes the user can cast
        $maxVotes = $election->type === 'general assembly' ? 2 : 1;
        // dd($election, $assembly, $candidates, $maxVotes);

        return view('voter.castVote', compact('election', 'assembly', 'candidates', 'maxVotes', 'user'));
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

            if ($election->type === 'general assembly') {

                // Handle PA vote
                if ($request->pa_candidate_id) {
                    $paCandidate = Candidate::findOrFail($request->pa_candidate_id);
                    $paAssemblyId = $request->pa_assembly_id;

                    if ($paCandidate->constituency_id != $user->pa_constituency_id) {
                        return response()->json([
                            'status' => 'error', 
                            'message' => 'You are not eligible to vote for PA.'],
                             403);
                    }

                    $alreadyVotedPA = Vote::where('voter_id', $user->id)
                        ->where('election_id', $election->id)
                        ->where('assembly_id', $paAssemblyId)
                        ->exists();

                    if (!$alreadyVotedPA) {
                        Vote::create([
                            'voter_id' => $user->id,
                            'candidate_id' => $paCandidate->id,
                            'election_id' => $election->id,
                            'assembly_id' => $paAssemblyId,
                            'voted_at' => now()
                        ]);
                    }
                }

                // Handle NA vote
                if ($request->na_candidate_id) {
                    $naCandidate = Candidate::findOrFail($request->na_candidate_id);
                    $naAssemblyId = $request->na_assembly_id;

                    if ($naCandidate->constituency_id != $user->na_constituency_id) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'You are not eligible to vote for NA.'
                        ], 403);
                    }

                    $alreadyVotedNA = Vote::where('voter_id', $user->id)
                        ->where('election_id', $election->id)
                        ->where('assembly_id', $naAssemblyId)
                        ->exists();

                    if (!$alreadyVotedNA) {
                        Vote::create([
                            'voter_id' => $user->id,
                            'candidate_id' => $naCandidate->id,
                            'election_id' => $election->id,
                            'assembly_id' => $naAssemblyId,
                            'voted_at' => now()
                        ]);
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Your vote(s) have been cast successfully.'
                ]);
            }

            // Handle other election types (e.g. single NA or PA)
            if ($request->candidate_id) {
                $candidate = Candidate::findOrFail($request->candidate_id);

                if ($candidate->constituency_id != $user->na_constituency_id && $candidate->constituency_id != $user->pa_constituency_id) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You are not eligible to vote in this election.'
                    ], 403);
                }

                $alreadyVoted = Vote::where('voter_id', $user->id)
                    ->where('election_id', $election->id)
                    ->exists();

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
                    'assembly_id' => $candidate->constituency_id,
                    'voted_at' => now()
                ]);

                return response()->json(['status' => 'success', 'message' => 'Your vote has been cast.']);
            }

            return response()->json(['status' => 'error', 'message' => 'No vote submitted.'], 400);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


}
