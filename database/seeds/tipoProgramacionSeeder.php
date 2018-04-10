<?php

use Illuminate\Database\Seeder;

class tipoProgramacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_programacion')->insert([
            [
                'id' => 1,
                'descripcion' => 'VERIFICACION',
                'tiempo_captura' => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'id' => 2,
                'descripcion' => 'MUESTRA',
                'tiempo_captura' => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'id' => 3,
                'descripcion' => 'CAPACITACION',
                'tiempo_captura' => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'id' => 4,
                'descripcion' => 'DICTAMEN',
                'tiempo_captura' => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'id' => 5,
                'descripcion' => 'REACCION',
                'tiempo_captura' => 1,
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ]
        ]);
    }
}
