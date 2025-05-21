<?php
// app/Http/Controllers/QueueController.php
namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Token;           // Token model holds each queue token
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueController extends Controller
{
 public function __construct()
    {
        $this->middleware('auth');
        // keep your admin-only middleware on show/store/etc
        $this->middleware('role:admin')->only([
            'departments','show','edit','update','serveNext','destroy','store'
        ]);
        // but *do not* guard 'display'
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
    // generate the next token code
    $next   = Token::where('department_id', $department->id)->count() + 1;
    $prefix = strtoupper(substr($department->short_name ?: $department->name, 0, 1));
    $code   = $prefix . str_pad($next, 3, '0', STR_PAD_LEFT);

    Token::create([
        'department_id' => $department->id,
        'code'          => $code,
        'served_at'     => null,
    ]);

    // flash both the message and the code, and redirect back
    return redirect()
        ->route('patient.queue')
        ->with([
            'success'       => "Token {$code} generated. Please watch the screen.",
            'current_token' => $code,
        ]);
}


public function adminDisplay(Department $department)
{
    $tokens = Token::where('department_id',$department->id)
                   ->whereNull('served_at')
                   ->orderBy('created_at')
                   ->take(5)->get();

    return view('queue.admin_display',[
        'department'      => $department,
        'tokens'          => $tokens,
        'currentServing'  => $tokens->first()?->code ?? '—',
        'currentTime'     => now()->format('d F Y H:i:s'),
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

// QueueController@departments
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
        return view('patient.queue', compact('departments'));
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
        $tokens = Token::where('department_id', $department->id)
                       ->whereNull('served_at')
                       ->orderBy('created_at')
                       ->take(5)
                       ->get();

        $currentServing = $tokens->first()?->code ?? '—';
        $currentTime    = Carbon::now()->format('d F Y H:i:s');

        return view('queue.display', compact(
            'department','tokens','currentServing','currentTime'
        ));
    }


public function status(Department $department)
{
    // next 5 pending tokens
    $pending = Token::where('department_id', $department->id)
                    ->whereNull('served_at')
                    ->orderBy('created_at')
                    ->take(5)
                    ->get(['code','created_at']);

    // last 10 served tokens
    $history = Token::where('department_id', $department->id)
                    ->whereNotNull('served_at')
                    ->orderBy('served_at','desc')
                    ->take(10)
                    ->get(['code','served_at']);

    return response()->json([
        'pending' => $pending,
        'history' => $history,
    ]);
}

}
