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
        'shift_start_sunday',
        'shift_end_sunday',
        'shift_start_monday',
        'shift_end_monday',
        'shift_start_tuesday',
        'shift_end_tuesday',
        'shift_start_wednesday',
        'shift_end_wednesday',
        'shift_start_thursday',
        'shift_end_thursday',
        'shift_start_friday',
        'shift_end_friday',
        'shift_start_saturday',
        'shift_end_saturday',
        'start_day',
        'shift_length',
        'include_sunday',
        'include_monday',
        'include_tuesday',
        'include_wednesday',
        'include_thursday',
        'include_friday',
        'include_saturday',
        'department',
    ];

    // 2️⃣ Tell Eloquent to cast those columns to Carbon/date types:
    protected $casts = [
        'date'        => 'date',        // cast to a Carbon date
        'shift_start_sunday'    => 'datetime:H:i',
        'shift_end_sunday'      => 'datetime:H:i',
        'shift_start_monday'    => 'datetime:H:i',
        'shift_end_monday'      => 'datetime:H:i',
        'shift_start_tuesday'   => 'datetime:H:i',
        'shift_end_tuesday'     => 'datetime:H:i',
        'shift_start_wednesday' => 'datetime:H:i',
        'shift_end_wednesday'   => 'datetime:H:i',
        'shift_start_thursday'  => 'datetime:H:i',
        'shift_end_thursday'    => 'datetime:H:i',
        'shift_start_friday'    => 'datetime:H:i',
        'shift_end_friday'      => 'datetime:H:i',
        'shift_start_saturday'  => 'datetime:H:i',
        'shift_end_saturday'    => 'datetime:H:i',
        'start_day' => 'string',
        'shift_length' => 'decimal:2',
        'include_sunday' => 'boolean',
        'include_monday' => 'boolean',
        'include_tuesday' => 'boolean',
        'include_wednesday' => 'boolean',
        'include_thursday' => 'boolean',
        'include_friday' => 'boolean',
        'include_saturday' => 'boolean',
    ];
}
