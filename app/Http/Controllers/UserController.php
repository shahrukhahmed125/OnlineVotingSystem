<?php

namespace App\Http\Controllers;

use App\Models\Assembly;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
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

        return view('admin.user.create', compact('data', 'permissions', 'assemblies'));
    }

    public function store(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'fname' => 'required|string|max:255',
                'lname' => 'required|string|max:255',
                'cnic' => 'required|string|max:255|unique:users,cnic',
                'na_constituency_id' => 'nullable|exists:assemblies,id',
                'pa_constituency_id' => 'nullable|exists:assemblies,id',
                'user_id' => 'nullable|string|max:255|unique:users,user_id',
                'email' => 'required|string|email|unique:users,email|max:255',
                'role' => 'required',
                'email_verified_at' => 'required',
                'password' => 'required|min:8|confirmed',
                'gender' => 'nullable|string|in:male,female,others',
                'title' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'phone' => 'nullable',
                'zip_code' => 'nullable',
                'about' => 'nullable|string|max:255',
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
        // 
    }

    public function update(Request $request, $id)
    {
        // 
    }

    public function destroy($id)
    {
        // 
    }
}
