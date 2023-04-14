<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                [
                    'name' => "Mario",
                    'surname' => "Rico Gil",
                    'email' => "marioricogil@gmail.com",
                    'role_id' => "1",
                    'password' => Hash::make('000000'),
                    'city' => "Vilamarxant",
                    'age' => "41",
                    'phone' => "666111222",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
                [
                    'name' => "Fernando",
                    'surname' => "Ferrer Alonso",
                    'email' => "fernandoferrreralonso@gmail.com",
                    'role_id' => "1",
                    'password' => Hash::make('000000'),
                    'city' => "Benaguasil",
                    'age' => "38",
                    'phone' => "666111333",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
                [
                    'name' => "Armando",
                    'surname' => "Gorriz Alepuz",
                    'email' => "armandogorrizalepuz@gmail.com",
                    'role_id' => "1",
                    'password' => Hash::make('000000'),
                    'city' => "Benisano",
                    'age' => "36",
                    'phone' => "666111555",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
                [
                    'name' => "Miguel",
                    'surname' => "Oliver Silvestre",
                    'email' => "migueloliversilvestre@gmail.com",
                    'role_id' => "1",
                    'password' => Hash::make('000000'),
                    'city' => "Quart de Poblet",
                    'age' => "40",
                    'phone' => "666444333",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
                [
                    'name' => "Vicente",
                    'surname' => "Gil Soriano",
                    'email' => "vicentegilsoriano@gmail.com",
                    'role_id' => "1",
                    'password' => Hash::make('000000'),
                    'city' => "Casinos",
                    'age' => "33",
                    'phone' => "666555888",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
                [
                    'name' => "Maria",
                    'surname' => "Collado Sanchis",
                    'email' => "mariacolladosanchis@gmail.com",
                    'role_id' => "1",
                    'password' => Hash::make('000000'),
                    'city' => "Serra",
                    'age' => "35",
                    'phone' => "666777222",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
                [
                    'name' => "Laura",
                    'surname' => "Gomez Tormos",
                    'email' => "lauragomeztormos@gmail.com",
                    'role_id' => "1",
                    'password' => Hash::make('000000'),
                    'city' => "Naquera",
                    'age' => "31",
                    'phone' => "666000555",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
                [
                    'name' => "Alicia",
                    'surname' => "Folgado Fuster",
                    'email' => "aliciafolgadofuster@gmail.com",
                    'role_id' => "1",
                    'password' => Hash::make('000000'),
                    'city' => "Betera",
                    'age' => "36",
                    'phone' => "666999000",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
                [
                    'name' => "Antonio",
                    'surname' => "Redondo Cabanes",
                    'email' => "antonioredondocabanes@gmail.com",
                    'role_id' => "1",
                    'password' => Hash::make('000000'),
                    'city' => "Ribarroja",
                    'age' => "40",
                    'phone' => "666757303",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
                [
                    'name' => "Ruben",
                    'surname' => "Golfe Silvestre",
                    'email' => "rubengolfesilvestre@gmail.com",
                    'role_id' => "2",
                    'password' => Hash::make('111111'),
                    'city' => "Vilamarxant",
                    'age' => "41",
                    'phone' => "666000000",                   
                    'created_at' => "2023-04-14 16:00",
                    'updated_at' => "2023-04-14 16:00"
                ],
            ]
        );
    }
}
