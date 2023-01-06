<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntervalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_intervals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('notes');
            $table->integer('meter_interval');
            $table->integer('meter_alert');
            $table->integer('date_interval');
            $table->integer('date_alert');
            $table->integer('year_id');
            $table->timestamps();
        });

        Schema::create('default_interval_part', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('default_interval_id')->unsigned()->default(0);
            $table->foreign('default_interval_id')->references('id')->on('default_intervals')->onDelete('cascade');
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
        Schema::dropIfExists('default_interval_part');
        Schema::dropIfExists('default_intervals');
    }
}
