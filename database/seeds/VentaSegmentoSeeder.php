<?php

use App\VentaSegmento;
use Illuminate\Database\Seeder;

class VentaSegmentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $segemnto = VentaSegmento::create([
            'id'=>1,
            'title'=>'Administrativo',
            'abre'=>'ADMIN',
            'name'=>'ADMINISTRATIVO',
        ]);
        $segemnto = VentaSegmento::create([
            'id'=>2,
            'title'=>'Institucional',
            'abre'=>'INST',
            'name'=>'INSTITUCIONAL',
        ]);
        $segemnto = VentaSegmento::create([
            'id'=>3,
            'title'=>'Mayorista',
            'abre'=>'MAYO',
            'name'=>'MOYORISTA',
        ]);
        $segemnto = VentaSegmento::create([
            'id'=>4,
            'title'=>'Retail',
            'abre'=>'Retail',
            'name'=>'RETAIL',
        ]);
        $segemnto = VentaSegmento::create([
            'id'=>5,
            'title'=>'Feria',
            'abre'=>'FERIA',
            'name'=>'FERIA',
        ]);
        $segemnto = VentaSegmento::create([
            'id'=>6,
            'title'=>'Otros',
            'abre'=>'OTR',
            'name'=>'OTROS',
        ]);
    }
}
