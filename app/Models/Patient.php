<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'contact_no',
        'address',
    ];

    /**
     * Link back to the User record.
     */
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

    /**
     * Get the visit history.
     */
    public function visits()
    {
        return $this->hasMany(PatientVisit::class)
                    ->orderBy('visited_at','desc');
    }
        protected $guarded = [];

    public function profile()
    {
        return $this->hasOne(PatientProfile::class);
    }
}
