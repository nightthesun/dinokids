<?php

use App\Permiso;
use App\User;
use Illuminate\Database\Seeder;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //USUARIOS
        Permiso::create([  
            'id'=>1,          
            'desc' => 'Ver',
            'p'=>'Ver',
        ]);  
        Permiso::create([    
            'id'=>2,        
            'desc' => 'Editar',
            'p' => 'Editar',
        ]); 
        Permiso::create([   
            'id'=>3,           
            'desc' => 'Eliminar',
            'p' => 'Eliminar',
        ]); 
        Permiso::create([  
            'id'=>4,           
            'desc' => 'Ver usuarios OAS',
            'p' => 'Ver usuarios OAS',
        ]);
        Permiso::create([    
            'id'=>5,         
            'desc' => 'Ver todos los usuario (DualBiz)',
            'p' => 'Ver usuarios DualBiz',
        ]);
        Permiso::create([     
            'id'=>6,          
            'desc' => 'Cambio de Fechas',
            'p' => 'Cambio de Fechas',
        ]);
        Permiso::create([     
            'id'=>7,          
            'desc' => 'Rango de Fechas',
            'p' => 'Rango de Fechas',
        ]);
        Permiso::create([       
            'id'=>8,       
            'desc' => 'Precio Punto de Venta',
            'p' => 'Precio Punto de Venta',
        ]);
        Permiso::create([
            'id'=>9,       
            'desc' => 'Ver Todos los Almacenes',
            'p' => 'Ver Todos los Almacenes', 
        ]);
        Permiso::create([
            'id'=>10,       
            'desc' => 'Ver Pareto',
            'p' => 'Ver Pareto', 
        ]);
        Permiso::create([
            'id'=>11,       
            'desc' => 'Ver Costos',
            'p' => 'Ver Costos', 
        ]);
        Permiso::create([
            'id'=>12,       
            'desc' => 'Ver Excel',
            'p' => 'Ver Excel', 
        ]);
    }
}
