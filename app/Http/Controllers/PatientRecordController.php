<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function index()
    {
        $patients = Patient::orderBy('name')->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'contact_no' => 'nullable|string|max:50',
            'address'    => 'nullable|string|max:255',
        ]);

        Patient::create($data);
        return redirect()->route('patients.index')
                         ->with('success', 'Patient added successfully.');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'birth_date' => 'nullable|date',
            'contact_no' => 'nullable|string|max:50',
            'address'    => 'nullable|string|max:255',
        ]);

        $patient->update($data);
        return redirect()->route('patients.index')
                         ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')
                         ->with('success', 'Patient deleted.');
    }
}
