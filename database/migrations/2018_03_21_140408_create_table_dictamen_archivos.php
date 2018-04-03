<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDictamenArchivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictamen_archivos', function (Blueprint $table) {
            
            $table->increments('id');
            $table->unsignedInteger('id_dictamen');
            $table->unsignedInteger('id_tipo_seguimiento');
            $table->string('usuario_id');
            $table->string('oficio');
            $table->string('archivo');
            
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
        Schema::drop('dictamen_archivos');
    }
}
