<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ReporteCotizacionExport implements FromArray, WithHeadings,ShouldAutoSize
{
    public function __construct(array $resum, $fecha)
    {
        $this->resum = $resum;
        $this->fecha = $fecha;
    }

    public function array(): array
    {
        return $this->resum;
    }
    public function headings(): array
    {
        return [
        [
            'REPORTE DE COTIZACION',
        ],
        [
            "Fecha: ".$this->fecha."",
        ],
        [
            'Fecha',
            'Nro Cot',
            'Cliente',
            'Fecha NR',
            'NR',
            'Total ventas',
            'Moneda',
            'Usuario vendedor',
            'local',
            'Fecha facturacion',
            'Nro facturacion',
            'Estado',
          
        ],
        ];
    }
}
