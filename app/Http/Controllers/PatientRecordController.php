<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Exports\PatientRecordExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PatientRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

// app/Http/Controllers/PatientRecordController.php
public function index()
{
    // ❶ Pull every patient-role user
    $users = \App\Models\User::where('role', 'patient')
                ->orderBy('name')
                ->get();

    // ❷ For any user that does NOT have a patient row yet,
    //    create a bare-bones record so the UI can edit it
    $users->each(function ($u) {
        if (!$u->patient) {
            $u->patient = \App\Models\Patient::create([
                'user_id'    => $u->id,
                'name'       => $u->name,   // you can copy other defaults, too
                'birth_date' => null,
                'contact_no' => null,
                'address'    => null,
            ]);
        }
    });

    // ❸ Eager-load the relation so Blade can call $user->patient->id, etc.
    $users->load('patient');

    return view('patients.index', compact('users'));
}



    // SHOW CREATE FORM
    public function create()
    {
        return view('patients.create');
    }

   public function store(Request $request)
    {
        // 1) base validation for user + patient
        $baseRules = [
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|confirmed|min:8',
            'name'          => 'required|string|max:255',
            'birth_date'    => 'nullable|date',
            'address'       => 'nullable|string|max:255',
        ];

        // 2) validation for the profile fields
        $profileRules = [
            'sex'                => 'nullable|in:male,female',
            'religion'           => 'nullable|string|max:100',
            'date_recorded'      => 'nullable|date',
            'father_name'        => 'nullable|string|max:255',
            'father_occupation'  => 'nullable|string|max:255',
            'mother_name'        => 'nullable|string|max:255',
            'mother_occupation'  => 'nullable|string|max:255',
            'place_of_marriage'  => 'nullable|string|max:255',
            'date_of_marriage'   => 'nullable|date',
            'contact_no'         => 'nullable|string|max:50',
            'blood_type'         => 'nullable|string|max:3',
            'delivery_type'      => 'nullable|string|max:50',
            'birth_weight'       => 'nullable|numeric|min:0|max:20',
            'birth_length'       => 'nullable|numeric|min:0|max:100',
            'apgar_appearance'   => 'nullable|integer|between:0,2',
            'apgar_pulse'        => 'nullable|integer|between:0,2',
            'apgar_grimace'      => 'nullable|integer|between:0,2',
            'apgar_activity'     => 'nullable|integer|between:0,2',
            'apgar_respiration'  => 'nullable|integer|between:0,2',
        ];

        $data = $request->validate(array_merge($baseRules, $profileRules));

        // 3) create the User
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'patient'
        ]);

        // 4) create the Patient
        $patient = Patient::create([
            'user_id'    => $user->id,
            'name'       => $data['name'],
            'birth_date' => $data['birth_date'] ?? null,
            'contact_no' => $data['contact_no'] ?? null,
            'address'    => $data['address'] ?? null,
        ]);

        // 5) create the PatientProfile
        $patient->profile()->create($request->only(array_keys($profileRules)));

        return redirect()
            ->route('patients.index')
            ->with('success','Patient added successfully.');
    }


 public function show(Patient $patient)
{
    $patient->load(['profile','user','visits']);
    return view('patients.show', compact('patient'));
}

public function edit(Patient $patient)
{
    $patient->load(['profile','user']);
    return view('patients.edit', compact('patient'));
}


    // UPDATE PATIENT & their User record
     public function update(Request $request, Patient $patient)
    {
        // 1) base validation for email/name/password
        $baseRules = [
            'email'         => "required|email|unique:users,email,{$patient->user_id}",
            'password'      => 'nullable|confirmed|min:8',
            'name'          => 'required|string|max:255',
            'birth_date'    => 'nullable|date',
            'address'       => 'nullable|string|max:255',
        ];

        // 2) same profile rules as above
        $profileRules = [
            'sex'                => 'nullable|in:male,female',
            'religion'           => 'nullable|string|max:100',
            'date_recorded'      => 'nullable|date',
            'father_name'        => 'nullable|string|max:255',
            'father_occupation'  => 'nullable|string|max:255',
            'mother_name'        => 'nullable|string|max:255',
            'mother_occupation'  => 'nullable|string|max:255',
            'place_of_marriage'  => 'nullable|string|max:255',
            'date_of_marriage'   => 'nullable|date',
            'contact_no'         => 'nullable|string|max:50',
            'blood_type'         => 'nullable|string|max:3',
            'delivery_type'      => 'nullable|string|max:50',
            'birth_weight'       => 'nullable|numeric|min:0|max:20',
            'birth_length'       => 'nullable|numeric|min:0|max:100',
            'apgar_appearance'   => 'nullable|integer|between:0,2',
            'apgar_pulse'        => 'nullable|integer|between:0,2',
            'apgar_grimace'      => 'nullable|integer|between:0,2',
            'apgar_activity'     => 'nullable|integer|between:0,2',
            'apgar_respiration'  => 'nullable|integer|between:0,2',
        ];

        $data = $request->validate(array_merge($baseRules, $profileRules));

        // 3) update User
        $user = $patient->user;
        $user->name  = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // 4) update Patient
        $patient->update([
            'name'       => $data['name'],
            'birth_date' => $data['birth_date'] ?? null,
            'contact_no' => $data['contact_no'] ?? null,
            'address'    => $data['address'] ?? null,
        ]);

        // 5) updateOrCreate PatientProfile
        $patient->profile()
                ->updateOrCreate([], $request->only(array_keys($profileRules)));

        return redirect()
            ->route('patients.index')
            ->with('success','Patient updated successfully.');
    }

    // DELETE PATIENT (and optionally their User)
    public function destroy(Patient $patient)
    {
        // if you want to delete the user as well:
        $patient->user()->delete();
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success','Patient deleted.');
    }

    // EXPORT SINGLE PATIENT + HISTORY TO EXCEL
    public function exportExcel(Patient $patient)
    {
        $patient->load(['visits','user']);

        return Excel::download(
            new PatientRecordExport($patient),
            "patient-{$patient->id}-record.xlsx"
        );
    }

    // EXPORT SINGLE PATIENT + HISTORY TO PDF
    public function exportPdf(Patient $patient)
    {
        $patient->load(['visits','user']);

        $pdf = PDF::loadView('patients.pdf', compact('patient'))
                  ->setPaper('a4','portrait');

        return $pdf->download("patient-{$patient->id}-record.pdf");
    }
}
