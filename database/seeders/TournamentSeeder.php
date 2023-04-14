<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TournamentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tournaments')->insert(
            [
                [
                    'name' => "Open WinterChallenge 2022",
                    'start_date' => "2022-12-01",
                    'end_date' => "2023-02-28",                   
                    'created_at' => "2022-11-01 12:00",
                    'updated_at' => "2022-11-01 12:00"
                ],
                [
                    'name' => "Open SpringChallenge 2023",
                    'start_date' => "2023-03-01",
                    'end_date' => "2023-05-30",                   
                    'created_at' => "2023-02-01 12:00",
                    'updated_at' => "2023-02-01 12:00"
                ],
                [
                    'name' => "Open SummerChallenge 2023",
                    'start_date' => "2023-06-01",
                    'end_date' => "2023-08-30",                   
                    'created_at' => "2023-04-01 12:00",
                    'updated_at' => "2023-04-01 12:00"
                ],
            ]
        );
    }
}
