<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarInssPatYlabPreplanillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('preplanillas', function (Blueprint $table) {
          $table->double('inss_campo');
          $table->double('inss_admin');
          $table->double('inss_patron');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
