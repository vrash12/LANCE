<?php

namespace App\Http\Controllers;

use App\Models\OpdForm;
use App\Models\OpdSubmission;
use Illuminate\Http\Request;

class OpdSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:patient'])
             ->only(['store']);
        $this->middleware(['auth','role:admin'])
             ->only(['index','show','destroy']);
    }
  public function index()
    {
        $subs = OpdSubmission::with('form','patient')->latest()->paginate(20);
        return view('opd_submissions.index', compact('subs'));
    }


    /** Patient: show the fill‐out form */
    public function create(OpdForm $opd_form)
    {
        return view('opd_submissions.create', compact('opd_form'));
    }

// Example: Store OPD form submission for patients
public function store(Request $request, OpdForm $opd_form)
{
    $questions = json_decode($opd_form->fields, true) ?: [];
    $rules = [];
    foreach ($questions as $i => $q) {
        $rules["answers.$i"] = (!empty($q['required']) ? 'required' : 'nullable') . '|string';
    }
    $data = $request->validate($rules);

    OpdSubmission::create([
        'user_id'    => auth()->id(),
        'patient_id' => auth()->user()->patient->id,
        'form_id'    => $opd_form->id,
        'answers'    => json_encode($data['answers']),
    ]);

    return redirect()
        ->route('patient.opd_forms.index')
        ->with('success', 'Thank you! Your form has been submitted.');
}


    public function show(OpdSubmission $opd_submission)
    {
        return view('opd_submissions.show', compact('opd_submission'));
    }

    /** Admin: delete a submission */
    public function destroy(OpdSubmission $opd_submission)
    {
        $opd_submission->delete();
        return back()->with('success','Submission deleted.');
    }
}
