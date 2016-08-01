<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DatosUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('trabajadores', function ($table) {
        $table->string('tipo',10);
        $table->boolean('estado');
        $table->string('cargo',20);
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
          $table->dropColumn('tipo');
          $table->dropColumn('estado');
          $table->dropColumn('cargo');
      });
    }
}
