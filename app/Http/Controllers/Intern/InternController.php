<?php



namespace App\Http\Controllers\Intern;

use App\Http\Controllers\Controller;
use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InternController extends Controller
{
    // Show the registration form
    public function showRegistrationForm()
    {
        return view('intern.auth.register');
    }

    // Handle the registration process
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:interns',
            'password' => 'required|string|min:8|confirmed',
        ]);

        
        $intern = Intern::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

      
        
        Auth::guard('intern')
            ->login($intern);

        return redirect()->route('intern.dashboard');
    }

  
    public function showLoginForm()
    {
        return view('intern.auth.login');
    }

  
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('intern')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('intern.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    // Intern dashboard after successful login
    public function dashboard()
    {
        $intern = Auth::guard('intern')->user();
        $tasks = $intern->tasks()->with('comments.intern')->get();
    
        return view('intern.dashboard', compact('tasks'));
    }

    // Handle the logout
    public function logout()
    {
        Auth::guard('intern')->logout();
        return redirect()->route('intern.login');
    }
}
