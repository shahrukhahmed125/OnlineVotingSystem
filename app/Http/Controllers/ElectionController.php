<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Assembly; // Added Assembly model
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ElectionController extends Controller
{
        public function index()
    {
        $data = Election::all();
        return view('admin.election.index', compact('data'));
    }

    public function create()
    {
        $assemblies = Assembly::all();
        return view('admin.election.create', compact('assemblies'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'type' => 'required|in:general assembly,national assembly,provincial assembly', // Updated to use string values
                'is_active' => 'sometimes|boolean', // Changed to sometimes, default can be false
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = new Election; 
            $data->election_id = $data->generateElectionId();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_time = $request->start_time;
            $data->end_time = $request->end_time;
            $data->type = $request->type; // Updated to use type
            $data->is_active = $request->input('is_active', false); // Set is_active, default to false
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Eelection created successfully!',
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $election = Election::findOrFail($id);
        $assemblies = Assembly::all();
        return view('admin.election.edit', compact('election', 'assemblies'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'assembly_id' => 'required|exists:assemblies,id',
                'is_active' => 'sometimes|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = Election::findOrFail($id);
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_time = $request->start_time;
            $data->end_time = $request->end_time;
            $data->assembly_id = $request->assembly_id;
            $data->is_active = $request->input('is_active', $data->is_active); // Keep current if not provided
            $data->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Election updated successfully!',
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $election = Election::findOrFail($id);
            $election->delete();

            return redirect()->route('admin.elections.index')->with('success', 'Election deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('admin.elections.index')->with('error', 'Error deleting election: ' . $e->getMessage());
        }
    }
}
