<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        User::factory()
            ->has(Company::factory()->count(2)->has(Product::factory()->count(25)))
            ->create([
                'name' => 'Renan da Mota Ciciliato',
                'email' => 'renanciciliato@gmail.com',
                'password' => Hash::make('@renandmc93'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        User::factory()
            ->has(Company::factory()->count(2)->has(Product::factory()->count(25)))
            ->create([
                'name' => 'Teste',
                'email' => 'teste@email.com',
                'password' => Hash::make('@teste123'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
    }
}
