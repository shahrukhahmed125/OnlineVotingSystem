<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\PoliticalParty;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    public function index()
    {
        $data = Candidate::all();
        $elections = Election::all();
        $assemblies = Assembly::all();
        return view('admin.candidates.index', compact('data', 'elections', 'assemblies'));
    }

    public function assign(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'assembly_id' => 'required|exists:assemblies,id',
                'election_id' => 'required|exists:elections,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $candidate = Candidate::findOrFail($id);
            $candidate->elections()->attach($request->election_id, [
                'assembly_id' => $request->assembly_id,
                'status' => 'nominated',
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Candidate assigned successfully!',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        $users = User::role('candidate')->get();
        $parties = PoliticalParty::all();
        return view('admin.candidates.create', compact('users', 'parties'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'political_party_id' => 'required|exists:political_parties,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = new Candidate; 
            $data->user_id = $request->user_id;
            $data->constituency_id = $request->constituency_id;
            $data->political_party_id = $request->political_party_id;
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Candidate created successfully!',
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $candidate = Candidate::findOrFail($id);
            $candidate->delete();

            return redirect()->route('admin.candidates.index')->with('success', 'Candidate deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('admin.candidates.index')->with('error', 'Error deleting candidate: ' . $e->getMessage());
        }
    }
}
