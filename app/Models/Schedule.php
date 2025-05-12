<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'staff_name',
        'role',
        'date',
        'shift_start',
        'shift_end',
        'department',
    ];
}
