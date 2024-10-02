<?php

namespace Database\Factories;

use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $key = array_mt_rand(CategorySeeder::CATEGORIES);

        return [
            'name' => CategorySeeder::CATEGORIES[$key],
            'order' => ++$key,
        ];
    }
}
