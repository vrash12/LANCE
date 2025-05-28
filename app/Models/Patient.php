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



  public function visits()
    {
        return $this->hasMany(Token::class)
                    ->whereNotNull('served_at')
                    ->orderBy('served_at','desc');
    }
        protected $guarded = [];

    public function profile()
    {
        return $this->hasOne(PatientProfile::class);
    }
    public function profiles()
{
    return $this->hasMany(PatientProfile::class);
}
}
