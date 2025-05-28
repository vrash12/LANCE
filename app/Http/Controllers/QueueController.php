<?php
// app/Http/Controllers/QueueController.php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;  
use App\Models\Department;
use App\Models\Token;           // Token model holds each queue token
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth');

     // only these methods are ADMIN-only:
     $this->middleware('role:admin')->only([
       'departments',
       'adminDisplay','show',
       'history','destroy',
       'edit','update',
       'serveNextAdmin',
     ]);

     // only these methods are PATIENT-only:
     $this->middleware('role:patient')->only([
       'patientQueue','patientStore',
     ]);
   }


// app/Http/Controllers/QueueController.php
public function history(Request $req)
{
    $departments = Department::orderBy('name')->get();

    $tokens = Token::with('department')
        ->when($req->filled('department'), fn($q)=>
            $q->where('department_id',$req->department))
        ->when($req->status==='served',  fn($q)=>$q->whereNotNull('served_at'))
        ->when($req->status==='pending', fn($q)=>$q->whereNull('served_at'))
        ->orderByDesc('created_at')
        ->paginate(20);

    return view('queue.history', compact('tokens','departments'));
}
public function patientStore(Request $request, Department $department)
{
    $patient = Auth::user()->patient;

    // Check if the patient already has an un-served token
    $already = Token::where('department_id', $department->id)
                    ->where('patient_id',  $patient->id)
                    ->whereNull('served_at')
                    ->exists();

    if ($already) {
        return back()
            ->with('error', 'You already have a token for this department.');
    }

    // Generate the next token
    $next   = Token::where('department_id', $department->id)->count() + 1;
    $prefix = strtoupper(substr($department->short_name ?: $department->name, 0, 1));
    $code   = $prefix . str_pad($next, 3, '0', STR_PAD_LEFT);

    $token = Token::create([
        'department_id' => $department->id,
        'patient_id'    => $patient->id,
        'code'          => $code,
    ]);

    // Store token in the session
    session()->put('patient_token', $code);

    // Redirect the patient to the live display of the queue
    return redirect()
        ->route('queue.display', $department)
        ->with('success', "Your token is {$code}.");
}




public function adminDisplay(Department $department)
{
    // 1) Grab the next 5 pending tokens
    $tokens = Token::where('department_id', $department->id)
                   ->whereNull('served_at')
                   ->orderBy('created_at')
                   ->take(5)
                   ->get();

    // 2) Compute what’s “Now Serving” and the current timestamp
    $currentServing = $tokens->first()?->code ?? '—';
    $currentTime    = now()->format('d F Y H:i:s');

    // 3) Render the admin_display blade
    return view('queue.admin_display', [
        'department'     => $department,
        'tokens'         => $tokens,
        'currentServing' => $currentServing,
        'currentTime'    => $currentTime,
    ]);
}


  public function store(Request $request, Department $department)
{
    // determine next queue number
    $next = Token::where('department_id', $department->id)->count() + 1;
    $prefix = strtoupper(substr($department->short_name, 0, 1));
    $code = $prefix . str_pad($next, 3, '0', STR_PAD_LEFT);

    // mass-assign with fillable fields
    Token::create([
        'department_id' => $department->id,
        'code'          => $code,
        'served_at'     => null,
    ]);

    return back()->with('success', "Token {$code} created.");
}

public function serveNextAdmin(Department $department)
{
    // 1) mark the current token as served
    $current = Token::where('department_id', $department->id)
                    ->whereNull('served_at')
                    ->orderBy('created_at')
                    ->first();
    if ($current) {
        $current->update(['served_at' => now()]);
    }

    // 2) determine the next code
    $next = Token::where('department_id', $department->id)
                 ->whereNull('served_at')
                 ->orderBy('created_at')
                 ->first();

    // 3) redirect right back to the admin display
    return redirect()
        ->route('queue.display.admin', $department)
        ->with('success',
            $next
              ? "Now serving {$next->code}"
              : 'No more tokens in queue'
        );
}


public function edit(Department $department, Token $token)
{
    return view('queue.edit', compact('department','token'));
}

