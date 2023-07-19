<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class CuentasPorCobrarExport implements FromArray, WithHeadings,ShouldAutoSize
{
    public function __construct(array $resum, $checkfecha, $fecha, $fecha1, $fecha2)
    {
      $this->resum = $resum;
      $this->checkfecha = $checkfecha;
      $this->fecha = $fecha;
      $this->fecha1 = $fecha1;
      $this->fecha2 = $fecha2;
    }

    public function array(): array
    {
        return $this->resum;
    }
    public function headings(): array
    {
      $titulo = '';
      if($this->checkfecha == 1){
        $titulo = "Al ".$this->fecha;
      } else {
        $titulo = "Entre el ".$this->fecha1." - ".$this->fecha2."";
      }
        return [
        [
            'REPORTE DE CUENTAS POR COBRAR',
        ],
        [
            $titulo,
        ],
        [
            'Codigo',
            'Cliente',
            'RazonSocial',
            'Nit',
            'Fecha',
            'FechaVenc',
            'ImporteCXC',
            'ACuenta',
            'Saldo',
            'Glosa',
            'Usuario',
            'M.',
            'Venta',
            'Num. Fac',
            'Local',
            'estado',
        ],
        ];
    }
}
