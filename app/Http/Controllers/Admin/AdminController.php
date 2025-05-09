<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
           
            if (!$admin->is_active) {
                Auth::guard('admin')->logout();
                return back()->withErrors([
                    'email' => 'Your account is inactive. Please contact the administrator.',
                ])->with('error', 'Account inactive');
            }

            return redirect(route('admin.dashboard'))
               ->with('success', 'Successfully logged in.');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->with('error', 'Login failed. Please check your credentials.');
    }

    public function dashboard()
    {
        $Comments = TaskComment::with(['intern', 'task'])->latest()->get();
        return view('admin.dashboard', compact('Comments'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
