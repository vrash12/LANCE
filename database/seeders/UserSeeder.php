<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::insert([
            [
                'name'       => 'Admin User',
                'email'      => 'admin@fabellacares.com',
                'password'   => Hash::make('password'),
                'role'       => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Encoder User',
                'email'      => 'encoder@fabellacares.com',
                'password'   => Hash::make('password'),
                'role'       => 'encoder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Patient User',
                'email'      => 'patient@fabellacares.com',
                'password'   => Hash::make('password'),
                'role'       => 'patient',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
