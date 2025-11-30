<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'company' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Create user account immediately without email verification
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'company' => $request->company,
            'email_verified_at' => now(), // Mark email as verified immediately
        ]);

        // Check if email is admin email and assign admin role
        if ($request->email === 'admin@gmail.com') {
            $adminRole = Role::firstOrCreate(
                ['slug' => 'admin'],
                ['name' => 'Admin', 'description' => 'Full access to the system']
            );
            $user->assignRole($adminRole);
            Auth::login($user);
            return redirect()->route('admin.dashboard')->with('success', 'Admin account created successfully!');
        }

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Account created successfully!');
    }

    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            // Check if user is admin and redirect accordingly
            $user = Auth::user();
            if ($user) {
                try {
                    if ($user->hasRole('admin')) {
                        return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
                    }
                } catch (\Exception $e) {
                    // If hasRole fails, just redirect to regular dashboard
                }
            }
            
            return redirect()->route('dashboard')->with('success', 'Welcome back!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out.');
    }
}
