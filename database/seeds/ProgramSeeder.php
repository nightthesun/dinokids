<?php

use Illuminate\Database\Seeder;
use App\Program;
use App\Permiso;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $smod = Program::create([    
            'id'=>1,
            'nombre'=>'Usuarios',        
            'modulo_id'=>1,
            'route'=>'usuario.index',
            'icon'=>'fas fa-users',
        ]);  

        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(2));
        $smod->permisos()->attach(Permiso::find(3));

        $smod = Program::create([    
            'id'=>2,
            'nombre'=>'Funcionarios',        
            'modulo_id'=>1,
            'route'=>'perfil.index',
            'icon'=>'fas fa-user-circle',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(2));
        $smod->permisos()->attach(Permiso::find(3));

        $smod = Program::create([    
            'id'=>3,
            'nombre'=>'Compras y Movimientos',        
            'modulo_id'=>6,
            'sub_modulo_id'=>3,
            'route'=>'comprasmov.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>4,  
            'nombre'=>'Compras Locales y Movimientos',        
            'modulo_id'=>6,
            'sub_modulo_id'=>3,
            'route'=>'compraslocmov.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>5,  
            'nombre'=>'Stock Actual',        
            'modulo_id'=>6,
            'sub_modulo_id'=>1,
            'route'=>'stock.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(6));
        $smod->permisos()->attach(Permiso::find(8));
        $smod->permisos()->attach(Permiso::find(9));
        $smod->permisos()->attach(Permiso::find(12));

        $smod = Program::create([   
            'id'=>6, 
            'nombre'=>'Inventario PCs',        
            'modulo_id'=>4,
            'sub_modulo_id'=>4,
            'route'=>'inventariosistemas.index',
            'icon'=>'fas fa-laptop',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([    
            'id'=>7,
            'nombre'=>'Ventas Institucional/Mayorista',        
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'ventasinsmayo.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(5));
        $smod->permisos()->attach(Permiso::find(4));
        $smod->permisos()->attach(Permiso::find(7));

        $smod = Program::create([    
            'id'=>8,
            'nombre'=>'Cuentas Por Cobrar',        
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'cuentasporcobrar.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(5));
        $smod->permisos()->attach(Permiso::find(6));

        $smod = Program::create([    
            'id'=>9,
            'nombre'=>'Resumen Total de Ventas',  
            'desc'=>'Resumen Total de Ventas',      
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'resumenventastotal.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([    
            'id'=>10,
            'nombre'=>'Notas De Remisión',  
            'desc'=>'Reporte de Notas de Remisión DualBiz',        
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'notasremision.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(4));
        $smod->permisos()->attach(Permiso::find(5));
        $smod->permisos()->attach(Permiso::find(7));

        $smod = Program::create([  
            'id'=>11,  
            'nombre'=>'Traspasos',         
            'modulo_id'=>6,
            'sub_modulo_id'=>1,
            'route'=>'traspasos.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(5));
        $smod->permisos()->attach(Permiso::find(6));
    
        $smod = Program::create([  
            'id'=>12,  
            'nombre'=>'Precios/Costos',      
            'desc'=>'Precios y costos',    
            'modulo_id'=>'6',
            'route'=>'precioscostos.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([   
            'id'=>13, 
            'nombre'=>'Dispositivos',  
            'desc'=>'Inventario Dispositivos Sistemas',        
            'modulo_id'=>4,
            'sub_modulo_id'=>4,
            'route'=>'dispositivos.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([   
            'id'=>14, 
            'nombre'=>'Resumen de Ventas y Cobros',  
            'desc'=>'Resumen de Ventas y Cobros',        
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'resumenventascobros.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([   
            'id'=>15, 
            'nombre'=>'Analisis de Ventas Mixto 1',  
            'desc'=>'Analisis de Ventas Mixto 1',        
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'ventamarcauser.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(5));
        $smod->permisos()->attach(Permiso::find(6));
        $smod->permisos()->attach(Permiso::find(10));

        $smod = Program::create([   
            'id'=>16, 
            'nombre'=>'Reporte Ventas Por Segmento',  
            'desc'=>'INVENTARIO CV VS PV POR SEGMENTO',        
            'modulo_id'=>6,
            'route'=>'reportevts.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([   
            'id'=>17, 
            'nombre'=>'Permisos',  
            'desc'=>'Formulario de Permisos',        
            'modulo_id'=>3,
            'route'=>'licencia.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([   
            'id'=>18, 
            'nombre'=>'Vacaciones',  
            'desc'=>'Formulario de Vacaciones',        
            'modulo_id'=>3,
            'route'=>'vacacion.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>19,  
            'nombre'=>'Precios',      
            'desc'=>'Reporte de Precios',    
            'modulo_id'=>'6',
            'route'=>'precios.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>20,  
            'nombre'=>'Cotizacion',      
            'desc'=>'Cotizaciones',    
            'modulo_id'=>'5',
            'route'=>'cotizacion.create',
            'icon'=>'fas fa-shopping-cart',  
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>21,  
            'nombre'=>'Planificacion',      
            'desc'=>'Planificacion',    
            'modulo_id'=>'5',
            'route'=>'planificacion.create',
            'icon'=>'fas fa-bookmark',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>22,  
            'nombre'=>'Diferencia de Costos',      
            'desc'=>'Diferencia de Costos',    
            'modulo_id'=>'6',
            'route'=>'difereciacosto.index',
            'icon'=>'fas fa-bookmark',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>23,  
            'nombre'=>'Reporte de Kardex',      
            'desc'=>'Reporte de Kardex',  
            'modulo_id'=>'6',
            'route'=>'kardexreport.index',
            'icon'=>'fas fa-bookmark',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(11));

        $smod = Program::create([  
            'id'=>24,  
            'nombre'=>'Toma de Invenario',      
            'desc'=>'Toma de Inventario',  
            'modulo_id'=>'7',
            'route'=>'tominvtom.index',
            'icon'=>'fas fa-box-check',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>25,  
            'nombre'=>'Analisis Toma de Invenario',      
            'desc'=>'Analisis Toma de Inventario',  
            'modulo_id'=>'7',
            'route'=>'tominvreq.index',
            'icon'=>'fas fa-box-check',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        
        $smod = Program::create([  
            'id'=>26,  
            'nombre'=>'Consulta Productos',      
            'desc'=>'Consulta Productos',  
            'modulo_id'=>'7',
            'route'=>'invconsult.index',
            'icon'=>'fas fa-box-check',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>27,  
            'nombre'=>'Productos x Ubicacion',      
            'desc'=>'Productos x Ubicacion',  
            'modulo_id'=>'7',
            'route'=>'tominvprodubi.index',
            'icon'=>'fas fa-box-check',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        /*$smod = Program::create([  
            'id'=>28,  
            'nombre'=>'Parametros',      
            'desc'=>'Parametros',  
            'modulo_id'=>'1',
            'route'=>'param.index',
            'icon'=>'fas fa-box-check',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));*/

        $smod = Program::create([  
            'id'=>28,  
            'nombre'=>'Stock (I-E-T-V)',         
            'modulo_id'=>6,
            'sub_modulo_id'=>1,
            'route'=>'stockventa.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(9));
        $smod->permisos()->attach(Permiso::find(12));

        $smod = Program::create([  
            'id'=>29,  
            'nombre'=>'Crear Equipos',      
            'desc'=>'Crear Equipos',  
            'modulo_id'=>'4',
            'route'=>'empleado.index',
            'icon'=>'fas fa-laptop',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>30,  
            'nombre'=>'Crear Computadora',      
            'desc'=>'Crear Computadora',  
            'modulo_id'=>'1',
            'route'=>'computadoras.store',
            'icon'=>'fas fa-laptop',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>31,  
            'nombre'=>'Crear Computadora',      
            'desc'=>'Crear Computadora',  
            'modulo_id'=>'1',
            'route'=>'computadoras.store',
            'icon'=>'fas fa-laptop',
        ]); 

        $smod = Program::create([  
            'id'=>33,  
            'nombre'=>'Reporte Cotizacion',         
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'CotizacionReporte.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>30,  
            'nombre'=>'Stock MaxMin',        
            'modulo_id'=>6,
            'sub_modulo_id'=>1,
            'route'=>'stockminmax.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(6));
        $smod->permisos()->attach(Permiso::find(8));
        $smod->permisos()->attach(Permiso::find(9));

        $smod = Program::create([  
            'id'=>31,  
            'nombre'=>'Resumen Comparativo de Ventas',        
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'resumenxmes.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([    
            'id'=>32,
            'nombre'=>'Cuentas Por Pagar',        
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'cuentasporpagar.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(5));
        $smod->permisos()->attach(Permiso::find(6));

        $smod = Program::create([  
            'id'=>33,  
            'nombre'=>'Comparativo Costos/Ventas 2022',        
            'modulo_id'=>6,
            'sub_modulo_id'=>2,
            'route'=>'resumenxmescosto.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>34,  
            'nombre'=>'Lista de Precios',        
            'modulo_id'=>7,
            'sub_modulo_id'=>null,
            'route'=>'listaPrecio.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>35,  
            'nombre'=>'Kardex X Almacen',        
            'modulo_id'=>6,
            'sub_modulo_id'=>null,
            'route'=>'kardexalmacen.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));

        $smod = Program::create([  
            'id'=>36,  
            'nombre'=>'Stock Actual',        
            'modulo_id'=>7,
            'sub_modulo_id'=>null,
            'route'=>'stock.index',
            'icon'=>'fas fa-file-contract',
        ]); 
        $smod->permisos()->attach(Permiso::find(1));
        $smod->permisos()->attach(Permiso::find(6));
        $smod->permisos()->attach(Permiso::find(8));
        $smod->permisos()->attach(Permiso::find(9));
        $smod->permisos()->attach(Permiso::find(12));
    }
}
