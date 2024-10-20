<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;


//  @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>

class MovieFactory extends Factory
{
    public function definition(): array
    {      
        return [
        'title' => ucfirst(strtolower(implode(' ', fake()->unique()->words(rand(1, 3))))),
        'year' => fake()->numberBetween(1900, date('Y')),
        'genre_id' => Genre::inRandomOrder()->first() ?? Genre::factory()->create(),
        'price_id' => Price::inRandomOrder()->first() ?? Price::factory()->create(),
        ];
    }
}