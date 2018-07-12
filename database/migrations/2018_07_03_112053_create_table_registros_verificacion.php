<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegistrosVerificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_verificacion', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('no',100);
            $table->string('no_orden',100);
            $table->date('fecha_orden');
            $table->Integer('id_area_operativa');
            $table->Integer('id_motivo_orden_verificacion');
            $table->Integer('id_fiscalia');
            $table->Integer('id_toma_muestra');
            $table->Integer('id_giro');
            $table->string('establecimiento', 255);
            $table->date('fecha_acta');
            $table->Integer('id_tipo_acta');
            $table->Integer('id_primer_verificador');
            $table->Integer('id_segundo_verificador');
            $table->Integer('id_medida_seguridad');
            $table->text('motivo_suspension');
            $table->date('fecha_envio_dictamen');
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
        Schema::drop('registro_verificacion');
    }
}
