<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CujeSafaSeparados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('preplanillas', function (Blueprint $table) {
          $table->double('tot_cuje_peq');
          $table->double('tot_cuje_gran');
          $table->double('tot_safa_peq');
          $table->double('tot_safa_gran');
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
