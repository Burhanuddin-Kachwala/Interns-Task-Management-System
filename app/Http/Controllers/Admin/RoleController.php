<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

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

    public function store(Request $request)
    {
        try {
            $validationRules = [
                'name' => 'required|string|max:255|unique:roles,name',
            ];

            if (!$request->input('is_superadmin')) {
                $validationRules['permissions'] = 'required|array';
            }

            $validatedData = $request->validate($validationRules);

            DB::beginTransaction();
            try {
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

                DB::commit();
                return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
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

    public function update(Request $request, Role $role)
    {
        try {
            if (auth()->user()->role_id === $role->id) {
                return redirect()->route('admin.roles.index')
                    ->with('error', 'You cannot edit your own role.');
            }

            $validationRules = [
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            ];

            if (!$request->input('is_superadmin')) {
                $validationRules['permissions'] = 'required|array';
            }

            $validatedData = $request->validate($validationRules);

            DB::beginTransaction();
            try {
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

                DB::commit();
                return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update role: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Role $role)
    {
        try {
            if (auth()->user()->role_id === $role->id) {
                return redirect()->route('admin.roles.index')
                    ->with('error', 'You cannot delete your own role.');
            }

            DB::beginTransaction();
            try {
                $role->delete();
                DB::commit();
                return redirect()->route('admin.roles.index')
                    ->with('success', 'Role deleted successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete role: ' . $e->getMessage());
        }
    }
}
