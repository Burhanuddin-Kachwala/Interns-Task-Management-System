<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
        public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }
    
    public function create()
    {
        return view('admin.permissions.create');
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
        ]);

        Permission::create([
            'name' => $validated['name'],
            'slug' => str_replace(' ', '-', strtolower($validated['name']))
        ]);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission created.');
    }
    
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }
    
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update([
            'name' => $validated['name'],
            'slug' => str_replace(' ', '-', strtolower($validated['name']))
        ]);
        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated.');
    }
    
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted.');
    }
    
}
