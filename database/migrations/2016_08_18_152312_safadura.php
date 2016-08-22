<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Safadura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preplanillas', function (Blueprint $table) {
          $table->integer('safa_ext');
          $table->double('cant_safa');
          $table->boolean('tamano_safa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('preplanillas', function (Blueprint $table) {
            //
        });
    }
}
