<?php
namespace App\Http\Controllers;
use App\Models\OpdForm;
use Illuminate\Http\Request;

class OpdFormController extends Controller
{
    public function __construct() { $this->middleware(['auth','role:admin']); }

    public function index()  { $forms = OpdForm::orderBy('name')->get(); return view('opd_forms.index',compact('forms')); }

    public function create() { return view('opd_forms.create'); }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'       => 'required|string|max:255',
            'form_no'    => 'required|string|max:50|unique:opd_forms,form_no',
            'department' => 'required|string|max:100',
        ]);
        OpdForm::create($data);
        return redirect()->route('opd_forms.index')->with('success','Form added.');
    }

    public function show(OpdForm $opd_form) { return view('opd_forms.show',compact('opd_form')); }

    public function edit(OpdForm $opd_form) { return view('opd_forms.edit',compact('opd_form')); }

    public function update(Request $r, OpdForm $opd_form)
    {
        $data = $r->validate([
            'name'       => 'required|string|max:255',
            'form_no'    => 'required|string|max:50|unique:opd_forms,form_no,'.$opd_form->id,
            'department' => 'required|string|max:100',
        ]);
        $opd_form->update($data);
        return redirect()->route('opd_forms.index')->with('success','Form updated.');
    }

    public function destroy(OpdForm $opd_form)
    {
        $opd_form->delete();
        return redirect()->route('opd_forms.index')->with('success','Form deleted.');
    }
}
