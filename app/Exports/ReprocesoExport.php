<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReprocesoExport implements FromArray, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function __construct(array $query, $fini, $ffin)
  {
    $this->query = $query;
    $this->fini = $fini;
    $this->ffin = $ffin;
  }
  public function array(): array
  {
    return $this->query;
  }
  public function headings(): array
  {
    return [
      [
        'FechaOrigen',
        'NTrans',
        'Categoria',
        'Codigo',
        'Descripcion',
        'U.M.',
        'Almacen',
        'Cantidad',
        'Cost_U',
        'FechaRedir',
        'Usuario',
        'Glosa',
        'TipMov',
        'Ingr/Egre',
      ],
    ];
  }
}
