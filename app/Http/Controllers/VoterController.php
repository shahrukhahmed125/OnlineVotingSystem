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
        return view('voter.dashboard');
    }

    public function create()
    {
        $user = Auth::user();
        // Get the current active election
        $election = Election::where('is_active', true)
                            ->where('start_time', '<=', now())
                            ->where('end_time', '>=', now())
                            ->first();

        if (!$election) {
            return redirect()->back()->with('status', 'No active election at the moment.');
        }

        // Get candidates from the user's NA or PA constituency
        $candidates = Candidate::where('constituency_id', $user->na_constituency_id)
                            ->orWhere('constituency_id', $user->pa_constituency_id)
                            ->get();

        if ($candidates->isEmpty()) {
            return redirect()->back()->with('status', 'No candidates available for your constituency.');
        }

        // Get the relevant assembly (based on user's constituency)
        $assembly = Assembly::where('constituency_id', $user->na_constituency_id)
                            ->orWhere('constituency_id', $user->pa_constituency_id)
                            ->first();

        if (!$assembly) {
            return redirect()->back()->with('status', 'Assembly information not found for your constituency.');
        }

        return view('admin.vote.create', compact('candidates', 'election', 'assembly'));
    }

    public function store(Request $request)
    {
        try{        
            $validator = Validator::make($request->all(), [
                'candidate_id' => 'required|exists:candidates,id',
                'election_id' => 'required|exists:elections,id',
                'assembly_id' => 'required|exists:assemblies,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user(); // Authenticated voter
            $election = Election::findOrFail($request->election_id);
            $candidate = Candidate::findOrFail($request->candidate_id);

            // Check if election is active and ongoing
            $now = Carbon::now();
            if (!$election->is_active || $election->start_time > $now || $election->end_time < $now) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This election is not active currently.'
                ], 403);
            }

            // Check if voter has already voted in this election
            $alreadyVoted = Vote::where('voter_id', $user->id)
                ->where('election_id', $election->id)
                ->exists();

            if ($alreadyVoted) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have already voted in this election.'
                ], 409);
            }

            // Candidate must belong to voter's NA or PA constituency
            if (
                $candidate->constituency_id != $user->na_constituency_id &&
                $candidate->constituency_id != $user->pa_constituency_id
            ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This candidate is not from your area.'
                ], 403);
            }

            // Save vote
            $vote = new Vote();
            $vote->voter_id = $user->id;
            $vote->candidate_id = $candidate->id;
            $vote->election_id = $election->id;
            $vote->assembly_id = $request->assembly_id;
            $vote->has_voted = true;
            $vote->voted_at = now();
            $vote->save();


            return response()->json([
                'status' => 'success',
                'message' => 'Your vote has been cast successfully.',
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
