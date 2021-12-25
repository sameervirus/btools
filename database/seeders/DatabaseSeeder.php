<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsSeeder::class,
            UserSeeder::class,
            CodingSeeder::class,
            ItemSeeder::class,
            InitSeeder::class
        ]);
        
    }
}