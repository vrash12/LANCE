<?php

namespace App\Http\Controllers;

use App\Models\OpdForm;
use App\Models\OpdSubmission;
use Illuminate\Http\Request;

class FollowUpOpdFormController extends Controller
{
    public function __construct()
    {
        // only authenticated users
        $this->middleware('auth');
    }

    /**
     * Display a listing of follow-up submissions.
     */
    public function index()
    {
        $submissions = OpdSubmission::with('patient.user', 'form')
            ->whereHas('form', fn($q) => $q->where('form_no', 'OPD-F-08'))
            ->latest()
            ->get();

        return view('opd_forms.follow_up.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new follow-up submission.
     */
    public function create()
    {
        return view('opd_forms.follow_up.create', [
            'opd_form'    => null,
            'postRoute'   => route('follow-up-opd-forms.store'),
            'showButtons' => true,
        ]);
    }

    /**
     * Store a newly created follow-up submission.
     */
    public function store(Request $request)
    {
        // fetch the OPD-F-08 template
        $template = OpdForm::where('form_no', 'OPD-F-08')->firstOrFail();

        // validation rules for patient header + follow-ups
        $rules = [
            'last_name'             => 'nullable|string|max:255',
            'given_name'            => 'nullable|string|max:255',
            'middle_name'           => 'nullable|string|max:255',
            'age'                   => 'nullable|integer|min:0',
            'sex'                   => 'nullable|in:male,female',
            'birth_date'            => 'nullable|date',
            'followups'             => 'nullable|array',
            'followups.*.date'      => 'nullable|date',
            'followups.*.gest_weeks'=> 'nullable|integer|min:0',
            'followups.*.weight'    => 'nullable|numeric',
            'followups.*.bp'        => 'nullable|string|max:20',
            'followups.*.remarks'   => 'nullable|string',
        ];

        $data = $request->validate($rules);

        OpdSubmission::create([
            'form_id'    => $template->id,
            'user_id'    => auth()->id(),
            'patient_id' => null,    // or assign if you have a patient selector
            'answers'    => $data,
        ]);

        return redirect()
            ->route('follow-up-opd-forms.index')
            ->with('success', 'Follow-up record saved!');
    }

    /**
     * Display the specified submission.
     */
    public function show(OpdSubmission $submission)
    {
        $submission->load('form', 'patient.user');
        return view('opd_forms.follow_up.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified submission.
     */
    public function edit(OpdSubmission $submission)
    {
        $submission->load('form');
        return view('opd_forms.follow_up.edit', compact('submission'));
    }

    /**
     * Update the specified submission in storage.
     */
    public function update(Request $request, OpdSubmission $submission)
    {
        $rules = [
            'last_name'             => 'nullable|string|max:255',
            'given_name'            => 'nullable|string|max:255',
            'middle_name'           => 'nullable|string|max:255',
            'age'                   => 'nullable|integer|min:0',
            'sex'                   => 'nullable|in:male,female',
            'birth_date'            => 'nullable|date',
            'followups'             => 'nullable|array',
            'followups.*.date'      => 'nullable|date',
            'followups.*.gest_weeks'=> 'nullable|integer|min:0',
            'followups.*.weight'    => 'nullable|numeric',
            'followups.*.bp'        => 'nullable|string|max:20',
            'followups.*.remarks'   => 'nullable|string',
        ];

        $submission->answers = $request->validate($rules);
        $submission->save();

        return redirect()
            ->route('follow-up-opd-forms.index')
            ->with('success', 'Follow-up record updated!');
    }

    /**
     * Remove the specified submission from storage.
     */
    public function destroy(OpdSubmission $submission)
    {
        $submission->delete();
        return redirect()
            ->route('follow-up-opd-forms.index')
            ->with('success', 'Follow-up record deleted.');
    }
}
