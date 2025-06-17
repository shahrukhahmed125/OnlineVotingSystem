<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // 
    }

    public function create()
    {
        // if (!auth()->user()->can('add users')) {
        //     abort(403);
        // }

        $data = Role::all();
        $permissions = Permission::all();

        return view('admin.user.create', compact('data', 'permissions'));
    }

    public function store(Request $request)
    {
        // 
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
