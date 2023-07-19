<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                AreaSeeder::class,
                ModuloSeeder::class,
                PermisoSeeder::class, 
                ProgramSeeder::class,
                SubModuloSeeder::class,
                UnidadSeeder::class,
                VentaSegmentoSeeder::class,
            ]
        );
    }
}
