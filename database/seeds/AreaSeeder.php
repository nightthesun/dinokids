<?php
use App\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create([    
            'id'=>1,        
            'nombre'=>'Contabilidad',
            'descrip'=>'Contabilidad',
        ]);  
        Area::create([     
            'id'=>2,         
            'nombre'=>'Ventas',
            'descrip'=>'Ventas',
        ]); 
        Area::create([  
            'id'=>3,            
            'nombre'=>'Administración',
            'descrip'=>'Administración',
        ]); 
        Area::create([  
            'id'=>4,            
            'nombre'=>'Sistemas',
            'descrip'=>'Sistemas',
        ]); 
        Area::create([  
            'id'=>5,            
            'nombre'=>'Almacén',
            'descrip'=>'Almacén',
        ]); 
        Area::create([
            'id'=>6,              
            'nombre'=>'Inventario',
            'descrip'=>'Inventario',
        ]); 
        Area::create([
            'id'=>7,              
            'nombre'=>'Marketing',
            'descrip'=>'Marketing',
        ]); 
    }
}
