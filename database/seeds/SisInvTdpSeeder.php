<?php

use Illuminate\Database\Seeder;
use SisInvTdp;
class SisInvTdpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SisInvTdp::create([
            'id'=>1,       
            'name' => 'CPU',
            'desc' => 'CPU',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>2,       
            'name' => 'Tarjeta Madre',
            'desc' => 'Tarjeta Madre',
            'icon' => '', 
        ]);        
        SisInvTdp::create([
            'id'=>3,       
            'name' => 'Disco Duro',
            'desc' => 'Disco Duro',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>4,       
            'name' => 'RAM',
            'desc' => 'RAM',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>5,       
            'name' => 'Fuente de Poder',
            'desc' => 'Fuente de Poder',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>6,       
            'name' => 'Lector DVD',
            'desc' => 'Lector DVD',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>7,       
            'name' => 'Mouse',
            'desc' => 'Mouse',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>8,       
            'name' => 'Teclado',
            'desc' => 'Teclado',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>9,       
            'name' => 'Monitor',
            'desc' => 'Monitor',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>10,       
            'name' => 'Impresora',
            'desc' => 'Impresora',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>11,       
            'name' => 'Parlantes',
            'desc' => 'Parlantes',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>12,       
            'name' => 'Adaptador de Red',
            'desc' => 'Adaptador de Red',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>13,       
            'name' => 'SSD',
            'desc' => 'SSD',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>14,       
            'name' => 'Antena Wi-Fi',
            'desc' => 'Antena Wi-Fi',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>15,       
            'name' => 'Lector Disket',
            'desc' => 'Lector Disket',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>16,       
            'name' => 'Lector Codigo de Barras',
            'desc' => 'Lector Codigo de Barras',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>17,       
            'name' => 'Lector CD',
            'desc' => 'Lector CD',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>18,       
            'name' => 'Tarjeta de Video',
            'desc' => 'Tarjeta de Video',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>19,       
            'name' => 'Tarjeta de Red',
            'desc' => 'Tarjeta de Red',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>20,       
            'name' => 'Tarjeta de Sonido',
            'desc' => 'Tarjeta de Sonido',
            'icon' => '', 
        ]);
        SisInvTdp::create([
            'id'=>21,       
            'name' => 'Tarjeta de Expansion USB',
            'desc' => 'Tarjeta de EXpasion USB',
            'icon' => '', 
        ]);
    }
}
