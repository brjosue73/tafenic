<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarLotesAPreplanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preplanillas', function ($table){
            $table->integer('id_lote')->unsigned();
            $table->foreign('id_lote')->references('id')->on('lotes')->onDelete('cascade');
            $table->float('salario_dev');
            $table->float('alimentacion');
            $table->float('vacaciones');
            $table->float('aguinaldo');
            $table->float('salario_acum');
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preplanillas', function ($table){
            $table->dropColumn('id_lote'); 
            $table->dropColumn('salario_dev');
            $table->dropColumn('alimentacion');
            $table->dropColumn('vacaciones');
            $table->dropColumn('aguinaldo');
            $table->dropColumn('salario_acum');
        });
    }
}
