<?php

namespace App\Http\Controllers;

use App\Models\OpdForm;
use App\Models\OpdSubmission;
use Illuminate\Http\Request;

class HighRiskOpdFormController extends Controller
{
    public function __construct()
    {
        // only authenticated users
        $this->middleware('auth');
    }

    /**
     * Display a listing of high-risk submissions.
     */
    public function index()
    {
        $submissions = OpdSubmission::with('patient.user', 'form')
            ->whereHas('form', fn($q) => $q->where('form_no', 'OPD-F-09'))
            ->latest()
            ->get();

        return view('opd_forms.high_risk.index', compact('submissions'));
    }

    /**
     * Show the form for creating a new high-risk submission.
     */
    public function create()
    {
        return view('opd_forms.high_risk.create', [
            'opd_form'    => null,
            'postRoute'   => route('high-risk-opd-forms.store'),
            'showButtons' => true,
        ]);
    }

    /**
     * Store a newly created high-risk submission.
     */
    public function store(Request $request)
    {
        // fetch the high-risk template
        $template = OpdForm::where('form_no','OPD-F-09')->firstOrFail();

        // validate only the fields we care about
        $rules = [
            // patient identifiers
             'patient_id'                   => 'nullable|exists:patients,id',
            'last_name'                     => 'nullable|string|max:255',
            'given_name'                    => 'nullable|string|max:255',
            'middle_name'                   => 'nullable|string|max:255',
            'age'                           => 'nullable|integer|min:0',
            'sex'                           => 'nullable|in:male,female',
            // checklist
            'risks'                         => 'nullable|array',
            'risks.*'                       => 'required|string',
            // “specify” fields for the “others_…” checkboxes
            'others_med_surg_specify'       => 'nullable|string|max:255',
            'others_generative_specify'     => 'nullable|string|max:255',
            'fetal_congenital_anomaly_specify' => 'nullable|string|max:255',
            'poor_ob_history_specify'       => 'nullable|string|max:255',
            'others_multiple_specify'       => 'nullable|string|max:255',
            'others_infection_specify'      => 'nullable|string|max:255',
        ];

        $data = $request->validate($rules);

        OpdSubmission::create([
            'form_id'    => $template->id,
            'user_id'    => auth()->id(),
            'patient_id' => auth()->user()->patient->id ?? null,
            'answers'    => $data,
        ]);

        return redirect()
            ->route('high-risk-opd-forms.index')
            ->with('success','High-risk submission saved!');
    }

    /**
     * Display the specified submission.
     */
    public function show(OpdSubmission $submission)
    {
        $submission->load('form','patient.user');
        return view('opd_forms.high_risk.show', compact('submission'));
    }

    /**
     * Show the form for editing the specified submission.
     */
    public function edit(OpdSubmission $submission)
    {
        $submission->load('form');
        return view('opd_forms.high_risk.edit', compact('submission'));
    }

    /**
     * Update the specified submission in storage.
     */
    public function update(Request $request, OpdSubmission $submission)
    {
        // same rules as store
        $rules = [
            'patient_id'                   => 'nullable|exists:patients,id',
            'last_name'                     => 'nullable|string|max:255',
            'given_name'                    => 'nullable|string|max:255',
            'middle_name'                   => 'nullable|string|max:255',
            'age'                           => 'nullable|integer|min:0',
            'sex'                           => 'nullable|in:male,female',
            'risks'                         => 'nullable|array',
            'risks.*'                       => 'required|string',
            'others_med_surg_specify'       => 'nullable|string|max:255',
            'others_generative_specify'     => 'nullable|string|max:255',
            'fetal_congenital_anomaly_specify' => 'nullable|string|max:255',
            'poor_ob_history_specify'       => 'nullable|string|max:255',
            'others_multiple_specify'       => 'nullable|string|max:255',
            'others_infection_specify'      => 'nullable|string|max:255',
        ];

       $data = $request->validate($rules);

    $submission->update([
        'patient_id' => $data['patient_id'] ?? null,
        'answers'    => $data,
    ]);

    return redirect()
        ->route('high-risk-opd-forms.index')
        ->with('success','High-risk submission updated!');
}

public function printReceipt(Token $token)
{
    // authorise: only the owner OR any admin/encoder can print
    if (!auth()->user()->hasRole(['admin','encoder']) &&
        auth()->id() !== optional($token->patient->user)->id) {
        abort(403);
    }

    return view('queue.print', compact('token'));
}


    /**
     * Remove the specified submission from storage.
     */
    public function destroy(OpdSubmission $submission)
    {
        $submission->delete();

        return redirect()
            ->route('high-risk-opd-forms.index')
            ->with('success','High-risk submission deleted.');
    }
}
