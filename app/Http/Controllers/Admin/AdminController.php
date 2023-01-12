<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Admin Dashboard Area';
        $data['roles'] = Role::query()->get();
        return view('admin.settings.users', $data);
    }

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:admins,email',
            'role' => 'required'
        ];

        $request->validate($rules);

        $result = DB::transaction(function() use($request) {
            $data = $request->all();
            $data['password'] = '123456';
            
            $role = Role::find($request->role);
            $admin = Admin::create($data);

            return $admin->roles()->sync($role);
        });

        if ($result) {
            return back()->with('primary', 'User Created Successfully!');
        }
        return back()->with('danger', 'Unable to Create User!');
    }

    public function show(Admin $admin)
    {
        $data['page_title'] = 'Admin Dashboard Area';
        $data['admin'] = $admin;
        $data['roles'] = Role::query()->get();
        return view('admin.settings.edit-user', $data);
    }

    public function edit(Request $request, Admin $admin)
    {
        $rules = [
            'name' => 'required|min:2',
            'email' => [
                'required',
                'email',
                Rule::unique('admins')->ignore($admin->id),
            ],
            'role' => 'required'
        ];

        $request->validate($rules);

        $result = DB::transaction(function() use($request, $admin) {
            $admin->name = $request->name;
            $admin->email = $request->email;
            
            $role = Role::find($request->role);
            $admin->save();
            return $admin->roles()->sync($role);
        });

        if ($result) {
            return back()->with('primary', 'User Edit Successfully!');
        }
        return back()->with('danger', 'Unable to Edit User!');
    }

    public function deactivate(Admin $admin)
    {
        $admin->status = '0';
        $result = $admin->save();
        if ($result) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }
    
    public function activate(Admin $admin)
    {
        $admin->status = '1';
        $result = $admin->save();
        if ($result) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }

}
