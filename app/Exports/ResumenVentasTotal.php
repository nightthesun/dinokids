<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResumenVentasTotal implements FromArray, WithHeadings,ShouldAutoSize
{
    public function __construct(array $resum, $fini, $ffin,$adminQ, $totalQ ,$regionales1 ,$totalG ,$regionales2  ,$totalG2 , $total, $totalgen)
    {
        $this->resum = $resum;
        $this->adminQ=$adminQ;
        $this->regionales1=$regionales1;
        $this->regionales2=$regionales2;
        $this->fini = $fini;
        $this->ffin = $ffin;
        
    }

    public function array(): array
    {
        return $this->resum;
    }

    public function headings(): array
    {
        return [
        [
            'REPORTE DE VENTAS',
        ],
        [
            "DEL ".$this->fini." AL ".$this->ffin."",
        ],
        [
            'Local',
            'Grupo',
            'Total',
            'Moneda',
            'Efectivo',
            'Banco',
            'CXC',
            'Tarjeta',
            'Mot. Contable',
            'Otros',
        ]
        ];
    }
  
}
