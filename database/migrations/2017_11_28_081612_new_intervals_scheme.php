<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Interval;
use App\EquipmentInterval;

class NewIntervalsScheme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('equipment_type_intervals', function ($table) {
          $table->increments('id');
          $table->integer('interval_id')->unsigned()->default(0);
          $table->foreign('interval_id')->references('id')->on('intervals')->onDelete('cascade');
          $table->integer('equipment_type_id')->unsigned()->default(0);
          $table->foreign('equipment_type_id')->references('id')->on('equipment_types')->onDelete('cascade');
        });
      Schema::create('interval_makes', function ($table) {
          $table->increments('id');
          $table->integer('interval_id')->unsigned()->default(0);
          $table->foreign('interval_id')->references('id')->on('intervals')->onDelete('cascade');
          $table->integer('make_id')->unsigned()->default(0);
          $table->foreign('make_id')->references('id')->on('makes')->onDelete('cascade');
        });

      Schema::create('emodel_intervals', function ($table) {
          $table->increments('id');
          $table->integer('interval_id')->unsigned()->default(0);
          $table->foreign('interval_id')->references('id')->on('intervals')->onDelete('cascade');
          $table->integer('emodel_id')->unsigned()->default(0);
          $table->foreign('emodel_id')->references('id')->on('emodels')->onDelete('cascade');
        });

      Schema::create('interval_years', function ($table) {
          $table->increments('id');
          $table->integer('interval_id')->unsigned()->default(0);
          $table->foreign('interval_id')->references('id')->on('intervals')->onDelete('cascade');
          $table->integer('year_id')->unsigned()->default(0);
          $table->foreign('year_id')->references('id')->on('years')->onDelete('cascade');
        });

      Schema::create('equipment_intervals', function ($table) {
          $table->increments('id');
          $table->integer('interval_id')->unsigned()->default(0);
          $table->foreign('interval_id')->references('id')->on('intervals')->onDelete('cascade');
          $table->integer('equipment_id')->unsigned()->default(0);
          $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
          $table->integer('meter_due')->default(0);
          $table->timestamp('date_due')->default(0);
          $table->integer('status')->default(1);
          $table->timestamps();
        });

      $oldData  = Interval::get();
      foreach ($oldData as $data){
        $newData = new EquipmentInterval();
        $newData->interval_id = $data->id;
        $newData->equipment_id = $data->equipment_id;
        if($data->meter_due){
          $newData->meter_due = $data->meter_due;
        }
        if($data->date_due){
          $newData->date_due = $data->date_due;
        }
        $newData->status = 0;
        $newData->save();
      }
      Schema::table('intervals', function ($table) {
        $table->integer('status')->default(1);
        $table->integer('company_id')->unsigned()->default(4);
        $table->foreign('company_id')->references('id')->on('companies');
        $table->dropColumn('meter_due');
        $table->dropColumn('date_due');
        $table->dropColumn('default_interval_id');
          // // $table->dropColumn('equipment_id');
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_intervals');
        Schema::dropIfExists('interval_years');
        Schema::dropIfExists('emodel_intervals');
        Schema::dropIfExists('interval_makes');
        Schema::dropIfExists('equipment_type_intervals');
    }
}

// ALTER TABLE `holtT3`.`intervals`
// DROP FOREIGN KEY `intervals_equipment_id_foreign`;
// ALTER TABLE `holtT3`.`intervals`
// DROP COLUMN `equipment_id`,
// DROP INDEX `intervals_equipment_id_foreign` ;
