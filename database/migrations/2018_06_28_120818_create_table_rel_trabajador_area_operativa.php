<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRelTrabajadorAreaOperativa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_trabajador_area_operativa', function (Blueprint $table) {
            
            $table->increments('id');
            $table->Integer('id_catalogo_trabajador');
            $table->Integer('id_catalogo_area_operativa');
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
        Schema::drop('rel_trabajador_area_operativa');
    }
}
