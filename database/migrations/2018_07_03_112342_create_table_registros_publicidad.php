<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegistrosPublicidad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_publicidad', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('no',100);
            $table->string('no_informe_verificacion',100);
            $table->Integer('id_medio_utilizado');
            $table->string('usuario_responsable', 255);

            $table->Integer('id_dictamen');
            $table->Integer('id_medida_seguridad');
            $table->Integer('id_resolucion_administrativa');
            $table->Integer('id_sancion_administrativa');
            $table->date('fecha_emision');
            $table->timestamps();
            $table->softDeletes();

           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('registro_publicidad');
    }
}
