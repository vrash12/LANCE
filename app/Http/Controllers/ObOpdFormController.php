<?php

namespace App\Http\Controllers;

use App\Models\{OpdForm, OpdSubmission, Patient, Token, Department};
use Illuminate\Http\Request;

class ObOpdFormController extends Controller
{
    public function __construct()
    {
        // only logged-in users; routes themselves bypass RoleMiddleware
        $this->middleware('auth');
    }

    /**
     * 1. List all OB submissions (form_no = OPD-F-07)
     */
public function index()
{
    // ① bring back every submission of the OB template, with patient+user loaded
    $subs = OpdSubmission::with('patient.user', 'form')
        ->whereHas('form', fn($q) => $q->where('form_no', 'OPD-F-07'))
        ->latest()
        ->get();

    // ② extract patients, filter out nulls, make them unique
    $patients = $subs
        ->pluck('patient')          // collection of Patient|null
        ->filter()                  // removes every null automatically
        ->unique('id')              // keep one row per patient
        ->values();                 // reset the keys (0,1,2…)

    // ③ send to the same blade you’re already using
    return view('patients.index', compact('patients'));
}

    /**
     * 2. Show blank OB-OPD form
     */
    public function create()
    {
        return view('opd_forms.opdb.create', [
            'opd_form'   => null,
            'postRoute'  => route('ob-opd-forms.store'),
            'showButtons'=> true,
        ]);
    }

