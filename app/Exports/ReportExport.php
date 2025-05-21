<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportExport implements FromArray, WithHeadings
{
    protected $from; protected $to;
    public function __construct($from,$to){$this->from=$from;$this->to=$to;}

    public function headings():array{ return ['Date','Total Visits']; }

    public function array():array
    {
        return DB::table('patient_visits')
                 ->whereBetween('visited_at', [$this->from,$this->to])
                 ->selectRaw('DATE(visited_at) as day, COUNT(*) as total')
                 ->groupBy('day')->orderBy('day')->pluck('total','day')
                 ->map(fn($v,$k)=>[$k,$v])->values()->toArray();
    }
}
