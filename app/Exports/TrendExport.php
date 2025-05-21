<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrendExport implements FromArray, WithHeadings
{
    protected array $trend;
    protected string $from;
    protected string $to;

    public function __construct(array $trend, string $from, string $to)
    {
        $this->trend = $trend;
        $this->from  = $from;
        $this->to    = $to;
    }

    public function headings(): array
    {
        return ['Metric', "Value ({$this->from} → {$this->to})"];
    }

    public function array(): array
    {
        return collect($this->trend)->map(fn($v,$k)=>[$k,$v])->values()->toArray();
    }
}
