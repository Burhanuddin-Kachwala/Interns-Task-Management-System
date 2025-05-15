<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Intern;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InternRequest;
use Illuminate\Support\Facades\Hash;
use Exception;

class InternController extends Controller
{
    public function index()
    {
        try {
            $interns = Intern::with('role')->get();
            return view('admin.interns.index', compact('interns'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error loading interns: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $roles = Role::all();
            return view('admin.interns.create', compact('roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    public function store(InternRequest $request)
    {
        try {
            Intern::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => Role::where('name', 'intern')->first()->id,
            ]);

            return redirect()->route('admin.interns.index')->with('success', 'Intern created successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error creating intern: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Intern $intern)
    {
        try {
            return view('admin.interns.edit', compact('intern'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

     public function update(InternRequest $request, Intern $intern)
    {
        try {
            $intern->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => Role::where('name', 'intern')->first()->id,
            ]);

            return redirect()->route('admin.interns.index')->with('success', 'Intern updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error updating intern: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Intern $intern)
    {
        try {
            $intern->delete();
            return redirect()->route('admin.interns.index')->with('success', 'Intern deleted.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error deleting intern: ' . $e->getMessage());
        }
    }
}
