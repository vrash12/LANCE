<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'visited_at',
        'notes',
    ];

    /**
     * A visit belongs to a patient.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
