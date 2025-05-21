<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    // allow mass assignment on these columns
    protected $fillable = [
        'department_id',
        'code',
        'served_at',
    ];
protected $dates = [
        'created_at',
        'updated_at',
        'served_at',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

        protected $casts = [
        'served_at' => 'datetime',
    ];
}
