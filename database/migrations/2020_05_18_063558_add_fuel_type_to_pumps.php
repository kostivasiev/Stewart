<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFuelTypeToPumps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fuel_pumps', function (Blueprint $table) {
            $table->integer('fuel_type')->unsigned()->default(0);
        });
        Schema::table('equipment', function (Blueprint $table) {
            $table->integer('fuel_type')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fuel_pumps', function (Blueprint $table) {
            $table->dropColumn('fuel_type');
        });
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('fuel_type');
        });
    }
}
