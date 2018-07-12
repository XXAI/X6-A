<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegistrosResolucion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_resolucion', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('no',100);
            $table->Integer('id_area_operativa');
            $table->Integer('id_resolutor');
            $table->string('no_expediente',100);
            $table->date('fecha_recepcion');
            $table->Integer('id_giro');
            $table->string('establecimiento', 255);
            $table->Integer('id_procedencia');
            $table->string('no_citatorio',100);
            $table->date('fecha_notificacion_citatorio');
            $table->date('fecha_comparecencia');
            $table->string('no_resolucion',100);
            $table->date('fecha_emision');
            $table->Integer('id_sancion');
            $table->date('fecha_notificacion_resolucion');
            $table->Integer('id_estatus');
            $table->Integer('id_recurso_inconformidad');
            $table->date('fecha_envio_juridico');
            $table->text('observaciones');
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
        Schema::drop('registro_resolucion');
    }
}
