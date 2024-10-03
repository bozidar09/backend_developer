<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'text' => fake()->sentences(mt_rand(1, 3), true),
            'article_id' => Article::inRandomOrder()->first() ?? Article::factory()->create(),
            'user_id' => User::inRandomOrder()->first() ?? User::factory()->create(),
        ];
    }
}
