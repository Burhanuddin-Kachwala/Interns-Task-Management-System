<?php

namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Http\Requests\Intern\InternLoginRequest;
use App\Http\Requests\Intern\InternRegisterRequest;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Database\QueryException;

class InternController extends Controller
{
    public function showRegistrationForm()
    {
        try {
            return view('intern.auth.register');
        } catch (Exception $e) {
            return back()->with('error', 'Error loading registration form: ' . $e->getMessage());
        }
    }
public function register(InternRegisterRequest $request)
{
    try {
        $intern = Intern::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('intern')->login($intern);

        return redirect()->route('intern.dashboard')->with('success', 'Registration successful!');
    } catch (QueryException $e) {
        return back()->with('error', 'Database error during registration. Please try again.')->withInput();
    } catch (Exception $e) {
        return back()->with('error', 'Registration failed: ' . $e->getMessage())->withInput();
    }
}

    public function showLoginForm()
    {
        try {
            return view('intern.auth.login');
        } catch (Exception $e) {
            return back()->with('error', 'Error loading login form: ' . $e->getMessage());
        }
    }

   public function login(InternLoginRequest $request)
{
    try {
        if (Auth::guard('intern')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('intern.dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->withInput();
    } catch (Exception $e) {
        return back()->with('error', 'Login failed: ' . $e->getMessage())->withInput();
    }
}


    public function dashboard()
    {
        try {
            $intern = Auth::guard('intern')->user();
            $tasks = $intern->tasks()->with('comments.intern')->get();
            
            return view('intern.dashboard', compact('tasks'));
        } catch (Exception $e) {
            return back()->with('error', 'Error loading dashboard: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        try {
            Auth::guard('intern')->logout();
            return redirect()->route('intern.login')->with('success', 'Successfully logged out!');
        } catch (Exception $e) {
            return back()->with('error', 'Logout failed: ' . $e->getMessage());
        }
    }
}
