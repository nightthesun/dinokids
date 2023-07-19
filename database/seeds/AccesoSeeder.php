<?php

use App\User;
use App\Permiso;
use App\Program;
use App\Acceso;
use Illuminate\Database\Seeder;

class AccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find('10');
        for ($i=1; $i <= count(Program::get()) ; $i++) 
        { 
            $perms = Program::find($i)->permisos;
            foreach ($perms as $per) 
            {                 
                $user->permisos()->attach(Permiso::where('id', $i)->first());
                $submod = Program::find($i);
                Acceso::create([            
                    'user_id'=>$user->id,
                    'program_id' => $submod->id,
                    'permiso_id'=>$per->id         
                ]);  
            }
        }
    }
}
