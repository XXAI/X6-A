<?php

use Illuminate\Database\Seeder;

class JurisdiccionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jurisdiccion')->insert([
            [
                'id' => '1',
                'descripcion' => 'TUXTLA GUTIERREZ'
            ],
            [
                'id' => '2',
                'descripcion' => 'SAN CRISTOBAL'
            ],
            [
                'id' => '3',
                'descripcion' => 'COMITAN'
            ],
            [
                'id' => '4',
                'descripcion' => 'VILLAFLORES'
            ],
            [
                'id' => '5',
                'descripcion' => 'PICHUCALCO'
            ],
            [
                'id' => '6',
                'descripcion' => 'PALENQUE'
            ],
            [
                'id' => '7',
                'descripcion' => 'TAPACHULA'
            ],
            [
                'id' => '8',
                'descripcion' => 'TONALA'
            ],
            [
                'id' => '9',
                'descripcion' => 'OCOSINGO'
            ],
            [
                'id' => '10',
                'descripcion' => 'MOTOZINTLA'
            ]
        ]);
    }
}
