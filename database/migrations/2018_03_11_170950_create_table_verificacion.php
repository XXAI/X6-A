<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVerificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verificacion', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('usuario_id');
            $table->unsignedInteger('id_jurisdiccion');
            $table->unsignedInteger('id_tema');
            $table->string('anio', 4);
            $table->string('mes',2);
            $table->string('folio');
            $table->string('folio_completo');
            $table->string('establecimiento');
            $table->string('giro');
            $table->tinyInteger('medida_seguridad');
            $table->text('descripcion_medida');
            $table->tinyInteger('informativa');
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
        Schema::drop('verificacion');
    }
}
