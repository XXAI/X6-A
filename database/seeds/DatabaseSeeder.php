<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $this->call(ServidoresSeeder::class);
        $this->call(PermisosSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(CatalogosSeeder::class);
        $this->call(UsuariosSeeder::class);
        $this->call(JurisdiccionesSeeder::class);
        $this->call(TemasSeeder::class);
        $this->call(AmbitoRiesgosSeeder::class);
        $this->call(EjecutivoSeeder::class);
        $this->call(tipoProgramacionSeeder::class);
        
    }
}
