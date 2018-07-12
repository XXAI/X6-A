<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegistrosLicencia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_licencia', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('no',100);
            $table->string('no_solicitud',100);
            $table->date('fecha_recepcion');
            $table->Integer('id_giro');
            $table->string('establecimiento', 255);

            $table->Integer('id_verificacion_sanitaria');
            $table->Integer('id_dictamen');
            $table->Integer('id_notificacion');
            $table->string('no_licencia', 255);

            $table->date('fecha_emision');
            $table->date('fecha_entrega');
            $table->Integer('id_estatus');
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
        Schema::drop('registro_licencia');
    }
}
