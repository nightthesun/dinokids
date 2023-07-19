<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ParetoXMesExport implements FromArray, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function __construct(array $test, $titulos_excel, $titulos_excel_1, $titulos_excel_2, $titulos_excel_mes)
  {
    $this->test = $test;
    $this->titulos_excel_mes = $titulos_excel_mes;
    $this->titulos_excel_1 = $titulos_excel_1;
    $this->titulos_excel_2 = $titulos_excel_2;
    $this->titulos_excel = $titulos_excel;
  }
  public function array(): array
  {
    return $this->test;
  }
  public function headings(): array
  {
    return [
      [
        'REPORTE MES/PARETO VENTAS'
      ],
      $this->titulos_excel_mes,
      $this->titulos_excel_2,
      $this->titulos_excel_1,
      $this->titulos_excel];
  }
}
