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

    // LIST VIEW
    public function index()
    {
        $patients = Patient::with('user')->orderBy('name')->get();
        return view('patients.index', compact('patients'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        return view('patients.create');
    }

    // STORE NEW PATIENT (and linked User)
    public function store(Request $request)
    {
        $data = $request->validate([
            'email'               => 'required|email|unique:users,email',
            'password'            => 'required|confirmed|min:8',
            'name'                => 'required|string|max:255',
            'birth_date'          => 'nullable|date',
            'contact_no'          => 'nullable|string|max:50',
            'address'             => 'nullable|string|max:255',
        ]);

        // 1) create the User
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'patient',
        ]);

        // 2) create the Patient profile
        Patient::create([
            'user_id'    => $user->id,
            'name'       => $data['name'],
            'birth_date' => $data['birth_date'],
            'contact_no' => $data['contact_no'],
            'address'    => $data['address'],
        ]);

        return redirect()
            ->route('patients.index')
            ->with('success','Patient added successfully.');
    }

    // SHOW SINGLE PATIENT + VISIT HISTORY
    public function show(Patient $patient)
    {
        $patient->load(['visits','user']);
        return view('patients.show', compact('patient'));
    }

    // SHOW EDIT FORM
    public function edit(Patient $patient)
    {
        $patient->load('user');
        return view('patients.edit', compact('patient'));
    }

    // UPDATE PATIENT & their User record
    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'email'               => "required|email|unique:users,email,{$patient->user_id}",
            'password'            => 'nullable|confirmed|min:8',
            'name'                => 'required|string|max:255',
            'birth_date'          => 'nullable|date',
            'contact_no'          => 'nullable|string|max:50',
            'address'             => 'nullable|string|max:255',
        ]);

        // update User
        $user = $patient->user;
        $user->name  = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // update Patient
        $patient->update([
            'name'       => $data['name'],
            'birth_date' => $data['birth_date'],
            'contact_no' => $data['contact_no'],
            'address'    => $data['address'],
        ]);

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
