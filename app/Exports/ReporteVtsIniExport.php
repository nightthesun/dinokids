<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
//use Maatwebsite\Excel\Concerns\WithMapping;

class ReporteVtsIniExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize,WithStyles//, WithMapping
{
    protected $test;
    protected $title;
    private $current_row =2;
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:N1');
        foreach ($this->range3 as $r) {
            $sheet->mergeCells($r);
        }
        foreach ($this->ran4 as $r) {
            $sheet->mergeCells($r);
        }
    }
    public function __construct(string $titles, string $title,array $test, array $titulos, array $head, array $range3, array $ran4)
    {
        $this->test = $test;
        $this->title = $title;
        $this->titles = $titles;
        $this->titulos = $titulos;
        $this->head = $head;
        $this->range3 = $range3;
        $this->ran4 = $ran4;
    }

    public function array(): array
    {
        return $this->test;
    }
    /*public function map($test): array
    {
        //return dd($this->current_row++);
        $array = (array) $test;
        return dd($test);
        array_push($array, '=SUM(CP'.$this->current_row.'+CQ'.$this->current_row.')');
        $this->current_row++;
        return $array;
    }*/
    public function headings(): array
    {
        $titulos = $this->titulos;
        $head = $this->head;
        $titles = $this->titles;
        if($titles=='ini')
        {
            return [$head,$titulos];
        }        
    }
    public function title(): string
    {
        return $this->title;
    }
}
