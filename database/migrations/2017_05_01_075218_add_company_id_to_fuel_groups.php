<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyIdToFuelGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      // Schema::table('fuel_groups', function (Blueprint $table) {
      //   $table->integer('company_id')->unsigned()->default(0);
      //   $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
      // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      // Schema::table('fuel_groups', function (Blueprint $table) {
      //   $table->dropColumn('company_id');
      // });
    }
}
