<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Retrieve users ordered by name
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    // Additional methods (create, store, edit, update, destroy) go here...
}