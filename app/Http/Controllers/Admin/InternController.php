<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Intern;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class InternController extends Controller
{
    public function index()
    {
        $interns = Intern::with('role')->get();
        return view('admin.interns.index', compact('interns'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.interns.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:interns,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        Intern::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.interns.index')->with('success', 'Intern created successfully.');
    }

    public function edit(Intern $intern)
    {
        $roles = Role::all();
        return view('admin.interns.edit', compact('intern', 'roles'));
    }

    public function update(Request $request, Intern $intern)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:interns,email,' . $intern->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $intern->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.interns.index')->with('success', 'Intern updated successfully.');
    }

    public function destroy(Intern $intern)
    {
        $intern->delete();
        return redirect()->route('admin.interns.index')->with('success', 'Intern deleted.');
    }
}
