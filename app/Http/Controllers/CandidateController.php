<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use App\Models\Candidate;
use App\Models\PoliticalParty;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    public function index()
    {
        $data = Candidate::all();
        return view('admin.candidates.index', compact('data'));
    }

    public function create()
    {
        $assemblies = Assembly::all();
        $party = PoliticalParty::all();
        return view('admin.candidates.create', compact('assemblies', 'party'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:candidates,name',
                'email' => 'nullable|email|max:255|unique:candidates,email',
                'phone' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'CNIC' => 'required|string|max:15|unique:candidates,CNIC',
                'constituency_id' => 'required|exists:assemblies,id',
                'political_party_id' => 'required|exists:political_parties,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = new Candidate; 
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->city = $request->city;
            $data->CNIC = $request->CNIC;
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

    public function edit($id)
    {
        $data = Candidate::findOrFail($id);
        $assemblies = Assembly::all();
        $parties = PoliticalParty::all(); // Renamed from 'party' for clarity
        return view('admin.candidates.edit', compact('data', 'assemblies', 'parties'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:candidates,name,' . $id,
                'email' => 'nullable|email|max:255|unique:candidates,email,' . $id,
                'phone' => 'nullable|string|max:15',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:100',
                'CNIC' => 'required|string|max:15|unique:candidates,CNIC,' . $id,
                'constituency_id' => 'required|exists:assemblies,id',
                'political_party_id' => 'required|exists:political_parties,id',
            ]);

            if ($validator->fails()) {
                // Redirect back with errors and old input if not an AJAX request
                // For AJAX, you might return a JSON response as in store()
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = Candidate::findOrFail($id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->city = $request->city;
            $data->CNIC = $request->CNIC;
            $data->constituency_id = $request->constituency_id;
            $data->political_party_id = $request->political_party_id;
            $data->save(); // Use save() for consistency, update() also works

            // Add a success message (optional, good for user feedback)
            return redirect()->route('admin.candidates.index')->with('success', 'Candidate updated successfully!');

        } catch (Exception $e) {
            // Log the error or handle it as needed
            return redirect()->back()->with('error', 'Error updating candidate: ' . $e->getMessage())->withInput();
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
