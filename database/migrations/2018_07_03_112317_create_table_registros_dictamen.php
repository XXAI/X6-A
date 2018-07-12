<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegistrosDictamen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_dictamen', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('no',100);
            $table->string('no_acta',100);
            $table->Integer('id_area_operativa');
            $table->Integer('id_dictaminador');
            $table->date('fecha_recepcion');
            $table->Integer('id_giro');
            $table->string('establecimiento', 255);
            $table->Integer('id_tipo_dictamen');
            $table->date('fecha_dictamen');
            $table->Integer('id_resultado_lesp');
            $table->Integer('id_anomalias');
            $table->Integer('id_medida_seguridad');
            $table->string('no_notificacion',100);
            $table->date('fecha_emision');
            $table->date('fecha_entrega_notificar');
            $table->date('fecha_notificacion');
            $table->Integer('id_respuesta_usuario');
            $table->Integer('acta_seguimiento_numero');
            $table->Integer('id_estatus');
            $table->date('fecha_envio_resolucion');
            $table->string('usuario_id');
            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('registro_dictamen');
    }
}
