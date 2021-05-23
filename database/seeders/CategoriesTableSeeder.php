<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        
        \DB::table('categories')->truncate();

        for ($i = 1; $i < 7; $i++) {
            \DB::table('categories')->insert([
                'name' => $faker->city,
                'priority' => ($i),
                'description' => $faker->text,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
