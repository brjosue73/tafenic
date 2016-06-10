<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuincenalsTable extends Migration
{
    public function up()
    {
        Schema::create('quincenales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo',20);
            $table->integer('dias_trab');
            $table->integer('id_finc')->unsigned();
            $table->integer('id_trabajador')->unsigned();
            $table->double('horas_extra');
            $table->double('otros');
            $table->double('feriados');
            $table->double('subsidios');
            $table->double('prestamos');
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->double('dias_vacs');
            $table->timestamps();
            $table->foreign('id_trabajador')->references('id')->on('trabajadores')->onDelete('cascade');
            $table->foreign('id_finc')->references('id')->on('fincas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('quincenales');
    }
}
