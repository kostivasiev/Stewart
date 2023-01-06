<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WorkorderStatusAndCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('workorders', function ($table) {

          $table->integer('status')->unsigned()->default(0);
          $table->integer('company_id')->unsigned()->default(0);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('workorders', function ($table) {
          $table->dropColumn('status');
          $table->dropColumn('company_id');
      });
    }
}
