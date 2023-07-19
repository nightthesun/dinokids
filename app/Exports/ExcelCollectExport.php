<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExcelCollectExport implements withHeadings, WithMapping, FromArray, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(array $col, array $titles)
    {
        $this->col = $col;
        $this->titles = $titles;
        //return dd($pvp);
    }
    public function array(): array
    {
        return $this->col;
    }
    public function map($row): array
    {
        /*if(isset($row['ubi']['nro']))
        {
            $row['ubi']['nro']='vacio';
        }*/
        return [
            [
                $row['id'],$row['prod'],$row['marca'],$row['descrip'],$row['barcod'],
                $row['cantidad'],$row['um'],$row['cont_id'],$row['hoja'],$row['ubi']['nro']
            ],
        ];
    }
    public function headings(): array
    {
        return $this->titles;
    }
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
