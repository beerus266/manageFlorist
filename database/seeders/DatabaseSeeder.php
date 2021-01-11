<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            'name' => "admin",
            'email' => 'nhai0626@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        DB::table('users')->insert([
            'name' => "user1",
            'email' => 'hai.nv173088@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
