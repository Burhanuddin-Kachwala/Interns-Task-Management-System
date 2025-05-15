<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Admin\StoreRoleRequest;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::with('permissions')->get();
            return view('admin.roles.index', compact('roles'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch roles: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $permissions = Permission::all();
            return view('admin.roles.create', compact('permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load create form: ' . $e->getMessage());
        }
    }

  

public function store(StoreRoleRequest $request)
{
    try {
        DB::beginTransaction();
        $role = Role::create([
            'name' => $request->name,
            'slug' => str_replace(' ', '-', strtolower($request->name)),
            'is_superadmin' => $request->has('is_superadmin') ? true : false
        ]);

        if ($role->is_superadmin) {
            $role->permissions()->sync(Permission::all()->pluck('id'));
        } else {
            $role->permissions()->sync($request->input('permissions', []));
        }

        DB::commit();
        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to create role: ' . $e->getMessage())->withInput();
    }
}


    public function edit(Role $role)
    {
        try {
            $permissions = Permission::all();
            return view('admin.roles.edit', compact('role', 'permissions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to load edit form: ' . $e->getMessage());
        }
    }

   public function update(StoreRoleRequest $request, Role $role)
{
    if (auth()->user()->role_id === $role->id) {
        return redirect()->route('admin.roles.index')
            ->with('error', 'You cannot edit your own role.');
    }

    DB::beginTransaction();

    try {
        $role->update([
            'name' => $request->name,
            'slug' => str_replace(' ', '-', strtolower($request->name)),
            'is_superadmin' => $request->has('is_superadmin'),
        ]);

        if ($role->is_superadmin) {
            $role->permissions()->sync(Permission::all()->pluck('id'));
        } else {
            $role->permissions()->sync($request->input('permissions', []));
        }

        DB::commit();
        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to update role: ' . $e->getMessage())->withInput();
    }
}


    public function destroy(Role $role)
    {
        if (auth()->user()->role_id === $role->id) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'You cannot delete your own role.');
        }

        try {
                $role->delete();           
            return redirect()->route('admin.roles.index')
                ->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {           
            return redirect()->back()
                ->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }
}
