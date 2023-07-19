<?php
use App\Role;
use App\Permiso;
use App\User;
use App\Perfil;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'id'=> 10,
            'name' => 'admin',
            'password' => Hash::make('123'),
            'elim' => 0,
            'val'=>1,
            'dbiz_user'=>4
        ]);
        $perfil = Perfil::create([
            'nombre' => 'Victor',
            'paterno'=> 'Sullca',
            'materno'=> 'Llanos',
            'ci'=> '9126177',
            'ci_e' => 'LP',
            'user_id'=>10,
        ]);
        /*for ($i=1; $i <= count(Permiso::get()) ; $i++) 
        { 
            $user->permisos()->attach(Permiso::where('id', $i)->first());
        }
        $user = User::create([
            'name' => 'user',
            'password' => Hash::make('123'),
            'nombre' => 'Usuario',
            'paterno'=> 'Apellido',
            'materno'=> 'Apellido',
            'ci'=> '0000001',
            'ci_e' => 'LP',
            'rol'=>'admin',
            'area'=>'Sistemas',
            'sucursal'=>'Ballivian',
            'sucursal'=>'Ballivian',
            'val'=>1,
            'cargo'=>'user',
        ]);
        $user = User::create([
            'name' => 'user2',
            'password' => Hash::make('123'),
            'nombre' => 'Usuario2',
            'paterno'=> 'Apellido',
            'materno'=> 'ApellidoM',
            'ci'=> '0000002',
            'ci_e' => 'LP',
            'rol'=>'admin',
            'area'=>'Sistemas',
            'sucursal'=>'Ballivian',
            'sucursal'=>'Ballivian',
            'val'=>1,
            'cargo'=>'user',
        ]);*/
    }
}
