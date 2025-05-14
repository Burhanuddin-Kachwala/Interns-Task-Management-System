<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Exception;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::all();
            return view('admin.permissions.index', compact('permissions'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error fetching permissions: ' . $e->getMessage());
        }
    }
    
    public function create()
    {
        try {
            return view('admin.permissions.create');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:permissions',
            ]);

            Permission::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name'])
            ]);
            return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error creating permission: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function edit(Permission $permission)
    {
        try {
            return view('admin.permissions.edit', compact('permission'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }
    
    public function update(Request $request, Permission $permission)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            ]);

            $permission->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name'])
            ]);
            return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error updating permission: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function destroy(Permission $permission)
    {
        try {
            $permission->delete();
            return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error deleting permission: ' . $e->getMessage());
        }
    }
}
