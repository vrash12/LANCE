<?php
// app/Models/Schedule.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    // 1️⃣ Whitelist your fillable attributes:
    protected $fillable = [
        'staff_name',
        'role',
        'date',
        'shift_start',
        'shift_end',
        'department',
    ];

    // 2️⃣ Tell Eloquent to cast those columns to Carbon/date types:
    protected $casts = [
        'date'        => 'date',        // cast to a Carbon date
        'shift_start' => 'datetime:H:i',// cast to Carbon with only hour:minute
        'shift_end'   => 'datetime:H:i',// same here
    ];
}
