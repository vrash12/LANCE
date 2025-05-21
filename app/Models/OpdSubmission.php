<?php 
// app/Models/OpdSubmission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpdSubmission extends Model
{
    protected $fillable = [
      'user_id','patient_id','form_id','answers'
    ];

    public function form()    { return $this->belongsTo(OpdForm::class,   'form_id'); }
    public function patient() { return $this->belongsTo(Patient::class,   'patient_id'); }
    public function user()    { return $this->belongsTo(User::class,      'user_id'); }
}

