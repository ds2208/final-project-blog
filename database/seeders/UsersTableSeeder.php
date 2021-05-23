<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        \DB::table('users')->truncate();
        
        \DB::table('users')->insert([
            'status' => 1,
            'name' => 'Danilo Strahinovic',
            'email' => 'danilo.strahinovic@gmail.com',
            'password' => \Hash::make('danilo123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('users')->insert([
            'status' => 1,
            'name' => 'Sara Bircanin',
            'phone' => '0649876541',
            'email' => 'sara.bircanin@gmail.com',
            'password' => bcrypt('sara123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        \DB::table('users')->insert([
            'status' => 1,
            'name' => 'Milutin Dinic',
            'phone' => '0611234567',
            'email' => 'milutin.dinic@gmail.com',
            'password' => bcrypt('milutin123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

}
