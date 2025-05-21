<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientVisit;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // if you only want admins to see it:
        // $this->middleware('role:admin');
    }

    public function index()
    {
        // 1) Today’s visits (from patient_visits)
        $todayVisits = PatientVisit::whereDate('visited_at', Carbon::today())
                                   ->count();

        // 2) Average wait time for tokens served today
        $servedToday = Token::whereDate('served_at', Carbon::today())
                            ->whereNotNull('served_at')
                            ->get();

        $avgWaitSeconds = $servedToday->avg(fn($t) => 
            $t->served_at->diffInSeconds($t->created_at)
        );

        // convert to minutes, one decimal
        $avgWait = $avgWaitSeconds
                 ? round($avgWaitSeconds / 60, 1)
                 : 0;

        // 3) Current queue length (pending tokens)
        $currentQueue = Token::whereNull('served_at')->count();

        // 4) Department breakdown of *today’s* tokens created
        $deptStats = Token::whereDate('created_at', Carbon::today())
            ->select('department_id', DB::raw('count(*) as count'))
            ->groupBy('department_id')
            ->with('department')
            ->get()
            ->map(fn($r) => [
                'id'    => $r->department_id,
                'name'  => $r->department->short_name, 
                'count' => $r->count,
            ]);

        return view('home', compact(
            'todayVisits',
            'avgWait',
            'currentQueue',
            'deptStats'
        ));
    }
}
