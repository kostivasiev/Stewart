<?php

use Illuminate\Database\Seeder;

class CompanyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS=0');
      DB::table('companies')->truncate();
      $company = [];
      for($i = 1; $i <= 3; $i++){
          $company[] = [
              'name' => "Holt Farms, LLC",
              'email' => "user{$i}@mail.com",
              'address' => "User {$i}",
              'description' => "User {$i}"
          ];
      }
      DB::table('companies')->insert($company);

        DB::table('users')->truncate();
        $users = [];
        for($i = 1; $i <= 3; $i++){
          $off_set = $i-1;
            $users[] = [
                'first_name' => "First_{$i}",
                'last_name' => "Last_{$i}",
                'email' => "gregstewart9{$off_set}@gmail.com",
                'company_id' => 1,
                'cell_number' => "7{$i}65701630",
                'cell_provider' => 1,
                'fuel_group_id' => 1,
                'send_text_at_fueling' => 1,
                'send_email_at_fueling' => 0,
                'PIN' => "100{$i}",
                'password' => bcrypt("user{$i}")
            ];
        }
        DB::table('users')->insert($users);


    }
}
