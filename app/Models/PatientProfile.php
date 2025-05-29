<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    protected $guarded = [];

    protected $casts = [
        'present_health_problems' => 'array',
        'danger_signs'            => 'array',
        'ob_history'              => 'array',
        'physical_exam_log'       => 'array',
        'date_recorded' => 'date',
    ];

    /**
     * Inverse relation → the patient that owns this profile.
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
