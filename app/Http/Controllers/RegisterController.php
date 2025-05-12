<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /** Validator for incoming registration requests. */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:admin,encoder,patient'],
        ]);
    }

    /** Create a new user instance. */
    protected function create(array $data)
    {
        return User::create([
            'name'  => $data['name'],
            'email' => $data['email'],
            'role'  => $data['role'],          // ⬅ allow admin to choose a role
            'password' => Hash::make($data['password']),
        ]);
    }
}
