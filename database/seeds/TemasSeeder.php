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
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Calidad Microbiológica de Alimentos'
            ],
            [
                'id' => '2',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Productos de la Pesca '
            ],
            [
                'id' => '3',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Alimentos Potencialmente  Peligrosos'
            ],
            [
                'id' => '4',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Agua y Hielo Purificados'
            ],
            [
                'id' => '5',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Rastros y Mataderos'
            ],
            [
                'id' => '6',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Zoonosis y Brucelosis'
            ],
            [
                'id' => '7',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Marea Roja'
            ],
            [
                'id' => '8',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Control del uso ilegal de clembuterol'
            ],
            [
                'id' => '9',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Sal Yodada y Floururada'
            ],
            [
                'id' => '10',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Harina de Trigo Fortificada'
            ],
            [
                'id' => '11',
                'id_ambito_riesgo' => '1',
                'descripcion' => 'Cursos de Manejo Higienico de Alimentos'
            ],
            [
                'id' => '12',
                'id_ambito_riesgo' => '2',
                'descripcion' => 'Farmacovigilancia'
            ],
            [
                'id' => '13',
                'id_ambito_riesgo' => '2',
                'descripcion' => 'Vigilancia Regular Servicios de Salud'
            ],
            [
                'id' => '14',
                'id_ambito_riesgo' => '2',
                'descripcion' => 'Productos Frontera'
            ],
            [
                'id' => '15',
                'id_ambito_riesgo' => '3',
                'descripcion' => 'Residuos Peligrosos Biológico Infecciosos (RPBI)'
            ],
            [
                'id' => '16',
                'id_ambito_riesgo' => '3',
                'descripcion' => 'Infecciones nosocomiales'
            ],
            [
                'id' => '17',
                'id_ambito_riesgo' => '3',
                'descripcion' => 'Muerte Materno-Infantil'
            ],
            [
                'id' => '18',
                'id_ambito_riesgo' => '4',
                'descripcion' => 'Humo de Tabaco'
            ],
            [
                'id' => '19',
                'id_ambito_riesgo' => '4',
                'descripcion' => 'Vigilancia y control de Bebidas Alcohólicas'
            ],
            [
                'id' => '20',
                'id_ambito_riesgo' => '4',
                'descripcion' => 'Vigilancia y control de NO Venta de  Bebidas Alcohólicas a Menores de Edad'
            ],
            [
                'id' => '21',
                'id_ambito_riesgo' => '5',
                'descripcion' => 'Exposición a riesgos sanitarios por emergencias sanitarias'
            ],
            [
                'id' => '22',
                'id_ambito_riesgo' => '6',
                'descripcion' => 'Playas limpias: agua de mar para uso recreativo con contacto primario'
            ],
            [
                'id' => '23',
                'id_ambito_riesgo' => '6',
                'descripcion' => 'Exposición Intradomiciliaria a Humo de Leña'
            ],
            [
                'id' => '24',
                'id_ambito_riesgo' => '6',
                'descripcion' => 'Agua de Calidad Fisicoquímica'
            ],
            [
                'id' => '25',
                'id_ambito_riesgo' => '6',
                'descripcion' => 'Agua de Calidad Bacteriológica'
            ],
            [
                'id' => '26',
                'id_ambito_riesgo' => '6',
                'descripcion' => 'Monitoreo Ambiental de Vibrio cholerae'
            ],
            [
                'id' => '27',
                'id_ambito_riesgo' => '6',
                'descripcion' => 'Bebederos'
            ],
            [
                'id' => '28',
                'id_ambito_riesgo' => '7',
                'descripcion' => 'Plomo en Loza Vidriada'
            ],
            [
                'id' => '29',
                'id_ambito_riesgo' => '7',
                'descripcion' => 'Uso de Plaguicidas'
            ],
            [
                'id' => '30',
                'id_ambito_riesgo' => '7',
                'descripcion' => 'Protección Radiológica'
            ]
        ]);
    }
}
