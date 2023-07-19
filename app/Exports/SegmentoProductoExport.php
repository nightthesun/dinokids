<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SegmentoProductoExport implements FromArray, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function __construct(array $stock, $pvp, $titulos_excel_2)
  {
    $this->stock = $stock;
    $this->pvp = $pvp;
    $this->titulos_excel_2 = $titulos_excel_2;
  }
  public function array(): array
  {
    return $this->stock;
  }
  public function headings(): array
  {
    return [
      [
        'Reporte de Segmento X Producto'
      ],
      $this->titulos_excel_2,
      $this->pvp];
  }
}