<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = \Faker\Factory::create();

        \DB::table('ads')->truncate();

        for ($i = 0; $i < 7; $i++) {
            \DB::table('ads')->insert([
                'priority' => $i,
                'title' => $faker->company,
                'button_title' => $faker->companySuffix,
                'url' => $faker->url,
                'index' => random_int(0, 1),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

}
