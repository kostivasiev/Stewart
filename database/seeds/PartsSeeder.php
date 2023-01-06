<?php

use Illuminate\Database\Seeder;

class PartsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {



        DB::table('default_parts')->truncate();//removes all current data
        $equipment =[
        	['id' => 1, 'name' => 'Air Filter-d', 'manufacture_part_number' => 'JD-1234', 'description' => 'John Deere', 'link' => 'http://stackoverflow.com/questions/27747072/vertical-align-in-bootstrap-table'],
        	['id' => 2, 'name' => 'Oil Filter-d', 'manufacture_part_number' => 'NAPA-1244', 'description' => '4" Filter', 'link' => 'http://m2msupport.net/m2msupport/a-guide-to-module-selection/'],
        	['id' => 3, 'name' => 'Water Filter-d', 'manufacture_part_number' => 'M1-A2254', 'description' => '25D Cel', 'link' => 'https://getbootstrap.com/components/#btn-dropdowns']
        ];
        DB::table('default_parts')->insert($equipment);

        DB::table('parts')->truncate();//removes all current data
        $equipment =[
        	['id' => 1, 'name' => 'Air Filter', 'manufacture_part_number' => 'JD-1234', 'description' => 'John Deere', 'link' => 'http://stackoverflow.com/questions/27747072/vertical-align-in-bootstrap-table', 'default_part_id' => '0', 'company_id' => '1'],
        	['id' => 2, 'name' => 'Oil Filter', 'manufacture_part_number' => 'NAPA-1244', 'description' => '4" Filter', 'link' => 'http://m2msupport.net/m2msupport/a-guide-to-module-selection/', 'default_part_id' => '0', 'company_id' => '2'],
        	['id' => 3, 'name' => 'Water Filter', 'manufacture_part_number' => 'M1-A2254', 'description' => '25D Cel', 'link' => 'https://getbootstrap.com/components/#btn-dropdowns', 'default_part_id' => '3', 'company_id' => '1']
        ];
        DB::table('parts')->insert($equipment);
    }
}
