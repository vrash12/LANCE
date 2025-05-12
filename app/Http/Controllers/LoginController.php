<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('login');  // we'll create resources/views/login.blade.php
    }

    // Handle the login attempt
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Regenerate session to prevent fixation
            $request->session()->regenerate();

            return redirect()->intended('/home');
        }

        return back()
            ->withErrors(['email' => 'Invalid credentials.'])
            ->withInput($request->only('email'));
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
