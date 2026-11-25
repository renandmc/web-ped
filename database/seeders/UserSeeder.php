<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * The admin credentials come from the environment so no real
     * password lives in the repository. See SEED_USER_* in .env.example.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => env('SEED_USER_NAME', 'Admin'),
            'email' => env('SEED_USER_EMAIL', 'admin@example.com'),
            'password' => Hash::make(env('SEED_USER_PASSWORD', 'password')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
