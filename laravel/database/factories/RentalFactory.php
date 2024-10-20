<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


//  @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>

class RentalFactory extends Factory
{
    public function definition(): array
    {
        return [
            'rental_date' => fake()->dateTimeBetween('-1 month', '-2 week'),
            'user_id' => User::inRandomOrder()->first() ?? User::factory()->create(),
            'return_date' => fake()->optional()->dateTimeBetween('-2 week', 'now'),
        ];
    }
}
