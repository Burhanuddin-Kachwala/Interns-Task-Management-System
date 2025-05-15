<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use App\Http\Requests\Admin\AdminRequest;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        try {
            return view('admin.auth.login');
        } catch (Exception $e) {
            return back()->with('error', 'Error loading login page: ' . $e->getMessage());
        }
    }

public function login(AdminRequest $request)
{
    try {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();

            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => 'Your account is inactive. Please contact the administrator.',
                ])->with('error', 'Account inactive');
            }

            return redirect(route('admin.dashboard'))->with('success', 'Successfully logged in.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->with('error', 'Login failed. Please check your credentials.');

    } catch (Exception $e) {
        return back()->with('error', 'Login failed: ' . $e->getMessage());
    }
}

    public function dashboard()
    {
        try {
            $Comments = TaskComment::with(['intern', 'task'])->latest()->get();
            return view('admin.dashboard', compact('Comments'));
        } catch (QueryException $e) {
            return back()->with('error', 'Database error: ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', 'Error loading dashboard: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login');
        } catch (Exception $e) {
            return back()->with('error', 'Logout failed: ' . $e->getMessage());
        }
    }
}
