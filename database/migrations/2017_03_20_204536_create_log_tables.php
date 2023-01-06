<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('meter_logs', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('current');
          $table->integer('equipment_id')->unsigned()->default(0);
          $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
          $table->integer('user_id');
          $table->timestamps();
      });

      Schema::create('interval_logs', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('meter_id')->unsigned()->default(0);
          $table->foreign('meter_id')->references('id')->on('meter_logs')->onDelete('cascade');
          $table->integer('interval_id')->unsigned()->default(0);
          $table->foreign('interval_id')->references('id')->on('intervals')->onDelete('cascade');
          $table->integer('user_id')->unsigned()->default(0);
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->integer('workorder_id')->unsigned()->default(0);
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
      Schema::dropIfExists('interval_logs');
      Schema::dropIfExists('meter_logs');
    }
}
