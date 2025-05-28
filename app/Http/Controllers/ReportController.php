<?php
//app/Http/Controllers/ReportController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Models\Patient;

class ReportController extends Controller
{
public function index(Request $request)
{
    // Set default date range to the past month
    $dateFrom = $request->input('from', now()->subMonth()->toDateString());
    $dateTo   = $request->input('to', now()->toDateString());

    // Fetch daily patient visits
    $visits = DB::table('patient_visits')
                ->whereBetween('visited_at', [$dateFrom, $dateTo])
                ->selectRaw('DATE(visited_at) as day, COUNT(*) as total')
                ->groupBy('day')
                ->orderBy('day')
                ->get();

    // Fetch age statistics
    $ageStats = DB::table('patients')
        ->selectRaw("
            CASE
              WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) < 18 THEN '<18'
              WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 18 AND 35 THEN '18–35'
              WHEN TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN 36 AND 60 THEN '36–60'
              ELSE '>60'
            END AS age_range,
            COUNT(*) AS total
        ")
        ->groupBy('age_range')
        ->orderByRaw("FIELD(age_range,'<18','18–35','36–60','>60')")
        ->get();

        
    // Gender statistics
 $genderStats = DB::table('patient_profiles')
        ->select('sex', DB::raw('COUNT(*) AS total'))
        ->groupBy('sex')
        ->get();
        
    // Blood type statistics
    $bloodStats = DB::table('patient_profiles')
        ->select('blood_type', DB::raw('COUNT(*) AS total'))
        ->groupBy('blood_type')
        ->get();

    // Delivery type statistics
    $deliveryStats = DB::table('patient_profiles')
        ->select('delivery_type', DB::raw('COUNT(*) AS total'))
        ->groupBy('delivery_type')
        ->get();

    // Pass all data to the view
    return view('reports.index', compact('ageStats', 'genderStats', 'bloodStats', 'deliveryStats', 'dateFrom', 'dateTo', 'visits'));
}

    /** 7.1 Generate Report (recalculate cached KPIs, if you store them) */
    public function generate(Request $request)
    {
        // Example placeholder for heavy aggregation / queueable job
        // Dispatch a job or recalc summaries here …
        return back()->with('success','Report generation triggered!');
    }

    /** 7.1.1 Verify Data (AJAX sanity-check endpoint) */
    public function verify(Request $request)
    {
        $missing = DB::table('patient_visits')
                     ->whereNull('notes')
                     ->count();

        return response()->json([
            'ok'      => $missing === 0,
            'missing' => $missing,
        ]);
    }

    /** 7.3 Excel export */
    public function exportExcel(Request $request)
    {
        $from = $request->input('from'); $to = $request->input('to');
        return Excel::download(
            new ReportExport($from,$to),
            "report_{$from}_to_{$to}.xlsx"
        );
    }

    /** 7.3 PDF export */
    public function exportPdf(Request $request)
    {
        $from = $request->input('from'); $to = $request->input('to');
        $visits = DB::table('patient_visits')
                    ->whereBetween('visited_at', [$from, $to])
                    ->selectRaw('DATE(visited_at) as day, COUNT(*) as total')
                    ->groupBy('day')->orderBy('day')->get();

        $pdf = PDF::loadView('reports.pdf', compact('visits','from','to'))
                  ->setPaper('a4','portrait');

        return $pdf->download("report_{$from}_to_{$to}.pdf");
    }
}