    /**
     * 3. Validate & store submission, then upsert Patient & Profile
     */
    public function store(Request $request)
    {
        // fetch the single OB template
        $template = OpdForm::where('department','OB')
                           ->where('form_no','OPD-F-07')
                           ->firstOrFail();

        // validation rules (only patient‐answer fields)
        $rules = [
            'date'                        => 'required|date',
            'time'                        => 'nullable|date_format:H:i',
            'record_no'                   => 'nullable|string|max:100',
            'last_name'                   => 'nullable|string|max:255',
            'given_name'                  => 'nullable|string|max:255',
            'middle_name'                 => 'nullable|string|max:255',
            'age'                         => 'nullable|integer|min:0',
            'sex'                         => 'nullable|in:male,female',
            'maiden_name'                 => 'nullable|string|max:255',
            'birth_date'                  => 'nullable|date',
            'place_of_birth'              => 'nullable|string|max:255',
            'civil_status'                => 'nullable|string|max:50',
            'occupation'                  => 'nullable|string|max:100',
            'religion'                    => 'nullable|string|max:100',
            'address'                     => 'nullable|string|max:255',
            'husband_name'                => 'nullable|string|max:255',
            'husband_occupation'          => 'nullable|string|max:255',
            'husband_contact'             => 'nullable|string|max:50',
            'place_of_marriage'           => 'nullable|string|max:255',
            'date_of_marriage'            => 'nullable|date',
            'tetanus.*.date'              => 'nullable|date',
            'tetanus.*.signature'         => 'nullable|string|max:255',
            'present_problems'            => 'nullable|array',
            'present_problems.*'          => 'nullable|string|max:100',
            'present_problems_other'      => 'nullable|string|max:255',
            'danger_signs'                => 'nullable|array',
            'danger_signs.*'              => 'nullable|string|max:100',
            'danger_signs_other'          => 'nullable|string|max:255',
            'ob_history'                  => 'nullable|array',
            'ob_history.*.date'           => 'nullable|date',
            'ob_history.*.delivery_type'  => 'nullable|string|max:100',
            'ob_history.*.outcome'        => 'nullable|string|max:100',
            'ob_history.*.cx'             => 'nullable|string|max:50',
            'family_planning'             => 'nullable|in:Pills,IUD,Injectable,Withdrawal,Standard',
            'prev_pnc'                    => 'nullable|in:Private,MD,HC,TBA',
            'lmp'                         => 'nullable|date',
            'edc'                         => 'nullable|date',
            'gravida'                     => 'nullable|integer|min:0',
            'parity_t'                    => 'nullable|integer|min:0',
            'parity_p'                    => 'nullable|integer|min:0',
            'parity_a'                    => 'nullable|integer|min:0',
            'parity_l'                    => 'nullable|integer|min:0',
            'aog_weeks'                   => 'nullable|integer|min:0',
            'chief_complaint'             => 'nullable|string',
            'physical_exam_log'           => 'nullable|array',
            'physical_exam_log.*.date'    => 'nullable|date',
            'physical_exam_log.*.weight'  => 'nullable|string|max:20',
            'physical_exam_log.*.bp'      => 'nullable|string|max:20',
            'heent'                       => 'nullable|string',
            'heart_lungs'                 => 'nullable|string',
            'diagnosis'                   => 'nullable|string',
            'prepared_by'                 => 'nullable|string|max:255',
        ];

        $data = $request->validate($rules);

        // save submission (no patient_id yet)
        $submission = OpdSubmission::create([
            'form_id'    => $template->id,
            'user_id'    => auth()->id(),
            'patient_id' => null,
            'answers'    => $data,
        ]);

        //
        // --- Patient upsert by name + birth_date (customize as needed) ---
        //
        $name      = trim("{$data['last_name']}, {$data['given_name']}");
        $birthDate = $data['birth_date'] ?? null;
               $patient = Patient::firstOrCreate(
            ['name'       => $name, 
             'birth_date' => $birthDate],
            ['contact_no' => $data['record_no'] ?? null,
             'address'    => $data['address']   ?? null]
        );

 if (! $patient->user_id) {
            $patient->user_id = auth()->id();
            $patient->save();
        }

        // attach patient to submission
        $submission->patient_id = $patient->id;
        $submission->save();

        //
        // --- Profile payload ---
        //
        $profile = [
            'sex'                     => $data['sex']               ?? null,
            'religion'                => $data['religion']          ?? null,
            'place_of_marriage'       => $data['place_of_marriage'] ?? null,
            'date_of_marriage'        => $data['date_of_marriage']  ?? null,
            'family_planning'         => $data['family_planning']   ?? null,
            'prev_pnc'                => $data['prev_pnc']          ?? null,
            'lmp'                     => $data['lmp']               ?? null,
            'edc'                     => $data['edc']               ?? null,
            'gravida'                 => $data['gravida']           ?? null,
            'parity_t'                => $data['parity_t']          ?? null,
            'parity_p'                => $data['parity_p']          ?? null,
            'parity_a'                => $data['parity_a']          ?? null,
            'parity_l'                => $data['parity_l']          ?? null,
            'aog_weeks'               => $data['aog_weeks']         ?? null,
            'chief_complaint'         => $data['chief_complaint']   ?? null,
            'heent'                   => $data['heent']             ?? null,
            'heart_lungs'             => $data['heart_lungs']       ?? null,
            'diagnosis'               => $data['diagnosis']         ?? null,
            'prepared_by'             => $data['prepared_by']       ?? null,
            'present_health_problems' => json_encode($data['present_problems']    ?? []),
            'present_problems_other'  => $data['present_problems_other']  ?? null,
            'danger_signs'            => json_encode($data['danger_signs']       ?? []),
            'danger_signs_other'      => $data['danger_signs_other']       ?? null,
            'ob_history'              => json_encode($data['ob_history']         ?? []),
            'physical_exam_log'       => json_encode($data['physical_exam_log']  ?? []),
        ];

        // flatten tetanus → tetanus_t1_date, tetanus_t1_signature, … t5
        foreach (($data['tetanus'] ?? []) as $i => $dose) {
            $n = $i + 1;
            $profile["tetanus_t{$n}_date"]      = $dose['date']      ?? null;
            $profile["tetanus_t{$n}_signature"] = $dose['signature'] ?? null;
        }

        // update or create the one profile row
        $patient->profile()
                ->updateOrCreate([], $profile);
$obDepartment = Department::where('short_name', 'OB')
                           ->orWhere('name', 'like', '%OB%')
                           ->first();

if ($obDepartment && $patient) {

    // is this patient already waiting?
    $hasLive = Token::where('department_id', $obDepartment->id)
                    ->where('patient_id',  $patient->id)
                    ->whereNull('served_at')
                    ->exists();

    if (! $hasLive) {
        // next incremental number
        $nextNum = Token::where('department_id', $obDepartment->id)->count() + 1;
        $code    = 'O' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        $token = Token::create([
            'department_id' => $obDepartment->id,
            'patient_id'    => $patient->id,
            'code'          => $code,
        ]);

        // drop it in the session so we can show / print it once
        session(['new_token_id' => $token->id]);
    }
}
        return redirect()
            ->route('ob-opd-forms.index')
            ->with('success','OB submission saved and patient profile updated!');
    }

    /**
     * 4. Show a single submission
     */
// In ObOpdFormController
public function show(OpdSubmission $submission)
{
    $submission->load('patient.user','patient.profile','patient.visits');
    $patient = $submission->patient;
    return view('patients.show', compact('patient'));
}


    /**
     * 5. Edit an OB submission
     */
    public function edit(OpdSubmission $submission)
    {
        $submission->load('form');
        return view('opd_forms.opdb.edit', compact('submission'));
    }

    /**
     * 6. Update an OB submission
     */
    public function update(Request $request, OpdSubmission $submission)
    {
        $rules = [
            'date'      => 'required|date',
            'time'      => 'nullable|date_format:H:i',
            // … (repeat your patient rules here as needed) …
        ];
        $data = $request->validate($rules);

        $submission->answers = $data;
        $submission->save();

        return redirect()
            ->route('ob-opd-forms.index')
            ->with('success','OB submission updated!');
    }

    /**
     * 7. Delete an OB submission
     */
    public function destroy(OpdSubmission $submission)
    {
        $submission->delete();

        return redirect()
            ->route('ob-opd-forms.index')
            ->with('success','OB submission deleted.');
    }
}
