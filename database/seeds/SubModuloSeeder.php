<?php
use App\SubModulo;
use App\Modulo;
use App\Permiso;
use Illuminate\Database\Seeder;

class SubModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $smod = SubModulo::create([   
            'id'=>1,         
            'nombre'=>'Inventario',
            'modulo_id'=>6,
            'desc'=>'',          
        ]); 
        $smod = SubModulo::create([  
            'id'=>2,          
            'nombre'=>'Ventas',
            'modulo_id'=>6,
            'desc'=>'',          
        ]); 
        $smod = SubModulo::create([      
            'id'=>3,      
            'nombre'=>'Compras',
            'modulo_id'=>6,
            'desc'=>'',          
        ]); 
        $smod = SubModulo::create([ 
            'id'=>4,           
            'nombre'=>'Inventario',
            'modulo_id'=>4,
            'desc'=>'Inventario de Modulo de Sistemas',          
        ]); 
        $smod = SubModulo::create([ 
            'id'=>5,           
            'nombre'=>'Toma de Inventario',
            'modulo_id'=>7,
            'desc'=>'Toma de Inventario',          
        ]); 
    }
}
