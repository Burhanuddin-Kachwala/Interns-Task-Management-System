<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Admin;
use App\Http\Controllers\Controller; // This should be the base Controller
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class AdminUserController extends Controller
{
    public function index()
    {
        $admins = Admin::with('role')->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin-users.index')->with('success', 'Admin created successfully.');
    }

    public function edit(Admin $admin_user)
    {
        $admin = $admin_user;
        $roles = Role::all();
        return view('admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, Admin $admin_user)
    {
        // Validate request
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'role_id'  => 'required|exists:roles,id',
            'password' => 'nullable|confirmed|min:6',
        ]);
    
        // Prepare update data
        $updateData = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role_id'   => $request->role_id,
            'is_active' => $request->has('is_active'), // true if checked, false otherwise
        ];
    
        // Add password if provided
        if ($request->filled('password')) {
            $updateData['password'] = \Hash::make($request->password);
        }
    
       

        $admin_user->update($updateData);
    
        return redirect()->route('admin-users.index')->with('success', 'Admin updated successfully.');
    }
    
    

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin-users.index')->with('success', 'Admin deleted.');
    }
}
