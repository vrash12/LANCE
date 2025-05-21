<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;   // Laravel HTTP client
use Illuminate\Support\Facades\Cache;  // simple caching for insights
use PDF;                               // barryvdh/laravel-dompdf
use Maatwebsite\Excel\Facades\Excel;   // maatwebsite/excel
use App\Exports\TrendExport;

class PatientTrendController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    /**
     * 8.1  Trigger a fresh Trend Insight request
     * Hit the Flask service, cache result, return JSON or redirect.
     */
    public function requestInsight(Request $request)
    {
        $from = $request->input('from', now()->subMonth()->toDateString());
        $to   = $request->input('to',   now()->toDateString());

        // call Flask ML API
        $response = Http::timeout(30)
            ->post(config('services.trend_api.url').'/analyse', [
                'from' => $from,
                'to'   => $to,
            ]);

        if ($response->failed()) {
            return back()->with('error','Trend analysis service unavailable.');
        }

        // store in cache for 30 min
        Cache::put("trend:$from:$to", $response->json(), now()->addMinutes(30));

        return back()->with('success','Trend analysis generated!');
    }

    /**
     * 8.2  View Patient Trend Analysis (with 8.3 filter)
     */
    public function index(Request $request)
    {
        $from = $request->input('from', now()->subMonth()->toDateString());
        $to   = $request->input('to',   now()->toDateString());

        // try cache first
        $trend = Cache::get("trend:$from:$to");

        if (!$trend) {
            // auto-fetch if not cached
            $api = Http::timeout(30)
                ->get(config('services.trend_api.url').'/result', [
                    'from' => $from,
                    'to'   => $to,
                ]);

            $trend = $api->ok() ? $api->json() : [];
            Cache::put("trend:$from:$to", $trend, now()->addMinutes(30));
        }

        return view('trends.index', compact('trend','from','to'));
    }

    /**
     * 8.4  Export Trend Analysis → Excel
     */
    public function exportExcel(Request $request)
    {
        $from = $request->input('from'); $to = $request->input('to');
        $trend = Cache::get("trend:$from:$to") ?? [];

        return Excel::download(
            new TrendExport($trend, $from, $to),
            "trend_{$from}_to_{$to}.xlsx"
        );
    }

    /**
     * 8.4  Export Trend Analysis → PDF
     */
    public function exportPdf(Request $request)
    {
        $from = $request->input('from'); $to = $request->input('to');
        $trend = Cache::get("trend:$from:$to") ?? [];

        $pdf = PDF::loadView('trends.pdf', compact('trend','from','to'))
                  ->setPaper('a4','portrait');

        return $pdf->download("trend_{$from}_to_{$to}.pdf");
    }
}
