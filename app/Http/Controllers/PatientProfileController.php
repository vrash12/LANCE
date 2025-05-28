<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientProfile;

class PatientProfileController extends Controller
{
    /**
     * Only admins and encoders may create patient profiles.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:encoder|admin']);
    }

    /**
     * Store a newly created patient profile in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient       $patient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Patient $patient)
    {
        $rules = [
            // demographic & metadata
            'sex'                       => 'nullable|in:male,female',
            'religion'                 => 'nullable|string|max:100',
            'date_recorded'            => 'nullable|date',

            // parent info
            'father_name'              => 'nullable|string|max:255',
            'father_occupation'        => 'nullable|string|max:255',
            'mother_name'              => 'nullable|string|max:255',
            'mother_occupation'        => 'nullable|string|max:255',

            // marriage
            'place_of_marriage'        => 'nullable|string|max:255',
            'date_of_marriage'         => 'nullable|date',

            // tetanus toxoid (T1–T5)
            'tetanus_t1_date'          => 'nullable|date',
            'tetanus_t1_signature'     => 'nullable|string|max:255',
            'tetanus_t2_date'          => 'nullable|date',
            'tetanus_t2_signature'     => 'nullable|string|max:255',
            'tetanus_t3_date'          => 'nullable|date',
            'tetanus_t3_signature'     => 'nullable|string|max:255',
            'tetanus_t4_date'          => 'nullable|date',
            'tetanus_t4_signature'     => 'nullable|string|max:255',
            'tetanus_t5_date'          => 'nullable|date',
            'tetanus_t5_signature'     => 'nullable|string|max:255',

            // checklists
            'present_health_problems'  => 'nullable|array',
            'present_health_problems.*'=> 'nullable|string|max:100',
            'present_problems_other'   => 'nullable|string|max:255',
            'danger_signs'             => 'nullable|array',
            'danger_signs.*'           => 'nullable|string|max:100',
            'danger_signs_other'       => 'nullable|string|max:255',

            // obstetric history
            'ob_history'               => 'nullable|array',
            'ob_history.*.date'        => 'nullable|date',
            'ob_history.*.delivery_type'=> 'nullable|string|max:100',
            'ob_history.*.outcome'     => 'nullable|string|max:100',
            'ob_history.*.cx'          => 'nullable|string|max:50',

            // family planning & PNC
            'family_planning'          => 'nullable|in:Pills,IUD,Injectable,Withdrawal,Standard',
            'prev_pnc'                 => 'nullable|in:Private,MD,HC,TBA',

            // pregnancy dates & counts
            'lmp'                      => 'nullable|date',
            'edc'                      => 'nullable|date',
            'gravida'                  => 'nullable|integer|min:0',
            'parity_t'                 => 'nullable|integer|min:0',
            'parity_p'                 => 'nullable|integer|min:0',
            'parity_a'                 => 'nullable|integer|min:0',
            'parity_l'                 => 'nullable|integer|min:0',
            'aog_weeks'                => 'nullable|integer|min:0',

            // narrative & logs
            'chief_complaint'          => 'nullable|string',
            'physical_exam_log'        => 'nullable|array',
            'physical_exam_log.*.date' => 'nullable|date',
            'physical_exam_log.*.weight'=> 'nullable|numeric',
            'physical_exam_log.*.bp'   => 'nullable|string|max:20',

            // system exams
            'heent'                    => 'nullable|string',
            'heart_lungs'              => 'nullable|string',

            // diagnosis & preparation
            'diagnosis'                => 'nullable|string',
            'prepared_by'              => 'nullable|string|max:255',

            // additional clinical data
            'contact_no'               => 'nullable|string|max:50',
            'blood_type'               => 'nullable|string|max:3',
            'delivery_type'            => 'nullable|string|max:50',
            'birth_weight'             => 'nullable|numeric',
            'birth_length'             => 'nullable|numeric',
            'apgar_appearance'         => 'nullable|integer|min:0|max:10',
            'apgar_pulse'              => 'nullable|integer|min:0|max:10',
            'apgar_grimace'            => 'nullable|integer|min:0|max:10',
            'apgar_activity'           => 'nullable|integer|min:0|max:10',
            'apgar_respiration'        => 'nullable|integer|min:0|max:10',
        ];

        // Validate the incoming request...
        $data = $request->validate($rules);

        // Create the profile under the given patient
        $patient->profiles()->create($data);

        return back()->with('success', 'Patient profile saved.');
    }
}
