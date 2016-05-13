<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variables', function (Blueprint $table) {
            $table->increments('id');
            $table->double('sal_diario');
            $table->float('alimentacion');
            $table->float('vacaciones');
            $table->float('inss_campo');
            $table->float('inss_admin');
            $table->float('cuje_peq');
            $table->float('cuje_grand');
            $table->float('hora_ext');
            $table->float('septimo');
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
        Schema::drop('variables');
    }
}