public function update(Request $request, Department $department, Token $token)
{
    $data = $request->validate([
        'code'      => 'required|string|unique:tokens,code,' . $token->id,
        'served_at' => 'nullable|date',
    ]);

    $token->update($data);

    return redirect()
        ->route('queue.show', $department)
        ->with('success','Token updated.');
}

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

    return view('queue.index', compact('departments','summary'));
}

public function serveNext(Department $department)
{
    // 1) Mark the currently served token (if any) as served_at = now
    $current = Token::where('department_id', $department->id)
                    ->whereNull('served_at')
                    ->orderBy('created_at')
                    ->first();

    if ($current) {
        $current->served_at = now();
        $current->save();
    }

    // 2) Determine the next token code
    $next = Token::where('department_id', $department->id)
                 ->whereNull('served_at')
                 ->orderBy('created_at')
                 ->first();

    // 3) Redirect back with a flash so the UI updates
    return redirect()->route('queue.show', $department)
                     ->with('success',
                            $next
                              ? "Now serving {$next->code}"
                              : "No more tokens in queue");
}



    /**  ➜  live display for a single department (Figure 43) */
    public function show(Department $department)
    {
     // QueueController@show
$tokens = Token::where('department_id',$department->id)
               ->whereNull('served_at')
               ->orderBy('created_at')
               ->take(5)->get();

$currentServing = $tokens->first()?->code ?? '—';
$currentTime    = now()->format('d F Y H:i:s');


return view('queue.display',
    compact('department','tokens','currentServing','currentTime')
);


    $currentServing = Token::where('department_id', $department->id)
                       ->whereNull('served_at')
                       ->orderBy('created_at')
                       ->first()?->code ?? '—';


        $currentTime = Carbon::now()->format('d F Y H:i:s');

        return view('queue.display', compact('department','queue','currentServing','currentTime'));
    }
    public function patientQueue()
    {
        $departments = Department::orderBy('name')->get();

        // grab the “patient” record
        $patient = Auth::user()->patient;

        // collect any live (unserved) tokens keyed by department_id
        $existing = collect();
        if ($patient) {
            $existing = Token::where('patient_id', $patient->id)
                             ->whereNull('served_at')
                             ->get()
                             ->keyBy('department_id');
        }

        return view('patient.queue', compact('departments','existing'));
    }
    /**
 * DELETE /queue/{department}/tokens/{token}
 */
public function destroy(Department $department, Token $token)
{
    // optional: verify $token->department_id === $department->id
    $token->delete();

    return redirect()
        ->route('queue.show', $department)
        ->with('success', 'Token deleted successfully.');
}

// app/Http/Controllers/QueueController.php
public function selectDepartment()
{
    $departments = \App\Models\Department::orderBy('name')->get();
    return view('queue.select', compact('departments'));
}
public function display(Department $department)
{
    // Get all pending tokens for the department
    $allPending = Token::where('department_id', $department->id)
                       ->whereNull('served_at')
                       ->orderBy('created_at')
                       ->get();

    // Display the first 5 tokens in the queue
    $tokens = $allPending->take(5);
    $currentServing = optional($tokens->first())->code ?? '—';  // Show the first token as currently serving

    $currentTime = now()->format('d F Y H:i:s');

    // Get patient's token from the session (if available)
    $patientToken = session('patient_token');
    $position = $allPending->pluck('code')->search($patientToken);

    return view('queue.display', compact(
        'department', 'tokens', 'currentServing', 'currentTime',
        'patientToken', 'position'
    ));
}



public function status(Department $department)
{
    // Get every pending token
    $all = Token::where('department_id', $department->id)
                ->whereNull('served_at')
                ->orderBy('created_at')
                ->get(['code','created_at']);

    // First five for the slots
    $pending5 = $all->take(5)->map(fn($t)=> ['code'=>$t->code]);

    // All codes for computing position
    $allCodes = $all->pluck('code');

    return response()->json([
       'pending'   => $pending5,
       'all_codes' => $allCodes,
    ]);
}

}
