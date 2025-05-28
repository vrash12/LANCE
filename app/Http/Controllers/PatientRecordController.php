<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\OpdSubmission;
use App\Models\PatientProfile;
use App\Exports\PatientRecordExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class PatientRecordController extends Controller
{
    public function __construct()
    {
        // Only admins can manage patient records
        $this->middleware(['auth','role:admin']);
    }


    /**
 * AJAX patient search for Select2.
 */
    public function search(Request $request)
    {
        $q = $request->input('q', '');

        $patients = Patient::with('profile')
            ->where('name', 'like', "%{$q}%")
            ->limit(20)
            ->get();

        $results = $patients->map(function($p) {
            // split “Last, Given” into two parts
            [$last, $given] = array_pad(explode(',', $p->name, 2), 2, '');

            return [
                'id'          => $p->id,
                'text'        => $p->name,              // what Select2 shows in dropdown
                'last_name'   => trim($last),
                'given_name'  => trim($given),
                'middle_name' => $p->profile->middle_name ?? '',
                'age'         => $p->birth_date
                                   ? now()->diffInYears($p->birth_date)
                                   : '',
                'sex'         => ucfirst($p->profile->sex ?? ''),
            ];
        });

        return response()->json(['results' => $results]);
    }


    /**
     * Display a listing of patients (with profiles).
     */
public function index()
{
    // 1) Fetch all OB-OPD submissions
    $submissions = OpdSubmission::with(['patient.user'])
        ->whereHas('form', fn($q) => $q->where('form_no', 'OPD-F-07'))
        ->get();

    // 2) Extract unique patients
    $patients = $submissions
        ->pluck('patient')       // get Patient models from each submission
        ->unique('id')           // only distinct patients
        ->values();              // re-index the collection

    // 3) Pass to the view
    return view('patients.index', compact('patients'));
}

    /**
     * Show the form for creating a new patient + profile.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created patient (and user + profile).
     */
    public function store(Request $request)
    {
        // 1) Validate user + patient fields
        $baseRules = [
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|confirmed|min:8',
            'name'       => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'contact_no' => 'nullable|string|max:50',
            'address'    => 'nullable|string|max:255',
        ];

        // 2) Validate profile fields
        $profileRules = [
            'sex'               => 'nullable|in:male,female',
            'religion'          => 'nullable|string|max:100',
            'date_recorded'     => 'nullable|date',
            'father_name'       => 'nullable|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name'       => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'place_of_marriage' => 'nullable|string|max:255',
            'date_of_marriage'  => 'nullable|date',
            'blood_type'        => 'nullable|string|max:3',
            'delivery_type'     => 'nullable|string|max:50',
            'birth_weight'      => 'nullable|numeric|min:0|max:20',
            'birth_length'      => 'nullable|numeric|min:0|max:100',
            'apgar_appearance'  => 'nullable|integer|between:0,2',
            'apgar_pulse'       => 'nullable|integer|between:0,2',
            'apgar_grimace'     => 'nullable|integer|between:0,2',
            'apgar_activity'    => 'nullable|integer|between:0,2',
            'apgar_respiration' => 'nullable|integer|between:0,2',
        ];

        $data = $request->validate(array_merge($baseRules, $profileRules));

        // 3) Create the user
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'patient',
        ]);

        // 4) Create the patient
        $patient = Patient::create([
            'user_id'    => $user->id,
            'name'       => $data['name'],
            'birth_date' => $data['birth_date'] ?? null,
            'contact_no' => $data['contact_no'] ?? null,
            'address'    => $data['address'] ?? null,
        ]);

        // 5) Create the profile
        $patient->profile()->create(
            $request->only(array_keys($profileRules))
        );

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient added successfully.');
    }

    /**
     * Display the specified patient profile.
     */
    public function show(Patient $patient)
    {
        $patient->load(['user', 'profile', 'visits']);
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified patient+user.
     */
    public function edit(Patient $patient)
    {
        $patient->load(['user', 'profile']);
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient and profile in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        // 1) Validate user fields
        $baseRules = [
            'email'      => "required|email|unique:users,email,{$patient->user_id}",
            'password'   => 'nullable|confirmed|min:8',
            'name'       => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'contact_no' => 'nullable|string|max:50',
            'address'    => 'nullable|string|max:255',
        ];

        // 2) Same profile rules as store
        $profileRules = [
            'sex'               => 'nullable|in:male,female',
            'religion'          => 'nullable|string|max:100',
            'date_recorded'     => 'nullable|date',
            'father_name'       => 'nullable|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name'       => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'place_of_marriage' => 'nullable|string|max:255',
            'date_of_marriage'  => 'nullable|date',
            'blood_type'        => 'nullable|string|max:3',
            'delivery_type'     => 'nullable|string|max:50',
            'birth_weight'      => 'nullable|numeric|min:0|max:20',
            'birth_length'      => 'nullable|numeric|min:0|max:100',
            'apgar_appearance'  => 'nullable|integer|between:0,2',
            'apgar_pulse'       => 'nullable|integer|between:0,2',
            'apgar_grimace'     => 'nullable|integer|between:0,2',
            'apgar_activity'    => 'nullable|integer|between:0,2',
            'apgar_respiration' => 'nullable|integer|between:0,2',
        ];

        $data = $request->validate(array_merge($baseRules, $profileRules));

        // 3) Update user
        $user = $patient->user;
        $user->update([
            'name'  => $data['name'],
            'email' => $data['email'],
        ]);
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
            $user->save();
        }

        // 4) Update patient
        $patient->update([
            'name'       => $data['name'],
            'birth_date' => $data['birth_date'] ?? null,
            'contact_no' => $data['contact_no'] ?? null,
            'address'    => $data['address'] ?? null,
        ]);

        // 5) Update or create profile
        $patient->profile()
                ->updateOrCreate([], $request->only(array_keys($profileRules)));

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified patient (and user) from storage.
     */
    public function destroy(Patient $patient)
    {
        // also remove the linked User
        $patient->user()->delete();
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient deleted.');
    }

    /**
     * Export a single patient record (and visits) to Excel.
     */
    public function exportExcel(Patient $patient)
    {
        $patient->load(['user','visits']);
        return Excel::download(
            new PatientRecordExport($patient),
            "patient-{$patient->id}-record.xlsx"
        );
    }

    /**
     * Export a single patient record (and visits) to PDF.
     */
    public function exportPdf(Patient $patient)
    {
        $patient->load(['user','visits']);
        $pdf = PDF::loadView('patients.pdf', compact('patient'))
                  ->setPaper('a4','portrait');

        return $pdf->download("patient-{$patient->id}-record.pdf");
    }
}
