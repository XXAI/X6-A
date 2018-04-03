<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDictamen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dictamen', function (Blueprint $table) {
            
            $table->increments('id');
            $table->unsignedInteger('id_verificacion');
            $table->unsignedInteger('id_jurisdiccion');
            $table->unsignedInteger('id_tema');
            $table->string('usuario_id');
            $table->string('anio', 4);
            $table->string('mes',2);
            $table->string('folio');
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
        Schema::drop('dictamen');
    }
}
