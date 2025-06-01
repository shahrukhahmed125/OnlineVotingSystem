<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Exception;
use Faker\Calculator\Ean;
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
        return view('admin.election.create');
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:1000',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                // 'is_active' => 'required|boolean',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Generate unique election ID
            $latest = Election::latest('id')->first();
            $nextNumber = $latest ? (int)substr($latest->election_id, -3) + 1 : 1; 
            $electionId = sprintf('ELEC-%03d', $nextNumber);

            $data = new Election; 
            $data->election_id = $electionId;
            $data->title = $request->title;
            $data->description = $request->description;
            $data->start_time = $request->start_time;
            $data->end_time = $request->end_time;
            // $data->is_active = $request->is_active;
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
        // $data = Election::findOrFail($id);
        // return view('admin.candidates.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // $data = Election::findOrFail($id);
        // $data->name = $request->name;
        // $data->email = $request->email;
        // $data->phone = $request->phone;
        // $data->address = $request->address;
        // $data->city = $request->city;
        // $data->CNIC = $request->CNIC;
        // $data->update();

        // return redirect()->route('admin.candidates.index');
    }


    public function destroy($id)
    {
        // $data = Election::findOrFail($id);
        // $data->delete();

        // return redirect()->back();
    }
}
