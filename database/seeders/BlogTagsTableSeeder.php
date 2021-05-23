<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogTagsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \DB::table('blog_tags')->truncate();

        $tagIds = \DB::table('tags')->get()->pluck('id');

        $blogIds = \DB::table('blogs')->get()->pluck('id');

        foreach ($blogIds as $blogId) {
            foreach ($tagIds->random(3) as $tagId) {
                \DB::table('blog_tags')->insert([
                    'blog_id' => $blogId,
                    'tag_id' => $tagId,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }

}
