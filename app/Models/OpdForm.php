<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'form_no',
        'department',
    ];
}
