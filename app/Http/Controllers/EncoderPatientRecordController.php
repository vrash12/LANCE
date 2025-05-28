<?php
// app/Http/Controllers/EncoderPatientRecordController.php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class EncoderPatientRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:encoder']);
    }

    /** GET /encoder/patients */
    public function index()
    {
        $patients = Patient::orderBy('name')->paginate(15);
        return view('encoder.patients.index', compact('patients'));
    }

    /** GET /encoder/patients/create */
    public function create()
    {
        return view('encoder.patients.create');
    }

    /** POST /encoder/patients */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'birth_date'  => 'nullable|date',
            'contact_no'  => 'nullable|string|max:50',
            'address'     => 'nullable|string|max:255',
        ]);

        Patient::create($data);

        return redirect()
            ->route('encoder.patients.index')
            ->with('success','Patient record created successfully.');
    }

    /** GET /encoder/patients/{patient} */
    public function show(Patient $patient)
    {
        return view('encoder.patients.show', compact('patient'));
    }

    /** GET /encoder/patients/{patient}/edit */
    public function edit(Patient $patient)
    {
        return view('encoder.patients.edit', compact('patient'));
    }

    /** PUT /encoder/patients/{patient} */
    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'birth_date'  => 'nullable|date',
            'contact_no'  => 'nullable|string|max:50',
            'address'     => 'nullable|string|max:255',
        ]);

        $patient->update($data);

        return redirect()
            ->route('encoder.patients.index')
            ->with('success','Patient record updated successfully.');
    }

    /** DELETE /encoder/patients/{patient} */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('encoder.patients.index')
            ->with('success','Patient record deleted.');
    }
}
