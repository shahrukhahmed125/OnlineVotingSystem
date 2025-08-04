<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use App\Models\PoliticalParty;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // if (!auth()->user()->can('add users')) {
        //     abort(403);
        // }

        $data = User::with(['naConstituency', 'paConstituency'])->get();
        $roles = Role::all();

        return view('admin.user.index', compact('data', 'roles'));
    }

    public function create()
    {
        // if (!auth()->user()->can('add users')) {
        //     abort(403);
        // }

        $data = Role::all();
        $permissions = Permission::all();
        $assemblies = Assembly::all();
        $parties = PoliticalParty::all();

        return view('admin.user.create', compact('data', 'permissions', 'assemblies', 'parties'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'cnic' => 'required|regex:/^\d{5}-\d{7}-\d{1}$/|unique:users,cnic',
                'na_constituency_id' => 'nullable|exists:assemblies,id',
                'pa_constituency_id' => 'nullable|exists:assemblies,id',
                'user_id' => 'nullable|string|max:255|unique:users,user_id',
                'email' => 'required|string|email|unique:users,email|max:255',
                'role' => 'required',
                'email_verified_at' => 'required|in:Yes,No',
                'gender' => 'nullable|string|in:male,female,others',
                'title' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'phone' => 'nullable|regex:/^\d{4}-\d{7}$/',
                'zip_code' => 'nullable|regex:/^\d{5}$/',
                'about' => 'nullable|string|max:255',
                'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $validator->setAttributeNames([
                'fname' => 'first name',
                'lname' => 'last name',
                'email_verified_at' => 'email verified',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = new User;
            $data->user_id = $data->generateUserId();
            $name = $request->fname . ' ' . $request->lname;
            $data->name = $name;
            $data->password = null;
            $data->fill($request->all());
            
            // optional fields
            $data->na_constituency_id = $request->na_constituency_id;
            $data->pa_constituency_id = $request->pa_constituency_id;
            $data->title = $request->title;
            $data->department = $request->department;
            $data->gender = $request->gender;
            $data->address = $request->address;
            $data->about = $request->about;
            $data->city = $request->city;
            $data->postal_code = $request->postal_code;
            $data->phone = $request->phone;
            
            // email verified
            $data->email_verified_at = $request->email_verified_at == 'Yes' ? now() : null;

            //role assign
            $role = Role::findByName($request->role);
            $data->assignRole($role);

            $data->save();

            // image save
            if ($request->hasFile('img')) {
                $filename = time() . '_' . $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('dist/img/user', $filename, 'public');
                $data->images()->create([
                    'image_path' => $path,
                    'type' => 'profile',
                ]);
            }

            // if candidate, assign political party
            if ($request->role === 'candidate' && $request->has('political_party_id')) {
                $data->candidate()->create([
                    'user_id' => $data->id,
                    'political_party_id' => $request->political_party_id,
                ]);
            }else{
                // If the user is not a candidate, ensure no candidate record exists
                $data->candidate()->delete();
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully',
            ]);

        }catch(Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function show($id)
    {
        // 
    }

    public function edit($id)
    {
        $role = Role::all();
        $permissions = Permission::all();
        $assemblies = Assembly::all();
        $parties = PoliticalParty::all();
        $user = User::findOrFail($id);

        $user->name = explode(' ', $user->name, 2);
        $fname = $user->name[0];
        $lname = $user->name[1] ?? '';

        return view('admin.user.edit', compact('user', 'role', 'permissions', 'assemblies', 'parties', 'fname', 'lname'));
    }

    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'cnic'  => 'required|regex:/^\d{5}-\d{7}-\d{1}$/|unique:users,cnic,' . $id,
                'na_constituency_id' => 'nullable|exists:assemblies,id',
                'pa_constituency_id' => 'nullable|exists:assemblies,id',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'role' => 'required',
                'email_verified_at' => 'required|in:Yes,No',
                'gender' => 'nullable|string|in:male,female,others',
                'title' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'phone' => 'nullable|regex:/^\d{4}-\d{7}$/',
                'zip_code' => 'nullable|regex:/^\d{5}$/',
                'about' => 'nullable|string|max:255',
                // 'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $validator->setAttributeNames([
                'fname' => 'first name',
                'lname' => 'last name',
                'email_verified_at' => 'email verified',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'validation_error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = User::findOrFail($id);
            $name = $request->fname . ' ' . $request->lname;
            $data->name = $name;
            $data->fill($request->all());
            
            // optional fields
            $data->na_constituency_id = $request->na_constituency_id;
            $data->pa_constituency_id = $request->pa_constituency_id;
            $data->title = $request->title;
            $data->department = $request->department;
            $data->gender = $request->gender;
            $data->address = $request->address;
            $data->about = $request->about;
            $data->city = $request->city;
            $data->postal_code = $request->postal_code;
            $data->phone = $request->phone;
            
            // email verified
            $data->email_verified_at = $request->email_verified_at == 'Yes' ? now() : null;

            //role assign
            $role = Role::findByName($request->role);
            $data->assignRole($role);

            $data->save();

            // image update
            if ($request->hasFile('img')) {
                // Delete the old image if necessary
                if ($data->images->isNotEmpty()) {
                    $oldImage = $data->images->first();
                    // Delete the old image file from storage
                    Storage::disk('public')->delete($oldImage->image_path);
                    // Optionally, delete the image record from the database
                    $oldImage->delete();
                }

                // Save the new image
                $filename = time() . '_' . $request->file('img')->getClientOriginalName();
                $path = $request->file('img')->storeAs('dist/img/user', $filename, 'public');

                // Create a new image record for the user
                $data->images()->create([
                    'image_path' => $path,
                    'type' => 'profile',  // Optional: Specify the image type
                ]);
            }

            // if candidate, assign political party
            if ($request->role === 'candidate' && $request->has('political_party_id')) {
                $data->candidate()->create([
                    'user_id' => $data->id,
                    'political_party_id' => $request->political_party_id,
                ]);
            }else{
                // If the user is not a candidate, ensure no candidate record exists
                $data->candidate()->delete();
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully',
            ]);

        }catch(Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }   
    }

    public function destroy($id)
    {
        try{
            User::findOrFail($id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully',
            ]);
        }catch(Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
