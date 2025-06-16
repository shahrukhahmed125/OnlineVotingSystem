<?php

namespace App\Http\Controllers;

use App\Models\PoliticalParty;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PoliticalPartyController extends Controller
{
    public function index()
    {
        $politicalParties = PoliticalParty::all();
        return view('admin.political_parties.index', compact('politicalParties'));
    }

    public function create()
    {
        return view('admin.political_parties.create');
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:political_parties,name',
                'abbreviation' => 'required|string|max:50|unique:political_parties,abbreviation',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // image or icon
                'leader_name' => 'required|string|max:255',
                'founded_at' => 'nullable',
                'head_office' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors() 
                ], 422);
            }

            $data = new PoliticalParty;
            $data->name = $request->name;
            $data->abbreviation = $request->abbreviation;
            $data->leader_name = $request->leader_name;
            $data->founded_at = $request->founded_at;
            $data->head_office = $request->head_office;
            $data->save();

            // image save
            if ($request->hasFile('img')) {
                $filename = time() . '_' . $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('dist/img/symbol', $filename, 'public');
                $data->images()->create([
                    'image_path' => $path,
                    'type' => 'symbol',
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Political Party created successfully',
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function edit($id)
    {
        $politicalParty = PoliticalParty::findOrFail($id);
        return view('admin.political_parties.edit', compact('politicalParty'));
    }

    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'abbreviation' => 'required|string|max:50',
                'symbol' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // image or icon
                'leader_name' => 'required|string|max:255',
                'founded_year' => 'required|integer|min:1900|max:' . date('Y'),
                'head_office' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors() 
                ], 422);
            }

            $politicalParty = PoliticalParty::findOrFail($id);
            $politicalParty->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Political Party updated successfully',
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $politicalParty = PoliticalParty::findOrFail($id);
            $politicalParty->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Political Party deleted successfully',
            ]);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
