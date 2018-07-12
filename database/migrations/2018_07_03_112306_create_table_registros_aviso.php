<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRegistrosAviso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_aviso', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('no',100);
            $table->Integer('id_giro');
            $table->string('establecimiento', 255);
            $table->date('fecha_alta');
            $table->text('modificacion_datos');
            $table->date('fecha_baja');
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
        Schema::drop('registro_aviso');
    }
}
