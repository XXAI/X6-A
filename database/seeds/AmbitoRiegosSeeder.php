<?php

use Illuminate\Database\Seeder;

class AmbitoRiegosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ambito_riesgo')->insert([
            [
                'id' => '1',
                'id_ejecutivo' => '1',
                'descripcion' => 'Exposición a riesgos sanitarios por alimentos'
            ],
            [
                'id' => '2',
                'id_ejecutivo' => '1',
                'descripcion' => 'Exposición a riesgos sanitarios por insumos a la salud (Farmacovigilancia)'
            ],
            [
                'id' => '3',
                'id_ejecutivo' => '1',
                'descripcion' => 'Exposición a riesgos sanitarios en Establecimientos de Atención Médica'
            ],
            [
                'id' => '4',
                'id_ejecutivo' => '1',
                'descripcion' => 'Exposición a riesgos sanitarios por otros productos y servicios de consumo, tabaco y alcohol'
            ],
            [
                'id' => '5',
                'id_ejecutivo' => '2',
                'descripcion' => 'Exposición a riesgos sanitarios por emergencias sanitarias'
            ],
            [
                'id' => '6',
                'id_ejecutivo' => '3',
                'descripcion' => 'Exposición a riesgos sanitarios por sanitarios ambientales'
            ],
            [
                'id' => '7',
                'id_ejecutivo' => '3',
                'descripcion' => 'Exposición a riesgos sanitarios laborales'
            ]
        ]);
    }
}
