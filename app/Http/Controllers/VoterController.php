<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoterController extends Controller
{
    public function index()
    {
        return view('voter.dashboard');
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'candidate_id' => 'required|exists:candidates,id',
                'election_id' => 'required|exists:elections,id',
                'voted_at' => 'required|date',
                'assembly_id' => 'required|exists:assemblies,id',
                'has_voted' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors() 
                ], 422);
            }

            $data = new Vote;
            // 
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Voter data stored successfully',
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
