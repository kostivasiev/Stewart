<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('manufacture_part_number');
            $table->string('description');
            $table->string('link');
            $table->integer('default_part_id')->unsigned()->default(0);
            $table->integer('company_id')->unsigned()->default(0);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('default_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('value');
            $table->string('manufacture_part_number');
            $table->string('description');
            $table->string('link');
            $table->timestamps();
        });

        // Schema::create('inventorys', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');
        //     $table->integer('equipment')->unsigned()->default(0);
        //     $table->float('quantity');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_parts');
        // Schema::dropIfExists('parts_equipments');
        Schema::dropIfExists('parts');
    }
}
