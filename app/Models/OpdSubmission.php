<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpdSubmission extends Model
{
    // explicit table name (since Laravel will otherwise look for `opd_submissions`)
    protected $table = 'opd_submissions';

    protected $fillable = [
        'user_id',
        'patient_id',
        'form_id',
        'answers',    // ← JSON payload of their filled-out fields
    ];

    protected $casts = [
        'answers' => 'array',  // ← automatically decode JSON to PHP array
    ];

    public function form()
    {
        return $this->belongsTo(OpdForm::class, 'form_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function show(OpdSubmission $submission)
{
    $submission->load(['form','user']);
    return view('opd_submissions.show', compact('submission'));
}
}
