<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposAPreplanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('preplanillas', function ($table){
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
          $table->dropColumn('salario_dev');
          $table->dropColumn('alimentacion');
          $table->dropColumn('vacaciones');
          $table->dropColumn('aguinaldo');
          $table->dropColumn('salario_acum');
      });
    }
}
