<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablaProgramacionTemaJurisdiccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacion_jurisdiccion', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('id_jurisdiccion');
            $table->string('id_tema');
            $table->string('id_tipo_programacion');
            $table->string('anio', 4);
            $table->integer('enero');
            $table->integer('febrero');
            $table->integer('marzo');
            $table->integer('abril');
            $table->integer('mayo');
            $table->integer('junio');
            $table->integer('julio');
            $table->integer('agosto');
            $table->integer('septiembre');
            $table->integer('octubre');
            $table->integer('noviembre');
            $table->integer('diciembre');
            $table->integer('total');
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
        Schema::drop('programacion_jurisdiccion');
    }
}
