<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatosFaltantesPrep extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('preplanillas', function ($table) {
        $table->float('cant_cujes');
        $table->float('actividad_ext')->change();
        $table->renameColumn('actividad_ext','cuje_ext');
        $table->float('hora_ext')->change();
        $table->float('cantidad')->change();
        $table->renameColumn('cantidad','hora_trab');
        //camb hora_ext a float
        //cant a doble y a hora_trab
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
