<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMakeModelYearTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('company_id')->unsigned()->default(0);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('default_equipment_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('makes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('equipment_type_id')->unsigned()->default(0);
            $table->foreign('equipment_type_id')->references('id')->on('equipment_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('emodels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('make_id')->unsigned()->default(0);
            $table->foreign('make_id')->references('id')->on('makes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('years', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year');
            $table->integer('emodel_id')->unsigned()->default(0);
            $table->foreign('emodel_id')->references('id')->on('emodels')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('trims', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('trim_year', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year_id')->unsigned()->default(0);
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
            $table->integer('trim_id')->unsigned()->default(0);
            $table->foreign('trim_id')->references('id')->on('trims')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('part_year', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('part_id')->unsigned()->default(0);
            $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
            $table->integer('year_id')->unsigned()->default(0);
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
            $table->float('quantity');
            $table->string('units');
            $table->timestamps();
        });

        Schema::create('default_part_year', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('default_part_id')->unsigned()->default(0);
            $table->foreign('default_part_id')->references('id')->on('default_parts')->onDelete('cascade');
            $table->integer('year_id')->unsigned()->default(0);
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
            $table->float('quantity');
            $table->string('units');
            $table->timestamps();
        });

        Schema::create('default_interval_year', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('default_interval_id')->unsigned()->default(0);
            $table->foreign('default_interval_id')->references('id')->on('default_intervals')->onDelete('cascade');
            $table->integer('year_id')->unsigned()->default(0);
            $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('intervals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('notes');
            $table->integer('meter_interval');
            $table->integer('meter_alert');
            $table->integer('meter_due');
            $table->integer('date_interval');
            $table->integer('date_alert');
            $table->timestamp('date_due');
            $table->integer('default_interval_id');
            $table->integer('equipment_id')->unsigned()->default(0);
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('interval_part', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interval_id')->unsigned()->default(0);
            $table->foreign('interval_id')->references('id')->on('intervals')->onDelete('cascade');
            $table->integer('part_id')->unsigned()->default(0);
            $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
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

      Schema::dropIfExists('interval_part');
      Schema::dropIfExists('intervals');
        Schema::dropIfExists('default_interval_year');
        Schema::dropIfExists('default_part_year');
        Schema::dropIfExists('part_year');
        Schema::dropIfExists('trim_year');
        Schema::dropIfExists('years');
        Schema::dropIfExists('trims');
        Schema::dropIfExists('emodels');
        Schema::dropIfExists('makes');
        Schema::dropIfExists('equipment_types');
        Schema::dropIfExists('default_equipment_types');
    }
}
