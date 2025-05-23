<?php
// app/Models/PatientProfile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    protected $guarded = [];   // or use $fillable for tighter control

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
