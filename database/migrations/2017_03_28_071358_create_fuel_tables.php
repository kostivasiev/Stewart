<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('fuel_stations', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('company_id')->unsigned()->default(0);
          $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
          $table->timestamps();
      });

      Schema::create('fuel_pumps', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->integer('fuel_station_id')->unsigned()->default(0);
          $table->foreign('fuel_station_id')->references('id')->on('fuel_stations')->onDelete('cascade');
          $table->integer('calibration_number');
          $table->integer('pin_required');
          $table->integer('equipment_id_required');
          $table->integer('meter_required');
          $table->integer('equipment_id_type');
          $table->integer('inactivity_time');
          $table->timestamps();
      });

      Schema::create('tank_logs', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fuel_pump_id')->unsigned()->default(0);
          $table->foreign('fuel_pump_id')->references('id')->on('fuel_pumps')->onDelete('cascade');
          $table->float('current_gallons');
          $table->timestamps();
      });

      Schema::create('fuel_logs', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('fuel_pump_id')->unsigned()->default(0);
          $table->foreign('fuel_pump_id')->references('id')->on('fuel_pumps')->onDelete('cascade');
          $table->integer('tank_log_id')->default(0);
          $table->integer('user_id')->default(0);
          $table->integer('equipment_id')->default(0);
          $table->integer('meter_log_id')->default(0);
          $table->float('consumed_gallons')->default(0);
          $table->string('message')->default(0);
          $table->integer('type');
          $table->integer('status');
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
      Schema::dropIfExists('fuel_logs');
      Schema::dropIfExists('tank_logs');
      Schema::dropIfExists('fuel_pumps');
      Schema::dropIfExists('fuel_stations');
    }
}
