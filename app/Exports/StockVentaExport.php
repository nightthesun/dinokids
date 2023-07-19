<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockVentaExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(array $stock, $pvp)
    {
        $this->stock = $stock;
        $this->pvp = $pvp;
        //return dd($pvp);
    }
    public function array(): array
    {   
        return $this->stock;    
    }
    public function headings(): array
    {  
        return $this->pvp;
    }
}
