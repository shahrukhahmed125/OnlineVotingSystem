<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssemblyController extends Controller
{
    public function index()
    {
        $assemblies = Assembly::all();
        return view('admin.assembly.index', compact('assemblies'));   
    }

    public function create()
    {
        return view('admin.assembly.create');
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'type' => 'required|string|max:255|in:NA,PA',
                'province' => 'nullable|string|max:255',
                'district' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors() 
                ], 422);
            }

            $assembly = new Assembly;
            $assembly->name = $request->name;
            $assembly->type = $request->type;
            $assembly->province = $request->province;
            $assembly->district = $request->district;
            $assembly->description = $request->description;
            $assembly->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Assembly created successfully',
            ]);

        }catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
