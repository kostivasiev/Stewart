<?php

use Illuminate\Database\Seeder;

class MakeModelYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equipment_types')->truncate();//removes all current data
        $equipment_types =[
        	['id' => 1,
        	'name' => 'SUV'
        	],
        	['id' => 2,
        	'name' => 'Sedan'
        	]
        ];
        DB::table('equipment_types')->insert($equipment_types);

        DB::table('makes')->truncate();//removes all current data
        $makes =[
        	['id' => 1,
        	'name' => 'Kia',
        	'equipment_type_id' => 1
        	],
        	['id' => 2,
        	'name' => 'Nissan',
        	'equipment_type_id' => 2
        	]
        ];
        DB::table('makes')->insert($makes);

        DB::table('emodels')->truncate();//removes all current data
        $emodels =[
        	['id' => 1,
        	'name' => 'Sorento',
        	'make_id' => 1
        	],
        	['id' => 2,
        	'name' => 'Altima',
        	'make_id' => 2
        	]
        ];
        DB::table('emodels')->insert($emodels);

        DB::table('years')->truncate();//removes all current data
        $years =[
        	['id' => 1,
        	'year' => 2012,
        	'emodel_id' => 1
        	],
        	['id' => 2,
        	'year' => 2010,
        	'emodel_id' => 2
        	],
        	['id' => 3,
        	'year' => 2011,
        	'emodel_id' => 2
        	]
        ];
        DB::table('years')->insert($years);

        DB::table('trims')->truncate();//removes all current data
        $trims =[
        	['id' => 1,
        	'name' => 'XL',
        	'description' => '4 wheel drive'
        	]
        ];
        DB::table('trims')->insert($trims);

        DB::table('part_year')->truncate();//removes all current data
        $part_year =[
        	['id' => 1,
        	'part_id' => 1,
        	'year_id' => 1
        	]
        ];
        DB::table('part_year')->insert($part_year);
    }
}
