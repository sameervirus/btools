<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $user = \App\Models\User::create([
            'name' => 'Samir Nabil',
            'email' => 'samir.nabil@arconsegypt.com',
            'username' => 'sameervirus',
            'password' => Hash::make('4928600')
        ]);
        $user->assignRole('admin');
    }
}
