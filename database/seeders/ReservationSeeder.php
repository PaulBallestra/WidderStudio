<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
//use Faker\Factory;

class ReservationSeeder extends Seeder
{

    public function run()
    {
        $faker = \Faker\Factory::create();

        $tabCrenaux = ['9-10h', '10-11h', '11-12h', '12-13h', '13-14h', '14-15h', '15-16h', '16-17h', '17-18h']; //pas réussi avec le config (chiant)

        //Pour remplir la db avec des valeurs fakes
        for($i = 0; $i < 10; $i++){
            DB::table('reservations')->insert([
                'email' => $faker->email,
                'selectedDate' => $faker->dateTimeBetween('now', '+30 days'),
                'token' => md5(uniqid(true)),
                'creneau1' => $tabCrenaux[rand(0, count($tabCrenaux)-1)],
                'creneau2' => '',
            ]);
        }


    }
}
