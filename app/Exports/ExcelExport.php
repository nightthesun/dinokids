<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExcelExport implements FromArray, WithHeadings
{
    public function __construct(array $stock, array $titles)
    {
        $this->stock = $stock;
        $this->titles = $titles;
        //return dd($pvp);
    }
    public function array(): array
    {   
        return $this->stock;    
    }
    public function headings(): array
    {
        return $this->titles;
    }
}
