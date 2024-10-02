<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


//  @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>

class PriceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => fake()->unique()->word(),
            'price' => fake()->randomFloat(2, 10, 20),
            'late_fee' => fake()->randomFloat(2, 1, 5),
        ];
    }
}
