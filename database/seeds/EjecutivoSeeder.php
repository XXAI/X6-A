<?php

use Illuminate\Database\Seeder;

class EjecutivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ejecutivo')->insert([
            [
                'id' => '1',
                'descripcion' => 'Ejecutivo 1'
            ],
            [
                'id' => '2',
                'descripcion' => 'Ejecutivo 2'
            ],
            [
                'id' => '3',
                'descripcion' => 'Ejecutivo 3'
            ],
            [
                'id' => '4',
                'descripcion' => 'Ejecutivo 4'
            ]
        ]);
    }
}
