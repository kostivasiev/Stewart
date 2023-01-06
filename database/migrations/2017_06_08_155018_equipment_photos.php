<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EquipmentPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('equipment_photos', function ($table) {
          $table->increments('id');
          $table->integer('equipment_id')->unsigned()->default(0);
          $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
          $table->string('file_path');
          $table->string('name');
        });
      Schema::create('user_photos', function ($table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned()->default(0);
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->string('file_path');
          $table->string('name');
        });
      Schema::create('workorder_photos', function ($table) {
          $table->increments('id');
          $table->integer('workorder_id')->unsigned()->default(0);
          $table->foreign('workorder_id')->references('id')->on('workorders')->onDelete('cascade');
          $table->string('file_path');
          $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('variables');
      Schema::dropIfExists('user_photos');
      Schema::dropIfExists('workorder_photos');
    }
}
