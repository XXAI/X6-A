<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDenuncia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denuncia', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('codigo',100);
            $table->Integer('anonimo');
            $table->string('nombre',100);
            $table->string('apellido_paterno',100);
            $table->string('apellido_materno',100);
            $table->Integer('sexo');
            $table->Integer('edad');
            $table->string('correo',255);
            $table->string('lada',5);
            $table->string('telefono', 50);
            $table->string('ext',50);
            $table->string('cp_persona',10);
            $table->Integer('estado_persona');
            $table->Integer('municipio_persona');
            $table->Integer('localidad_persona');
            $table->string('colonia_persona',255);
            $table->string('calle_persona',255);
            $table->string('ext_persona',255);
            $table->string('int_persona',255);
            $table->Integer('tipo_denuncia');
            $table->string('razon_social',255);
            $table->string('giro',255);
            $table->string('producto',255);
            
            $table->Integer('estado_denuncia');
            $table->Integer('municipio_denuncia');
            $table->string('colonia_denuncia',255);
            $table->string('calle_denuncia',255);
            $table->string('ext_denuncia',255);
            $table->string('cp_denuncia',255);
            $table->text('narracion');
            $table->Integer('idEstatus')->default(1);
            
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
