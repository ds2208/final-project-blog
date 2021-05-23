<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        $faker = \Faker\Factory::create();
        \DB::table('blogs')->truncate();

        $autorsIDs = \DB::table('users')->get()->pluck('id');
        $categoriesIDs = \DB::table('categories')->get()->pluck('id');
        
        for ($i = 0; $i < 50; $i++) {
            \DB::table('blogs')->insert([
                'title' => $faker->name,
                'description' => $faker->text,
                'content' => $faker->paragraph,
                'author_id' => $autorsIDs->random(),
                'category_id' => $categoriesIDs->random(),
                'important' => rand(100, 999) % 2,
                'created_at' => date('Y-m-d H:i:s', rand(strtotime("-6 months"), strtotime('now'))),
                'updated_at' => date('Y-m-d H:i:s', rand(strtotime("-6 months"), strtotime('now')))
            ]);
        }
    }
}
