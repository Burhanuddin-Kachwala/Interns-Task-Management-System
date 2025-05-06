<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    // Display all roles
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    // Show the form to create a new role
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        
        $validationRules = [
            'name' => 'required|string|max:255|unique:roles,name',
        ];

        // Only validate permissions if not superadmin
        if (!$request->input('is_superadmin')) {
            $validationRules['permissions'] = 'required|array';
        }

        $validatedData = $request->validate($validationRules);

        $role = Role::create([
            'name' => $validatedData['name'],
            'slug' => str_replace(' ', '-', strtolower($validatedData['name'])),
            'is_superadmin' => $request->has('is_superadmin') ? true : false
        ]);

        if ($role->is_superadmin) {
            $role->permissions()->sync(Permission::all()->pluck('id'));
        } else {
            $role->permissions()->sync($request->input('permissions', []));
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

   

    // Show the form to edit an existing role
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    // Update the specified role
    public function update(Request $request, Role $role)
    {
        $validationRules = [
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ];

        // Only validate permissions if not superadmin
        if (!$request->input('is_superadmin')) {
            $validationRules['permissions'] = 'required|array';
        }

        $validatedData = $request->validate($validationRules);

        $role->update([
            'name' => $validatedData['name'],
            'slug' => str_replace(' ', '-', strtolower($validatedData['name'])),
            'is_superadmin' => $request->has('is_superadmin') ? true : false
        ]);

        if ($role->is_superadmin) {
            $role->permissions()->sync(Permission::all()->pluck('id'));
        } else {
            $role->permissions()->sync($request->input('permissions', []));
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }
    // Delete the specified role
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
