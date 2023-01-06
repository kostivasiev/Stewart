<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('roles')->truncate();//removes all current data
      $role =[
        ['id' => 1, 'name' => 'Super Admin', 'description' => 'All Access'],
        ['id' => 2, 'name' => 'Admin', 'description' => 'Company Access'],
        ['id' => 3, 'name' => 'Mechanic', 'description' => 'WO access']
      ];
      DB::table('roles')->insert($role);

      DB::table('role_user')->truncate();//removes all current data
      $role_user =[
        ['id' => 1, 'role_id' => 1, 'user_id' => 2],
        ['id' => 2, 'role_id' => 2, 'user_id' => 1],
        ['id' => 3, 'role_id' => 3, 'user_id' => 3]
      ];
      DB::table('role_user')->insert($role_user);

    }
}
