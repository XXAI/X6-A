<?php

use Illuminate\Database\Seeder;

class TemasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tema')->insert([
            [
                'id' => '1',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'PRODUCTOS CARNICOS'
            ],
            [
                'id' => '2',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'PRODUCTOS DE LA PESCA'
            ],
            [
                'id' => '3',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'PRODUCTOS LACTEOS'
            ],
            [
                'id' => '4',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'ALIMENTOS PREPARADOS'
            ],
            [
                'id' => '5',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'AGUA Y HIELO PURIFICADOS'
            ],
            [
                'id' => '6',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'ALIMENTOS POTENCIALMENTE PELIGROSOS'
            ],
            [
                'id' => '7',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'RATROS Y MATADEROS'
            ],
            [
                'id' => '8',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'MAREA ROJA'
            ],
            [
                'id' => '9',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'CONTROL DEL USO DEL CLEMBUTEROL'
            ],
            [
                'id' => '10',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'HARINA DE TRIGO FORTIFICADA'
            ],
            [
                'id' => '11',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'MANEJO HIGIENICO DE ALIMENTOS'
            ],
            [
                'id' => '12',
                'id_ambito_riesgo' => '0',
                'descripcion' => '6 PASOS'
            ],
            [
                'id' => '13',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'FARMACOVIGILANCIA'
            ],
            [
                'id' => '14',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'REACCIONES ADVERSAS A MEDICAMENTOS'
            ],
            [
                'id' => '15',
                'id_ambito_riesgo' => '2',
                'descripcion' => 'VIGILANCIA REGULAR SERVICIOS DE SALUD'
            ],
            [
                'id' => '16',
                'id_ambito_riesgo' => '2',
                'descripcion' => 'PRODUCTOS FRONTERA'
            ],
            [
                'id' => '17',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'HUMO DE TABACO'
            ],
            [
                'id' => '18',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'BEBIDAS ALCOHOLICAS'
            ],
            [
                'id' => '19',
                'id_ambito_riesgo' => '4',
                'descripcion' => 'VIGILANCIA Y CONTROL DE NO VENTA DE BEBIDAS ALCOHOLICAS A MENORES DE EDAD'
            ],
            [
                'id' => '20',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'MUNICIPIOS ATENDIDOS'
            ],
            [
                'id' => '21',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'POBLACIÓN ATENDIDA'
            ],
            [
                'id' => '22',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'EVALUACIÓN SANITARIA A INSTITUCIONES EDUCATIVAS DE NIVEL PRIMARIA Y SECUNDARIA'
            ],
            [
                'id' => '23',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'POBLACIONES CON MAYOR NUMERO DE CASOS DE ENFERMEDADES DIARREICAS, RESPIRATORIAS Y DENGUE EN EL ESTADO'
            ],
            [
                'id' => '24',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'PLAYA LIMPIA'
            ],
            [
                'id' => '25',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'AGUA DE CALIDAD BACTERIOLOGICA'
            ],
            [
                'id' => '26',
                'id_ambito_riesgo' => '6',
                'descripcion' => 'AGUA DE CALIDAD FISICOQUIMICA'
            ],
            [
                'id' => '27',
                'id_ambito_riesgo' => '6',
                'descripcion' => 'MONITOREO DE CLORO LIBRE RESIDUAL EN PUNTOS GEOREFERENCIADOS'
            ],
            [
                'id' => '28',
                'id_ambito_riesgo' => '6',
                'descripcion' => 'VIDRIO CHOLERAE'
            ],
            [
                'id' => '29',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'SISTEMAS FORMALES DE ABASTECIMIENTO DE AGUA'
            ],
            [
                'id' => '30',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'USO DE PLOMO EN LOZA VIDRIADA'
            ],
            [
                'id' => '31',
                'id_ambito_riesgo' => '7',
                'descripcion' => 'USO DE PLAGUICIDAS'
            ],
            [
                'id' => '32',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'REDUCCIÓN A LA EXPOSICIÓN LABORAL POR EL USO DE PLAGUICIDAS'
            ],
            [
                'id' => '33',
                'id_ambito_riesgo' => '0',
                'descripcion' => 'REUNIONES Y PLATICAS'
            ]
        ]);
    }
}
