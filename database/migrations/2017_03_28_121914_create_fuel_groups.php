<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('equipment_fuel_group', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fuel_group_id')->unsigned()->default(0);
          $table->foreign('fuel_group_id')->references('id')->on('fuel_groups')->onDelete('cascade');
          $table->integer('equipment_id')->unsigned()->default(0);
          $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
          $table->timestamps();
      });

      Schema::create('fuel_group_fuel_pump', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fuel_group_id')->unsigned()->default(0);
          $table->foreign('fuel_group_id')->references('id')->on('fuel_groups')->onDelete('cascade');
          $table->integer('fuel_pump_id')->unsigned()->default(0);
          $table->foreign('fuel_pump_id')->references('id')->on('fuel_pumps')->onDelete('cascade');
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('fuel_group_fuel_pump');
      Schema::dropIfExists('equipment_fuel_group');
    }
}
