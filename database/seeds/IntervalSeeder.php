<?php

use Illuminate\Database\Seeder;

class IntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('intervals')->truncate();//removes all current data
        DB::table('default_intervals')->truncate();//removes all current data
        $intervals =[
        	['id' => 1,
        	'name' => 'Change Oil',
        	'notes' => 'Size 3 wrench',
        	'meter_interval' => '250',
        	'meter_alert' => '50',
        	'meter_due' => '1000',
        	'date_interval' => '90',
        	'date_alert' => '10',
        	'date_due' => new DateTime, 
        	'default_interval_id' => '1',
        	'equipment_id' => '1'
        	],
        	['id' => 2,
        	'name' => 'Inspect Tires',
        	'notes' => 'Front and Back',
        	'meter_interval' => '550',
        	'meter_alert' => '50',
        	'meter_due' => '1000',
        	'date_interval' => '90',
        	'date_alert' => '10',
        	'date_due' => '50',
        	'default_interval_id' => '2',
        	'equipment_id' => '2'
        	]
        ];
        DB::table('intervals')->insert($intervals);
        $intervals =[
        	['id' => 1,
        	'name' => 'Change Oil',
        	'notes' => 'Size 3 wrench',
        	'meter_interval' => '250',
        	'meter_alert' => '50',
        	'date_interval' => '90',
        	'date_alert' => '10'
        	],
        	['id' => 2,
        	'name' => 'Inspect Tires',
        	'notes' => 'Front and Back',
        	'meter_interval' => '550',
        	'meter_alert' => '50',
        	'date_interval' => '90',
        	'date_alert' => '10'
        	]
        ];
        DB::table('default_intervals')->insert($intervals);

        DB::table('interval_part')->truncate();//removes all current data
        DB::table('default_interval_part')->truncate();//removes all current data
        $intervals =[
        	['id' => 1,
        	'interval_id' => 1,
        	'part_id' => 1
        	],
        	['id' => 2,
        	'interval_id' => 2,
        	'part_id' => 2
        	],
        	['id' => 3,
        	'interval_id' => 1,
        	'part_id' => 2
        	]
        ];
        DB::table('interval_part')->insert($intervals);
        DB::table('default_interval_part')->truncate();//removes all current data
        $intervals =[
        	['id' => 1,
        	'default_interval_id' => 1,
        	'part_id' => 1
        	],
        	['id' => 2,
        	'default_interval_id' => 2,
        	'part_id' => 2
        	],
        	['id' => 3,
        	'default_interval_id' => 1,
        	'part_id' => 2
        	]
        ];
        DB::table('default_interval_part')->insert($intervals);
    }
}
