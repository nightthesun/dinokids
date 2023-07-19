<?php
use App\Modulo;
use Illuminate\Database\Seeder;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modulo::create([   
            'id'=>1,         
            'nombre'=>'Configuracion',    
            'icon'=>'fas fa-wrench',
        ]);  
        Modulo::create([ 
            'id'=>2,         
            'nombre'=>'Contabilidad',      
        ]);  
        Modulo::create([  
            'id'=>3,        
            'nombre'=>'RRHH',      
        ]);  
        Modulo::create([   
            'id'=>4,       
            'nombre'=>'Sistemas',
            'icon'=>'fas fa-desktop',         
        ]);  
        Modulo::create([   
            'id'=>5,         
            'nombre'=>'Ventas',   
            'icon'=>'fas fa-shopping-cart',   
        ]);  
        Modulo::create([
            'id'=>6,            
            'nombre'=>'Reportes Dualbiz',      
        ]);  
        Modulo::create([
            'id'=>7,            
            'nombre'=>'Inventarios',   
            'icon'=>'fas fa-boxes',   
        ]); 
        Modulo::create([
            'id'=>8,            
            'nombre'=>'Contabilidad',   
        ]); 
    }
}
