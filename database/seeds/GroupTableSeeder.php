<?php

use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('fuel_groups')->truncate();
        $fuel_groups =[
            ['id' => 1, 'name' => 'Administrator', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 2, 'name' => 'Farm and Dairy Employee', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 3, 'name' => 'Does Not Fuel', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 4, 'name' => 'Milk Trucks', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ];
        DB::table('fuel_groups')->insert($fuel_groups);

        DB::table('login_accounts')->truncate();
        $login_accounts =[
            ['id' => 1, 'name' => 'Admin', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 2, 'name' => 'Manager', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 3, 'name' => 'Reports Only', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ];
        DB::table('login_accounts')->insert($login_accounts);
    }
}
