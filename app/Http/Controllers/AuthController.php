<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show registration form
    public function showRegister() {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request) {
        $request->validate([
            'school_name' => 'required|string',
            'principal_name' => 'required|string',
            'email' => 'required|email|unique:schools,email',
            'password' => 'required|min:6',
            'address' => 'required|string',
            'phone' => 'required|string'
        ]);

        // Save to MongoDB
        School::create([
            'school_name' => $request->school_name,
            'principal_name' => $request->principal_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => 'pending' // Add this line
        ]);

        // Redirect to login page with a message
        return redirect('/login')->with('success', 'Registration successful! Please wait for admin approval.');
    }

    // Show login form
    public function showLogin() {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $school = School::where('email', $request->email)->first();

        if (!$school || !Hash::check($request->password, $school->password)) {
            return back()->with('error', 'Invalid credentials!');
        }

        // Check if the school is approved
        if ($school->status !== 'approved') {
            return back()->with('error', 'Your account is pending approval.');
        }

        // Store school in session
        session(['school' => $school]);

        return redirect('/dashboard');
    }

    // Logout
    public function logout() {
        session()->forget('school');
        return redirect('/login');
    }
}
