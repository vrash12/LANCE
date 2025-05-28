<?php
// app/Http/Controllers/EncoderOpdFormController.php

namespace App\Http\Controllers;

use App\Models\OpdForm;
use App\Models\Department;
use Illuminate\Http\Request;

class EncoderOpdFormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:encoder']);
    }

    /** GET /encoder/opd */
    public function index()
    {
        $forms = OpdForm::orderBy('name')->paginate(15);
        return view('encoder.opd.index', compact('forms'));
    }

    /** GET /encoder/opd/create */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('encoder.opd.create', compact('departments'));
    }

    /** POST /encoder/opd */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'form_no'    => 'required|string|max:50|unique:opd_forms,form_no',
            'department' => 'required|string|max:100',
            'fields'     => 'nullable|array',
        ]);

        $data['fields'] = $data['fields'] ?? [];
        OpdForm::create($data);

        return redirect()
            ->route('encoder.opd.index')
            ->with('success','OPD form template created.');
    }

    /** GET /encoder/opd/{opd_form}/edit */
    public function edit(OpdForm $opd_form)
    {
        $departments = Department::orderBy('name')->get();
        return view('encoder.opd.edit', compact('opd_form','departments'));
    }

    /** PUT /encoder/opd/{opd_form} */
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

        return redirect()
            ->route('encoder.opd.index')
            ->with('success','OPD form template updated.');
    }

    /** (Optional) DELETE /encoder/opd/{opd_form} */
    public function destroy(OpdForm $opd_form)
    {
        $opd_form->delete();

        return redirect()
            ->route('encoder.opd.index')
            ->with('success','OPD form template deleted.');
    }
}
