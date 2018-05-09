<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProgramacionJurisdiccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programacion_jurisdiccion', function($table) {
            $table->string('usuario_id')->after('id_tipo_programacion');
            $table->string('autorizado_por')->after('total');
            $table->timestamp('autorizado_al')->after('total');
            $table->boolean('validado')->default(0)->after('total');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programacion_jurisdiccion', function($table) {
            $table->dropColumn('usuario_id');
            $table->dropColumn('autorizado_por');
            $table->dropColumn('autorizado_al');
            $table->dropColumn('validado');
        });
    }
}
