<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        // only signed-in users may change password
        $this->middleware('auth');
    }

    /** Show the change-pw form */
    public function show()
    {
        return view('auth.change_password');
    }

    /** Handle the form POST */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'current_password'      => ['required'],
            'password'              => ['required','string','min:8','confirmed'],
        ]);

        // verify current password
        if (! Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // update
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('home')->with('success','Password changed successfully.');
    }
}
