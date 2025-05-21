<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;            // handles token check + password update

    /** Where to redirect users after resetting password. */
    protected $redirectTo = '/home';
}
