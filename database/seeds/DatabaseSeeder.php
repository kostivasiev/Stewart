<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('CompanyUserSeeder');
        $this->call('GroupTableSeeder');
        $this->call('EquipmentTableSeeder');
        $this->call('EquipmentGroupSeeder');
        $this->call('PartsSeeder');
        $this->call('IntervalSeeder');
        $this->call('MakeModelYearSeeder');
        $this->call('RoleTableSeeder');
        $this->call('FuelSeeder');
    }
}
