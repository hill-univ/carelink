<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Login Form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Process Login
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8',
    ], [
        'email.required' => 'Email is required',
        'email.email' => 'Please enter a valid email address',
        'password.required' => 'Password is required',
        'password.min' => 'Password must be at least 8 characters',
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

        // Redirect based on role
        if (Auth::user()->isAdmin()) {
            return redirect()->intended('/admin/dashboard');
        } else {
            return redirect()->intended('/client/dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->withInput($request->only('email'));
}

    // Show Register Form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Process Registration
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                'regex:/^[a-zA-Z\s]+$/', // Only letters and spaces
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', // Valid email format
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9]{10,15}$/', // 10-15 digits only
            ],
            'address' => [
                'required',
                'string',
                'min:10',
                'max:500',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', // Must contain uppercase, lowercase, and number
            ],
        ], [
            // Name
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name cannot exceed 255 characters',
            'name.regex' => 'Name can only contain letters and spaces',
            
            // Email
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'email.regex' => 'Please enter a valid email format (e.g., user@example.com)',
            
            // Phone
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Phone number must be 10-15 digits only (e.g., 08123456789)',
            
            // Address
            'address.required' => 'Address is required',
            'address.min' => 'Address must be at least 10 characters',
            'address.max' => 'Address cannot exceed 500 characters',
            
            // Password
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'client',
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ]);

        Auth::login($user);

        return redirect('/client/dashboard')
            ->with('success', 'Registration successful! Welcome to CareLink.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}