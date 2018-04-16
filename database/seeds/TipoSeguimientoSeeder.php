<?php

use Illuminate\Database\Seeder;

class TipoSeguimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_seguimiento')->insert([
            [
                'id' => 1,
                'descripcion' => 'NOTIFICACIONES',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'id' => 2,
                'descripcion' => 'CITATORIOS',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'id' => 3,
                'descripcion' => 'RESOLUCIONES',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'id' => 4,
                'descripcion' => 'AMONESTACIONES',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ],
            [
                'id' => 5,
                'descripcion' => 'MULTAS',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ]
        ]);
    }
}
