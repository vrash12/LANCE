<?php
// app/Http/Controllers/QueueController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Department;
use App\Models\Token;

class QueueController extends Controller
{
    /* -----------------------------------------------------------------
       Constructor: auth for everything EXCEPT the 3 public pages
    ----------------------------------------------------------------- */
    public function __construct()
    {
        // guests can see picker, live display, and JSON status
        $this->middleware('auth')
             ->except(['selectDepartment', 'display', 'status']);

        // admin-only methods
        $this->middleware('role:admin')->only([
            'departments', 'adminDisplay', 'show', 'history',
            'store', 'serveNextAdmin', 'serveNext',
            'edit', 'update', 'destroy',
        ]);

        // patient-only methods
        $this->middleware('role:patient')->only([
            'patientQueue', 'patientStore',
        ]);
    }

    /* ================================================================
       PUBLIC  (no login)
    ================================================================ */

    /** GET  /queue/select  – department picker (guests) */
    public function selectDepartment()
    {
        $departments = Department::orderBy('name')->get();

        return view('queue.department_select', compact('departments'));
    }

    /** GET  /queue/{department}/display  – live monitor (guests) */
    public function display(Department $department)
    {
        // all pending tokens
        $allPending     = Token::where('department_id', $department->id)
                               ->whereNull('served_at')
                               ->orderBy('created_at')
                               ->get();

        // first five for the slots
        $tokens         = $allPending->take(5);
        $currentServing = optional($tokens->first())->code ?? '—';
        $currentTime    = now()->format('d F Y H:i:s');

        // patient token (only if they used patient flow)
        $patientToken = session('patient_token');
        $position     = $allPending->pluck('code')->search($patientToken);

        return view('queue.display', compact(
            'department', 'tokens', 'currentServing',
            'currentTime', 'patientToken', 'position'
        ));
    }

    /** GET  /queue/{department}/status  – JSON for polling (guests) */
    public function status(Department $department)
    {
        $all = Token::where('department_id', $department->id)
                    ->whereNull('served_at')
                    ->orderBy('created_at')
                    ->get(['code', 'created_at']);

        return response()->json([
            'pending'   => $all->take(5)->values(),   // first 5
            'all_codes' => $all->pluck('code'),       // every code
        ]);
    }

    /* ================================================================
       PATIENT FLOW
    ================================================================ */

    public function patientQueue()
    {
        $departments = Department::orderBy('name')->get();

        $patient     = Auth::user()->patient;
        $existing    = collect();

        if ($patient) {
            $existing = Token::where('patient_id', $patient->id)
                             ->whereNull('served_at')
                             ->get()
                             ->keyBy('department_id');
        }

        return view('patient.queue', compact('departments', 'existing'));
    }

    public function patientStore(Request $req, Department $department)
    {
        $patient = Auth::user()->patient;

        // already has live token?
        $dup = Token::where('department_id', $department->id)
                    ->where('patient_id',  $patient->id)
                    ->whereNull('served_at')
                    ->exists();
        if ($dup) {
            return back()->with('error','You already have a token here.');
        }

        /* create next code */
        $next   = Token::where('department_id', $department->id)->count() + 1;
        $prefix = strtoupper(substr($department->short_name ?: $department->name,0,1));
        $code   = $prefix . str_pad($next,3,'0',STR_PAD_LEFT);

        Token::create([
            'department_id' => $department->id,
            'patient_id'    => $patient->id,
            'code'          => $code,
        ]);

        // remember so we can highlight
        session()->put('patient_token', $code);

        return redirect()
            ->route('queue.display', $department)
            ->with('success', "Your token is {$code}.");
    }

    /* ================================================================
       ADMIN FLOW
    ================================================================ */

    public function departments()
    {
        $departments = Department::with('nextPendingToken')
                                 ->orderBy('name')
                                 ->get();

        $summary = [
            'total'    => Token::count(),
            'pending'  => Token::whereNull('served_at')->count(),
            'complete' => Token::whereNotNull('served_at')->count(),
        ];

        return view('queue.index', compact('departments', 'summary'));
    }

