<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word()),
            'measure_unit' => $this->faker->randomNumber(3, false) . ' ' . $this->faker->randomElement(['kg', 'un', 'l', 'ml', 'g', 'mg']),
            'price' => $this->faker->randomFloat(2, 0, 999),
            'active' => $this->faker->boolean(),
            'description' => $this->faker->text(),
        ];
    }
}
