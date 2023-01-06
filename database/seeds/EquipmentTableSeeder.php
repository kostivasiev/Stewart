<?php

use Illuminate\Database\Seeder;

class EquipmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('equipment')->truncate();//removes all current data
        $equipment =[
        	['id' => 1, 'name' => '4850 #1', 'unit_number' => '1234', 'meter_type' => '1', 'max_meter' => '300', 'company_id' => '2', 'equipment_groups_id' => '1', 'year_id' => 1],
        	['id' => 2, 'name' => '8420 #8', 'unit_number' => '8234', 'meter_type' => '1', 'max_meter' => '300', 'company_id' => '1', 'equipment_groups_id' => '2', 'year_id' => 2],
        	['id' => 3, 'name' => 'Swather #2', 'unit_number' => '4234', 'meter_type' => '1', 'max_meter' => '300', 'company_id' => '2', 'equipment_groups_id' => '2', 'year_id' => 3]
        ];
        DB::table('equipment')->insert($equipment);
    }
}
