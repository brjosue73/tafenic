<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatosQuincenales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quincenales', function (Blueprint $table) {
            $table->string('dias_falt');
            $table->double('inss_laboral');
            $table->double('ir');
            $table->double('total_pagar');
            $table->double('tot_h_ext');
            $table->double('basico');
            $table->double('devengado');
            $table->integer('feriado_trab');
            $table->integer('feriado_ntrab');
            $table->double('salario_quinc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quincenales', function (Blueprint $table) {
            //
        });
    }
}
