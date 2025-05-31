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
        return view('admin.candidates.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = Candidate::findOrFail($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->CNIC = $request->CNIC;
        $data->update();

        return redirect()->route('admin.candidates.index');
    }


    public function destroy($id)
    {
        $data = Candidate::findOrFail($id);
        $data->delete();

        return redirect()->back();
    }
}
