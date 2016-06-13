<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcumuladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acumulados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_trabajador')->unsigned();
            $table->double('vacaciones');
            $table->double('aguinaldo');
            $table->integer('dias_vacs');
            $table->foreign('id_trabajador')->references('id')->on('trabajadores')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('acumulados');
    }
}
