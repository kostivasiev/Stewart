<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVinSerialField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('equipment', function ($table) {
          $table->string('vin');
          $table->string('plate_number');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('equipment', function ($table) {
          $table->dropColumn('plate_number');
          $table->dropColumn('vin');
      });
    }
}
