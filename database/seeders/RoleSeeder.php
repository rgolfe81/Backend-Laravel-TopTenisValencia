<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
               [
                   'name' => "user",
                   'created_at' => "2023-04-14 11:00",
                   'updated_at' => "2023-04-14 11:00"
               ],
               [
                   'name' => "admin",
                   'created_at' => "2023-04-14 11:00",
                   'updated_at' => "2023-04-14 11:00"
               ],
            ]
       );
    }
}
