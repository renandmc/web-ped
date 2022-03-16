<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = $this->faker->company();
        return [
            'name' => $company,
            'corporate_name' => $company,
            'cnpj' => $this->faker->unique()->cnpj(false),
            'owner_id' => User::first()->id,
        ];
    }
}