    public function adminDisplay(Department $department)
    {
        $tokens = Token::where('department_id', $department->id)
                       ->whereNull('served_at')
                       ->orderBy('created_at')
                       ->take(5)->get();

        return view('queue.admin_display', [
            'department'     => $department,
            'tokens'         => $tokens,
            'currentServing' => optional($tokens->first())->code ?? '—',
            'currentTime'    => now()->format('d F Y H:i:s'),
        ]);
    }

    public function store(Request $req, Department $department)
    {
        $next = Token::where('department_id', $department->id)->count() + 1;
        $code = strtoupper(substr($department->short_name,0,1))
              . str_pad($next,3,'0',STR_PAD_LEFT);

        Token::create([
            'department_id' => $department->id,
            'code'          => $code,
        ]);

        return back()->with('success', "Token {$code} created.");
    }

    public function serveNextAdmin(Department $department)
    {
        // mark current
        $current = Token::where('department_id', $department->id)
                        ->whereNull('served_at')
                        ->orderBy('created_at')
                        ->first();
        if ($current) $current->update(['served_at'=>now()]);

        // flash next
        $next = Token::where('department_id', $department->id)
                     ->whereNull('served_at')
                     ->orderBy('created_at')
                     ->first();

        return redirect()
            ->route('queue.display.admin', $department)
            ->with('success', $next
                ? "Now serving {$next->code}"
                : 'No more tokens in queue');
    }

    public function serveNext(Department $department)
    {
        $current = Token::where('department_id', $department->id)
                        ->whereNull('served_at')
                        ->orderBy('created_at')
                        ->first();
        if ($current) $current->update(['served_at'=>now()]);

        $next = Token::where('department_id', $department->id)
                     ->whereNull('served_at')
                     ->orderBy('created_at')
                     ->first();

        return redirect()
            ->route('queue.show', $department)
            ->with('success', $next
                ? "Now serving {$next->code}"
                : 'No more tokens in queue');
    }

    public function show(Department $department)
    {
        /* identical to adminDisplay but with auth wall; keep if you need */
        return $this->adminDisplay($department);
    }

    public function edit(Department $department, Token $token)
    {
        return view('queue.edit', compact('department', 'token'));
    }

    public function update(Request $req, Department $department, Token $token)
    {
        $data = $req->validate([
            'code'      => 'required|string|unique:tokens,code,' . $token->id,
            'served_at' => 'nullable|date',
        ]);
        $token->update($data);

        return redirect()
            ->route('queue.show', $department)
            ->with('success', 'Token updated.');
    }

    public function destroy(Department $department, Token $token)
    {
        $token->delete();
        return back()->with('success', 'Token deleted.');
    }

    public function history(Request $req)
    {
        $departments = Department::orderBy('name')->get();

        $tokens = Token::with('department')
            ->when($req->filled('department'),
                fn($q) => $q->where('department_id', $req->department))
            ->when($req->status === 'served',
                fn($q) => $q->whereNotNull('served_at'))
            ->when($req->status === 'pending',
                fn($q) => $q->whereNull('served_at'))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('queue.history', compact('tokens', 'departments'));
    }

    /* ================================================================
       ENCODER flow (re-using patient id in session)
    ================================================================ */

    public function encoderStore(Request $req, Department $department)
    {
        $patientId = session('queue_patient_id');
        abort_unless($patientId, 404);

        $dup = Token::where('department_id', $department->id)
                    ->where('patient_id',   $patientId)
                    ->whereNull('served_at')
                    ->exists();
        if ($dup) {
            return back()->with('error','Duplicate live token.');
        }

        $next   = Token::where('department_id', $department->id)->count() + 1;
        $prefix = strtoupper(substr($department->short_name ?: $department->name,0,1));
        $code   = $prefix . str_pad($next,3,'0',STR_PAD_LEFT);

        Token::create([
            'department_id'=> $department->id,
            'patient_id'   => $patientId,
            'code'         => $code,
        ]);

        session()->forget(['queue_patient_id','queue_patient_name']);

        return redirect()
            ->route('queue.display.admin', $department)
            ->with('success', "Token {$code} created.");
    }
}
