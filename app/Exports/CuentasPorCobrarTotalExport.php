<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class CuentasPorCobrarTotalExport implements FromArray, WithHeadings, ShouldAutoSize
{
  public function __construct(array $sql_excel, $fecha_excel)
  {
    $this->sql_excel = $sql_excel;
    $this->fecha_excel = $fecha_excel;
  }

  public function array(): array
  {
    return $this->sql_excel;
  }
  public function headings(): array
  {
    $titulo = $this->fecha_excel;
    return [
      [
        'REPORTE DE CUENTAS POR COBRAR TOTAL',
      ],
      [
        $titulo,
      ],
      [
        'FechaNR',
        'NR',
        'Id_Cliente',
        'Cliente',
        'FechaFac',
        'NroFac',
        'FechaVenc',
        'Glosa',
        'RazonSocial',
        'NIT',
        'DiasPlazo',
        'ImpTotal',
        'FechaACuenta',
        'Contado',
        'Credito',
        'NomLocal',
        'Usuario',
        'DifDiasACuenta',
        'DifDiasConsultado',
        'Estado',
      ],
    ];
  }
}
