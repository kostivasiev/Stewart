<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToEquipmentUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('equipment_user', function ($table) {
          $table->integer('daily')->unsigned()->default(0);
          $table->integer('weekly')->unsigned()->default(0);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('equipment_user', function ($table) {
          $table->dropColumn('daily');
          $table->dropColumn('weekly');
      });
    }
}
