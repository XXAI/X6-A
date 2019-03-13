<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDenunciaSeguimiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncia_seguimiento', function (Blueprint $table) {
            
            $table->increments('id');
            $table->Integer('denuncia_id');
            $table->text('seguimiento');
            $table->Integer('usuario_id');
            $table->Integer('idEstatus')->default(1);;

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
        Schema::drop('denuncia');
    }
}
