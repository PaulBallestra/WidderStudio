<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//use Faker\Factory;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        //Pour remplir la db avec des valeurs fakes
        for($i = 0; $i < 10; $i++){
            DB::table('reservations')->insert([
                'email' => $faker->email,
                'selectedDate' => $faker->dateTimeBetween('now', '+30 days')
            ]);
        }


    }
}
