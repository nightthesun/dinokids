<?php
use App\Unidad;
use Illuminate\Database\Seeder;

class UnidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unidad::create([
            'id'=>1,
            'nombre' => 'Administracion',
            'abrev'=>'Admin',
            'descrip' => ''
        ]);
        Unidad::create([
            'id'=>2,
            'nombre' => 'Casa Matriz',
            'abrev'=>'CM',
            'descrip' => ''
        ]);
        Unidad::create([
            'id'=>3,
            'nombre' => 'Handal',
            'abrev'=>'HAN',
            'descrip' => ''
        ]);
        Unidad::create([
            'id'=>4,
            'nombre' => 'Mariscal',
            'abrev'=>'MCAL',
            'descrip' => ''
        ]);
        Unidad::create([
            'id'=>5,
            'nombre' => 'Calacoto',
            'abrev'=>'CAL',
            'descrip' => ''
        ]);
        Unidad::create([
            'id'=>6,
            'nombre' => 'Almacen Central',
            'abrev'=>'AC2',
            'descrip' => ''
        ]);
        Unidad::create([
            'id'=>7,
            'nombre' => 'Planta El Alto',
            'abrev'=>'PLANT',
            'descrip' => ''
        ]);
        Unidad::create([
            'id'=>8,
            'nombre' => 'Santa Cruz',
            'abrev'=>'SC',
            'descrip' => ''
        ]);
    }
}
