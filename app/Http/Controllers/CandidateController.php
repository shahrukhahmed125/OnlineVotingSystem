<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index()
    {
        $data = Candidate::all();
        return view('admin.candidates.index', compact('data'));
    }

    public function create()
    {
        return view('admin.candidates.create');
    }

    public function store(Request $request)
    {
        $data = new Candidate; 
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->CNIC = $request->CNIC;
        $data->save();

        return redirect()->back();
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

        return redirect()->route('candidates.index');
    }


    public function destroy($id)
    {
        $data = Candidate::findOrFail($id);
        $data->delete();

        return redirect()->back();
    }
}
