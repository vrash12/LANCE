<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     * @var string
     */
 

        protected function authenticated(Request $request, $user)
    {
        // send patients to patient dashboard
        if ($user->role === 'patient') {
            return redirect()->route('patient.dashboard');
        }

        // send encoders to their OPD form index
        if ($user->role === 'encoder') {
            return redirect()->route('encoder.opd.index');
        }

        // everyone else (admins) goes to /home
        return redirect()->route('home');
    }

    /**
     * Show the application login form.
     */

     
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     */


    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Get the guard to be used during authentication.
     */
    protected function guard()
    {
        return auth()->guard();
    }

  
}