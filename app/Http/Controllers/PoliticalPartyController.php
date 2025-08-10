<?php

namespace App\Http\Controllers;

use App\Models\PoliticalParty;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
                'details' => 'nullable|string|max:1000',
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
            $data->details = $request->details; 
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
                'name' => 'required|string|max:255|unique:political_parties,name,' . $id,
                'abbreviation' => 'required|string|max:50|unique:political_parties,abbreviation,' . $id,
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // image or icon
                'leader_name' => 'required|string|max:255',
                'founded_at' => 'nullable',
                'head_office' => 'nullable|string|max:255',
                'details' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors() 
                ], 422);
            }

            $politicalParty = PoliticalParty::findOrFail($id);
            $politicalParty->name = $request->name;
            $politicalParty->abbreviation = $request->abbreviation;
            $politicalParty->leader_name = $request->leader_name;
            $politicalParty->founded_at = $request->founded_at;
            $politicalParty->head_office = $request->head_office;
            $politicalParty->details = $request->details;
            $politicalParty->save();

            // image update
            if ($request->hasFile('img')) {
                // Delete the old image if necessary
                if ($politicalParty->images->isNotEmpty()) {
                    $oldImage = $politicalParty->images->first();
                    // Delete the old image file from storage
                    Storage::disk('public')->delete($oldImage->image_path);
                    // Optionally, delete the image record from the database
                    $oldImage->delete();
                }

                // Save the new image
                $filename = time() . '_' . $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('dist/img/symbol', $filename, 'public');

                // Create a new image record for the user
                $politicalParty->images()->create([
                    'image_path' => $path,
                    'type' => 'symbol',  // Optional: Specify the image type
                ]);
            }

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
