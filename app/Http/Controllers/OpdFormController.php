<?php

namespace App\Http\Controllers;

use App\Models\{OpdForm, OpdSubmission, Department};
use Illuminate\Http\Request;
use PDF;

class OpdFormController extends Controller
{
    public function __construct()
    {
        // Admins manage templates
        $this->middleware(['auth','role:admin'])
             ->only(['index','create','store','edit','update','destroy','exportPdf']);

        // Admin / encoder / patient can view & fill
        $this->middleware(['auth','role:admin,encoder,patient'])
             ->only(['patientIndex','patientShow','show','fill','submit','viewSubmission']);
    }

    // ── Admin: Template CRUD ───────────────────────────────────────────────

    public function index()
    {
        $forms = OpdForm::orderBy('name')->get();
        return view('opd_forms.index', compact('forms'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'ob'); // ob|high_risk|follow_up|custom
        return view('opd_forms.create', [
            'type'        => $type,
            'departments' => Department::orderBy('name')->get(),
            'opd_form'    => null,
        ]);
    }

  public function store(Request $request)
{
    try {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'form_no'    => 'required|string|max:50|unique:opd_forms,form_no',
            'department' => 'required|string|max:100',
            'fields'     => 'nullable|array',
        ]);

        $data['fields'] = $data['fields'] ?? [];
        OpdForm::create($data);

        return redirect()
               ->route('opd_forms.index')
               ->with('success', 'OPD form template saved.');
    } catch (\Throwable $e) {
        // any DB or logic error that slips past validation
        return back()
               ->withInput()
               ->with('error', $e->getMessage());
    }
}
    public function edit(OpdForm $opd_form)
    {
        return view('opd_forms.edit', [
            'departments' => Department::orderBy('name')->get(),
            'opd_form'    => $opd_form,
            'type'        => $opd_form->specialization ?? 'custom',
        ]);
    }

    public function update(Request $request, OpdForm $opd_form)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'form_no'    => 'required|string|max:50|unique:opd_forms,form_no,'.$opd_form->id,
            'department' => 'required|string|max:100',
            'fields'     => 'nullable|array',
        ]);

        $data['fields'] = $data['fields'] ?? [];
        $opd_form->update($data);

        return redirect()->route('opd_forms.index')
                         ->with('success','Form updated.');
    }

    public function destroy(OpdForm $opd_form)
    {
        $opd_form->delete();
        return back()->with('success','Form deleted.');
    }

    public function exportPdf(OpdForm $opd_form)
    {
        return PDF::loadView('opd_forms.pdf', compact('opd_form'))
                  ->setPaper('a4','portrait')
                  ->download("opd-form-{$opd_form->form_no}.pdf");
    }

    // ── Patient / Encoder listing & view ───────────────────────────────────

    public function patientIndex()
    {
        $forms = OpdForm::orderBy('name')->get();
        return view('patient.opd_forms.index', compact('forms'));
    }

    public function show(OpdForm $opd_form)
    {
        $opd_form->load('submissions.user');
        return view('opd_forms.show', compact('opd_form'));
    }

    public function patientShow(OpdForm $opd_form)
    {
        return view('patient.opd_forms.show', compact('opd_form'));
    }

    // ── Fill & Submit ───────────────────────────────────────────────────────

    /** GET: blank form for patient/encoder to fill */
    public function fill(OpdForm $form)
    {
        return view('opd_forms.fill', compact('form'));
    }

    /** POST: store one submission */
    public function submit(Request $request, OpdForm $form)
    {
        $rules = [];
        foreach ($form->fields as $field) {
            $key  = "answers.{$field['name']}";
            $rule = empty($field['required']) ? 'nullable' : 'required';
            if (($field['type'] ?? '') === 'number') $rule .= '|numeric';
            if (($field['type'] ?? '') === 'date')   $rule .= '|date';
            $rules[$key] = $rule;
        }

        $data = $request->validate($rules);

        OpdSubmission::create([
            'user_id'    => auth()->id(),
            'form_id'    => $form->id,
            'answers'    => $data['answers'] ?? [],
            'patient_id' => auth()->user()->patient->id ?? null,
        ]);

        return redirect()->route('patient.dashboard')
                         ->with('success','OPD form submitted!');
    }

    // ── Read one submission ────────────────────────────────────────────────

    public function viewSubmission(OpdSubmission $submission)
    {
        $submission->load(['form','user']);
        return view('opd_submissions.show', compact('submission'));
    }
}
