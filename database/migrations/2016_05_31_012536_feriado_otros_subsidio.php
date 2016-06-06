<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FeriadoOtrosSubsidio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::table('preplanillas', function ($table) {
         $table->double('otros');
         $table->double('feriados');
         $table->double('subsidios');
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
           $table->dropColumn('otros');
           $table->dropColumn('feriados');
           $table->dropColumn('subsidios');
       });
     }
}
