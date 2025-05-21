<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Allow mass-assignment on these fields
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Hide these when serializing
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function patient()
{
    return $this->hasOne(\App\Models\Patient::class);
}

}


