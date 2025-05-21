<?php
// app/Http/Controllers/EncoderOpdFormController.php
namespace App\Http\Controllers;

use App\Models\OpdForm;
use App\Models\OpdSubmission;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EncoderOpdFormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:encoder']);
    }

    public function index()
    {
        $subs = OpdSubmission::with(['form','patient'])
                              ->where('user_id', Auth::id())
                              ->latest()
                              ->get();

        return view('encoder.opd.index', compact('subs'));
    }

    public function create()
    {
        $forms    = OpdForm::orderBy('name')->get();
        $patients = Patient::orderBy('name')->get();
        return view('encoder.opd.create', compact('forms','patients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'form_id'    => 'required|exists:opd_forms,id',
            'patient_id' => 'required|exists:patients,id',
            'answers'    => 'required|array',
        ]);

        OpdSubmission::create([
            'user_id'    => Auth::id(),
            'form_id'    => $data['form_id'],
            'patient_id' => $data['patient_id'],
            'answers'    => json_encode($data['answers']),
        ]);

        return redirect()->route('encoder.opd.index')
                         ->with('success','Form submitted.');
    }

    public function show(OpdSubmission $opdSubmission)
    {
        $opdSubmission->load(['form','patient']);
        return view('encoder.opd.show', compact('opdSubmission'));
    }
}

