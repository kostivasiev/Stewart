<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VariableVariables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('variables', function ($table) {
          $table->increments('id');
          $table->integer('company_id');
          $table->string('name');//VIN
          $table->string('type');//Text
        });

      Schema::create('variable_values', function ($table) {
          $table->increments('id');
          $table->integer('variable_id')->unsigned()->default(0);
          $table->foreign('variable_id')->references('id')->on('variables')->onDelete('cascade');
          $table->string('name');
        });

      Schema::create('equipment_variable_values', function ($table) {
          $table->increments('id');
          $table->integer('variable_value_id')->unsigned()->default(0);
          $table->foreign('variable_value_id')->references('id')->on('variable_values')->onDelete('cascade');
          $table->integer('equipment_id')->unsigned()->default(0);
          $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_variable_values');
        Schema::dropIfExists('variable_values');
        Schema::dropIfExists('variables');
    }
}
