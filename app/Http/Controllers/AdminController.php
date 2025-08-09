<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\PoliticalParty;
use App\Models\User;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $TotalVoters = User::role(['voter', 'candidate'])->count(); // voters are still users
        $TotalCandidates = Candidate::count(); // switched to Candidate model
        $TotalAssemblies = Assembly::count();

        $ActiveElections = Election::where('is_active', true)->count();

        $VotesToday = Vote::whereDate('created_at', Carbon::today())->count();

        $VotesPerAssembly = Vote::select('assembly_id', DB::raw('count(*) as total'))
            ->groupBy('assembly_id')
            ->with('assembly')
            ->get();

        $TopCandidates = Candidate::withCount('votes')
        ->orderByDesc('votes_count')
        ->with(['user', 'assemblies', 'politicalParty'])
        ->take(5)
        ->get();

        $TotalVotersPerAssembly = $TopCandidates->map(function ($candidate) {
            $assemblyIds = $candidate->assemblies->pluck('id');

            // Count users (voter or candidate) where either na_constituency_id or pa_constituency_id matches
            $totalUsers = User::role(['voter', 'candidate'])
                ->where(function ($query) use ($assemblyIds) {
                    $query->whereIn('na_constituency_id', $assemblyIds)
                        ->orWhereIn('pa_constituency_id', $assemblyIds);
                })
                ->count();

            return [
                'candidate' => $candidate,
                'total_users' => $totalUsers,
            ];
        });

        return view('admin.AdminDashboard', compact(
            'TotalVoters',
            'TotalCandidates',
            'TotalAssemblies',
            'ActiveElections',
            'VotesToday',
            'VotesPerAssembly',
            'TopCandidates',
            'TotalVotersPerAssembly'
        ));
    }

    public function getVotes()
    {
        $votes = Vote::with(['voter', 'candidate', 'assembly', 'election'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.vote.index', compact('votes'));
    }

    public function deleteVote($id)
    {
        $vote = Vote::findOrFail($id);
        $vote->delete();

        return redirect()->back()->with('success', 'Vote deleted successfully.');
    }

    public function topCandidates()
    {
        $TopCandidates = Candidate::withCount('votes')
        ->orderByDesc('votes_count')
        ->with(['user', 'assemblies', 'politicalParty'])
        ->get();

        $TotalVotersPerAssembly = $TopCandidates->map(function ($candidate) {
            $assemblyIds = $candidate->assemblies->pluck('id');

            // Count users (voter or candidate) where either na_constituency_id or pa_constituency_id matches
            $totalUsers = User::role(['voter', 'candidate'])
                ->where(function ($query) use ($assemblyIds) {
                    $query->whereIn('na_constituency_id', $assemblyIds)
                        ->orWhereIn('pa_constituency_id', $assemblyIds);
                })
                ->count();

            return [
                'candidate' => $candidate,
                'total_users' => $totalUsers,
            ];
        });

        return view('admin.vote.top_candidates', compact('TopCandidates', 'TotalVotersPerAssembly'));
    }

    public function getVotesByParty()
    {
        $votesByParty = PoliticalParty::with('images')
            ->select(
                'political_parties.id',
                'political_parties.name',
                'political_parties.abbreviation',
                DB::raw('COUNT(votes.id) as total_votes')
            )
            ->join('candidates', 'candidates.political_party_id', '=', 'political_parties.id')
            ->join('votes', 'votes.candidate_id', '=', 'candidates.id')
            ->groupBy('political_parties.id', 'political_parties.name', 'political_parties.abbreviation')
            ->get();

        return view('admin.vote.top_parties', compact('votesByParty'));
    }
}