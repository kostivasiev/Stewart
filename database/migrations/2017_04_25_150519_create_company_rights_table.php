<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('rights', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->string('description');
          $table->timestamps();
      });

      Schema::create('company_right', function (Blueprint $table) {
          $table->increments('id');
          $table->timestamps();
          $table->integer('right_id')->unsigned()->default(0);
          $table->foreign('right_id')->references('id')->on('rights')->onDelete('cascade');
          $table->integer('company_id')->unsigned()->default(0);
          $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_right');
        Schema::dropIfExists('rights');
    }
}
