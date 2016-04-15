<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreplanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preplanillas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_trabajador')->unsigned();
            $table->foreign('id_trabajador')->references('id')->on('trabajadores');



            $table->integer('id_finca')->unsigned();
            $table->foreign('id_finca')->references('id')->on('fincas');

            $table->integer('id_actividad')->unsigned();
            $table->foreign('id_actividad')->references('id')->on('actividades');

            $table->integer('id_labor')->unsigned();
            $table->foreign('id_labor')->references('id')->on('labores');

            $table->date('fecha');

            $table->integer('id_listero')->unsigned();
            
            $table->integer('id_respFinca')->unsigned();
            
            $table->foreign('id_respFinca')->references('id')->on('trabajadores');
            $table->foreign('id_listero')->references('id')->on('trabajadores');

            $table->integer('cantidad');
            $table->integer('hora_ext');
            $table->integer('actividad_ext');


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
        Schema::drop('preplanillas');
    }
}
