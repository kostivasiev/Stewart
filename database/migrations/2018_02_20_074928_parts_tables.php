<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PartsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('equipment_type_parts', function ($table) {
          $table->increments('id');
          $table->integer('part_id')->unsigned()->default(0);
          $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
          $table->integer('equipment_type_id')->unsigned()->default(0);
          $table->foreign('equipment_type_id')->references('id')->on('equipment_types')->onDelete('cascade');
        });
      Schema::create('part_makes', function ($table) {
          $table->increments('id');
          $table->integer('part_id')->unsigned()->default(0);
          $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
          $table->integer('make_id')->unsigned()->default(0);
          $table->foreign('make_id')->references('id')->on('makes')->onDelete('cascade');
        });

      Schema::create('emodel_parts', function ($table) {
          $table->increments('id');
          $table->integer('part_id')->unsigned()->default(0);
          $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
          $table->integer('emodel_id')->unsigned()->default(0);
          $table->foreign('emodel_id')->references('id')->on('emodels')->onDelete('cascade');
        });

      Schema::create('part_years', function ($table) {
          $table->increments('id');
          $table->integer('part_id')->unsigned()->default(0);
          $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
          $table->integer('year_id')->unsigned()->default(0);
          $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
        });

      Schema::create('equipment_parts', function ($table) {
          $table->increments('id');
          $table->integer('part_id')->unsigned()->default(0);
          $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
          $table->integer('equipment_id')->unsigned()->default(0);
          $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
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
      Schema::dropIfExists('equipment_parts');
      Schema::dropIfExists('part_years');
      Schema::dropIfExists('emodel_parts');
      Schema::dropIfExists('part_makes');
      Schema::dropIfExists('equipment_type_parts');
    }
}
