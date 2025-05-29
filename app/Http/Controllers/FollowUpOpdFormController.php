<?php
// app/Http/Controllers/FollowUpOpdFormController.php

namespace App\Http\Controllers;

use App\Models\OpdForm;
use App\Models\OpdSubmission;
use Illuminate\Http\Request;

class FollowUpOpdFormController extends Controller
{
    public function __construct()
    {
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
            'opd_form'  => null,
            'postRoute' => route('follow-up-opd-forms.store'),
        ]);
    }

    /**
     * Store a newly created follow-up submission.
     */
    public function store(Request $request)
    {
        $template = OpdForm::where('form_no', 'OPD-F-08')->firstOrFail();

        $validated = $request->validate([
            'patient_id'             => 'required|exists:patients,id',
            'last_name'              => 'nullable|string|max:255',
            'given_name'             => 'nullable|string|max:255',
            'middle_name'            => 'nullable|string|max:255',
            'age'                    => 'nullable|integer|min:0',
            'sex'                    => 'nullable|in:male,female',
            'followups'              => 'nullable|array',
            'followups.*.date'       => 'nullable|date',
            'followups.*.gest_weeks' => 'nullable|integer|min:0',
            'followups.*.weight'     => 'nullable|numeric',
            'followups.*.bp'         => 'nullable|string|max:20',
            'followups.*.remarks'    => 'nullable|string',
        ]);

        OpdSubmission::create([
            'form_id'    => $template->id,
            'user_id'    => auth()->id(),
            'patient_id' => $validated['patient_id'],
            'answers'    => $validated,
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
        return view('opd_forms.follow_up.edit', [
            'opd_form'  => $submission,
            'postRoute' => route('follow-up-opd-forms.update', $submission),
            'showButtons' => true,
        ]);
    }

    /**
     * Update the specified submission in storage.
     */
    public function update(Request $request, OpdSubmission $submission)
    {
        $validated = $request->validate([
            'patient_id'             => 'required|exists:patients,id',
            'last_name'              => 'nullable|string|max:255',
            'given_name'             => 'nullable|string|max:255',
            'middle_name'            => 'nullable|string|max:255',
            'age'                    => 'nullable|integer|min:0',
            'sex'                    => 'nullable|in:male,female',
            'followups'              => 'nullable|array',
            'followups.*.date'       => 'nullable|date',
            'followups.*.gest_weeks' => 'nullable|integer|min:0',
            'followups.*.weight'     => 'nullable|numeric',
            'followups.*.bp'         => 'nullable|string|max:20',
            'followups.*.remarks'    => 'nullable|string',
        ]);

        $submission->answers    = $validated;
        $submission->patient_id = $validated['patient_id'];
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
