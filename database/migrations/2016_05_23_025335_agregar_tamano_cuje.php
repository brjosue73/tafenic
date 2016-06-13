<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarTamanoCuje extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('preplanillas', function ($table) {
        $table->boolean('tamano_cuje');
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
          $table->dropColumn('tamano_cuje');
      });
    }
}
