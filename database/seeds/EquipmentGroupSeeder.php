<?php

use Illuminate\Database\Seeder;

class EquipmentGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('equipment_groups')->truncate();

        $equipment_groups =[
        	['id' => 1, 'name' => 'Tractors', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        	['id' => 2, 'name' => 'Swathers', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        	['id' => 3, 'name' => 'Computers', 'created_at' => new DateTime, 'updated_at' => new DateTime], 
        ];
        DB::table('equipment_groups')->insert($equipment_groups);
    }
}
