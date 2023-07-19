<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReporteVtsSheetExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{

    protected $test;
    protected $title;

    public function __construct(string $titles, string $title,array $test)
    {
        $this->test = $test;
        $this->title = $title;
        $this->titles = $titles;
    }

    public function array(): array
    {
        return $this->test;
    }
    public function headings(): array
    {
        $titles = $this->titles;
        if($titles=='productos')
        {
            $titulos = [
                'Categoria',
                'Codigo',
                'Descripcion'
            ];
        }
        else if($titles=='stock')
        {
            $titulos = [
                'Codigo',
                'Descripcion',
                'Cantidad',
                'UM',
                'ValorInv'
            ];
        }
        else if($titles=='ventas')
        {
            $titulos = [
                'Codigo',
                'Moneda',
                'Cantidad',
                'Precio de Venta', 
                'descuento',
                'Total'
            ];
        }
        else if($titles=='pyc')
        {
            $titulos = [
                'Categoria',
                'Codigo',
                'Descripcion',
                'U.M.',
                'Precio Origen',
                'Moneda Precio Origen',
                'Costo Ultima Compra',
                'Moneda Costo Ult Compra',
                'Costo Promedio',
                'MonedaCosto Promedio',
                'PVP',
                'Fecha Ult. Ingreso',
                'Cantidad Ult. Ingreso',
                'U.M. Ult. Ingreso',
                'Nro. Trans Inicial',
                'Proveedor',
                'Fecha Ult. Venta',
                'Tipo Compra'
            ];
        }
        return $titulos;
    }
    public function title(): string
    {
        return $this->title;
    }
}
