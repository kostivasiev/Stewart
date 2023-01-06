<?php

use Illuminate\Database\Seeder;

class FuelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('fuel_stations')->truncate();//removes all current data
      $entries =[
        ['id' => 1, 'name' => 'County Line', 'company_id' => '1'],
        ['id' => 2, 'name' => 'Beryl', 'company_id' => '1'],
        ['id' => 3, 'name' => 'Modena', 'company_id' => '1'],
        ['id' => 4, 'name' => 'New Castle', 'company_id' => '1'],
        ['id' => 5, 'name' => 'Dairy Shop', 'company_id' => '1'],
        ['id' => 6, 'name' => 'Parlor', 'company_id' => '1'],
        ['id' => 7, 'name' => 'Road Diesel', 'company_id' => '1'],
      ];
      DB::table('fuel_stations')->insert($entries);

      DB::table('fuel_pumps')->truncate();//removes all current data
      $entries =[
        ['id' => 1, 'name' => 'Diesel', 'fuel_station_id' => '1', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120'],
        ['id' => 2, 'name' => 'Diesel', 'fuel_station_id' => '2', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120'],
        ['id' => 3, 'name' => 'Gas', 'fuel_station_id' => '2', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120'],
        ['id' => 4, 'name' => 'Diesel', 'fuel_station_id' => '3', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120'],
        ['id' => 5, 'name' => 'Diesel', 'fuel_station_id' => '4', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120'],
        ['id' => 6, 'name' => 'Gas', 'fuel_station_id' => '5', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120'],
        ['id' => 7, 'name' => 'Diesel', 'fuel_station_id' => '5', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120'],
        ['id' => 8, 'name' => 'Fast-Diesel', 'fuel_station_id' => '5', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120'],
        ['id' => 9, 'name' => 'Diesel', 'fuel_station_id' => '6', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120'],
        ['id' => 10, 'name' => 'Diesel', 'fuel_station_id' => '7', 'calibration_number' => '700', 'pin_required' => '1', 'equipment_id_required' => '1', 'meter_required' => '1', 'equipment_id_type' => '1', 'inactivity_time' => '120']
      ];
      DB::table('fuel_pumps')->insert($entries);

      // DB::table('equipment_fuel_group')->truncate();//removes all current data
      // $entries =[
      //   ['id' => 1, 'fuel_group_id' => '1', 'equipment_id' => '1'],
      //   ['id' => 2, 'fuel_group_id' => '1', 'equipment_id' => '2'],
      //   ['id' => 3, 'fuel_group_id' => '1', 'equipment_id' => '3']
      // ];
      // DB::table('equipment_fuel_group')->insert($entries);

      DB::table('fuel_group_fuel_pump')->truncate();//removes all current data
      $entries =[
        ['id' => 1, 'fuel_group_id' => '1', 'fuel_pump_id' => '1'],
        ['id' => 2, 'fuel_group_id' => '1', 'fuel_pump_id' => '2'],
        ['id' => 3, 'fuel_group_id' => '1', 'fuel_pump_id' => '3'],
        ['id' => 4, 'fuel_group_id' => '1', 'fuel_pump_id' => '4'],
        ['id' => 5, 'fuel_group_id' => '1', 'fuel_pump_id' => '5'],
        ['id' => 6, 'fuel_group_id' => '1', 'fuel_pump_id' => '6'],
        ['id' => 7, 'fuel_group_id' => '1', 'fuel_pump_id' => '7'],
        ['id' => 8, 'fuel_group_id' => '1', 'fuel_pump_id' => '8'],
        ['id' => 9, 'fuel_group_id' => '1', 'fuel_pump_id' => '9'],

        ['id' => 10, 'fuel_group_id' => '2', 'fuel_pump_id' => '1'],
        ['id' => 11, 'fuel_group_id' => '2', 'fuel_pump_id' => '2'],
        ['id' => 12, 'fuel_group_id' => '2', 'fuel_pump_id' => '3'],
        ['id' => 13, 'fuel_group_id' => '2', 'fuel_pump_id' => '4'],
        ['id' => 14, 'fuel_group_id' => '2', 'fuel_pump_id' => '5'],
        ['id' => 15, 'fuel_group_id' => '2', 'fuel_pump_id' => '6'],
        ['id' => 16, 'fuel_group_id' => '2', 'fuel_pump_id' => '7'],
        ['id' => 17, 'fuel_group_id' => '2', 'fuel_pump_id' => '8'],
        ['id' => 18, 'fuel_group_id' => '2', 'fuel_pump_id' => '9'],


        ['id' => 19, 'fuel_group_id' => '1', 'fuel_pump_id' => '10'],
        ['id' => 20, 'fuel_group_id' => '4', 'fuel_pump_id' => '10']
      ];
      DB::table('fuel_group_fuel_pump')->insert($entries);
    }
}
