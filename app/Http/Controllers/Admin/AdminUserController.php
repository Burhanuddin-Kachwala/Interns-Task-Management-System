<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Database\QueryException;

class AdminUserController extends Controller
{
    public function index()
    {
        try {
            $admins = Admin::with('role')->get();
            return view('admin.admins.index', compact('admins'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error fetching admin users: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $roles = Role::all();
            return view('admin.admins.create', compact('roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
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
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('admin-users.index')->with('success', 'Admin created successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage())->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error creating admin: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Admin $admin_user)
    {
        try {
            $admin = $admin_user;
            $roles = Role::all();
            return view('admin.admins.edit', compact('admin', 'roles'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error loading edit form: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Admin $admin_user)
    {
        try {
            if (auth()->guard('admin')->id() === $admin_user->id) {
                return redirect()->route('admin-users.index')->with('error', 'You cannot edit your own account.');
            }

            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email',
                'role_id'  => 'required|exists:roles,id',
                'password' => 'nullable|min:6',
            ]);

            $updateData = [
                'name'      => $request->name,
                'email'     => $request->email,
                'role_id'   => $request->role_id,
                'is_active' => $request->has('is_active'),
            ];

            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            $admin_user->update($updateData);
            return redirect()->route('admin-users.index')->with('success', 'Admin updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage())->withInput();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error updating admin: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Admin $admin_user)
    {
        try {
            if (auth()->guard('admin')->id() === $admin_user->id) {           
                return redirect()->route('admin-users.index')->with('error', 'You cannot delete your own account.');
            }

            $admin_user->delete();
            return redirect()->route('admin-users.index')->with('success', 'Admin deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error deleting admin: ' . $e->getMessage());
        }
    }
}
