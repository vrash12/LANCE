<?php

namespace App\Http\Controllers;

use App\Models\OpdForm;
use App\Models\OpdSubmission;
use Illuminate\Http\Request;

class OpdSubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // only patients can fill forms
        $this->middleware('role:patient')->only(['create','store']);

        // only admin can view/list/delete submissions
        $this->middleware('role:admin')->only(['index','show','destroy']);
    }

    /** Admin: list all submissions */
    public function index()
    {
        $subs = OpdSubmission::with(['form','patient'])->latest()->paginate(15);
        return view('opd_submissions.index', compact('subs'));
    }

    /** Patient: show the fill‐out form */
    public function create(OpdForm $opd_form)
    {
        return view('opd_submissions.create', compact('opd_form'));
    }

    /** Patient: handle submission */
    public function store(Request $request, OpdForm $opd_form)
    {
        $data = $request->validate([
            'responses' => 'required|string',
        ]);

        OpdSubmission::create([
            'opd_form_id' => $opd_form->id,
            'patient_id'  => $request->user()->patient->id,
            'responses'   => json_encode($data['responses']),
        ]);

        return redirect()
            ->route('home')
            ->with('success','Form submitted successfully.');
    }

    /** Admin: view one submission */
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
