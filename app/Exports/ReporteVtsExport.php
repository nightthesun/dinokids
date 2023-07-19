<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteVtsExport implements WithMultipleSheets
{
    use Exportable;

    protected $productos;
    protected $reporte;
    protected $stock;
    protected $pyc;
    protected $ini;
    
    public function __construct(array $reporte, array $productos, 
    array $stock, array $pyc, array $ini, array $titulos, array $head, array $range3, array $ran4)
    {
        $this->reporte = $reporte;
        $this->productos = $productos;
        $this->stock = $stock;
        $this->pyc = $pyc;
        $this->ini = $ini;
        $this->titulos = $titulos;
        $this->head = $head;
        $this->range3 = $range3;
        $this->ran4 = $ran4;
    }

    public function sheets(): array
    {
        $sheets = [];
        $reporte = $this->reporte;
        $sheets[] = new ReporteVtsIniExport('ini','VTS',$this->ini, $this->titulos, $this->head, $this->range3, $this->ran4);
        foreach ($reporte as $k => $rep) {
            $sheets[] = new ReporteVtsSheetExport('ventas',$k,$rep);
        }
        $sheets[] = new ReporteVtsSheetExport('productos','Productos',$this->productos);
        $sheets[] = new ReporteVtsSheetExport('stock','Stock',$this->stock);
        $sheets[] = new ReporteVtsSheetExport('pyc','PYC',$this->pyc);
        return $sheets;
    }
}
