<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegistrosNotificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_notificacion', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('no',100);
            $table->string('no_acta',100);
            $table->date('fecha_oficio_notificar');
            $table->Integer('id_area_operativa');
            $table->Integer('id_tipo_notificacion');
            $table->Integer('id_procedimiento_notificacion');
            $table->string('establecimiento', 255);
            
            $table->date('fecha_notificacion');
            $table->Integer('id_notificador');
            $table->date('fecha_entrega_responsable');
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
        Schema::drop('registro_notificacion');
    }
}
