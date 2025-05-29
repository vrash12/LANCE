<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
public function index()
{
    $users = User::orderBy('role')      // admins & encoders only
                 ->orderBy('name')
                 ->whereIn('role', ['admin','encoder'])
                 ->get();

    return view('users.index', compact('users'));
}
 // Show the form for creating a new user
    public function create()
    {
        return view('users.create');
    }

  public function store(Request $request)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        // only admin & encoder allowed now
        'role'     => 'required|in:admin,encoder',
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'role'     => $data['role'],
        'password' => Hash::make($data['password']),
    ]);

    return redirect()->route('users.index')
                     ->with('success','User created successfully.');
}



    // Show the form for editing the specified user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

   public function update(Request $request, User $user)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => "required|email|unique:users,email,{$user->id}",
        // only admin & encoder
        'role'     => 'required|in:admin,encoder',
        'password' => 'nullable|string|min:8|confirmed',
    ]);

    $user->fill([
        'name'  => $data['name'],
        'email' => $data['email'],
        'role'  => $data['role'],
    ]);
    if (!empty($data['password'])) {
        $user->password = Hash::make($data['password']);
    }
    $user->save();

    return redirect()->route('users.index')
                     ->with('success','User updated successfully.');
}

    // Remove the specified user from storage
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()
            ->route('users.index')
            ->with('success','User deleted.');
    }
        public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}
