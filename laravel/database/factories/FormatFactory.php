<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


//  @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Format>

class FormatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => fake()->unique()->word(),
            'coefficient' => fake()->randomFloat(2, 0, 3),
        ];
    }
}
