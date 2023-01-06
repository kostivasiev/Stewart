<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EquipmentTypeAssignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('equipment', function ($table) {

          $table->integer('equipment_type_id')->unsigned()->default(1);
          $table->integer('make_id')->unsigned()->default(1);
          $table->integer('emodel_id')->unsigned()->default(1);
      });
    }

    /**
     * Reverse the migrations.s
     *
     * @return void
     */
    public function down()
    {
      Schema::table('equipment', function ($table) {
          $table->dropColumn('equipment_type_id');
          $table->dropColumn('make_id');
          $table->dropColumn('emodel_id');
      });
    }
}
