<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('workorders', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('equipment_id')->unsigned()->default(0);
          $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
          $table->timestamps();
      });

      Schema::create('workorder_logs', function (Blueprint $table) {
          $table->increments('id');
          $table->string('notes')->default('');
          $table->integer('status');
          $table->integer('workorder_id')->unsigned()->default(0);
          $table->foreign('workorder_id')->references('id')->on('workorders')->onDelete('cascade');
          $table->integer('user_id')->unsigned()->default(0);
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->timestamps();
      });

      Schema::create('user_workorder', function (Blueprint $table) {
          $table->increments('id');
          $table->float('labor');
          $table->integer('workorder_id')->unsigned()->default(0);
          $table->foreign('workorder_id')->references('id')->on('workorders')->onDelete('cascade');
          $table->integer('user_id')->unsigned()->default(0);
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          $table->timestamps();
      });

      Schema::create('interval_workorder', function (Blueprint $table) {
          $table->increments('id');
          $table->float('labor');
          $table->integer('workorder_id')->unsigned()->default(0);
          $table->foreign('workorder_id')->references('id')->on('workorders')->onDelete('cascade');
          $table->integer('interval_id')->unsigned()->default(0);
          $table->foreign('interval_id')->references('id')->on('intervals')->onDelete('cascade');
          $table->timestamps();
      });

      Schema::create('tags', function (Blueprint $table) {
          $table->increments('id');
          $table->string('name');
          $table->timestamps();
      });

      Schema::create('tag_workorder', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('workorder_id')->unsigned()->default(0);
          $table->foreign('workorder_id')->references('id')->on('workorders')->onDelete('cascade');
          $table->integer('tag_id')->unsigned()->default(0);
          $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
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
        Schema::dropIfExists('tag_workorder');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('interval_workorder');
        Schema::dropIfExists('user_workorder');
        Schema::dropIfExists('workorder_logs');
        Schema::dropIfExists('workorders');

    }
}
