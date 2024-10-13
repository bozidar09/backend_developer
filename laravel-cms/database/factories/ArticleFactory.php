<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = Role::where('name', 'Writer')->first();
        $title = fake()->unique()->catchPhrase();

        return [
            'title' => $title,
            'body' => fake()->paragraphs(mt_rand(5, 10), true),
            'image' => fake()->image(public_path('storage/images/articles'), 800, 600),
            'views' => mt_rand(0, 1000),
            'category_id' => Category::inRandomOrder()->first() ?? Category::factory()->create(),
            'user_id' => User::where('role_id', $role->id)->inRandomOrder()->first() ?? User::factory()->create(['role_id' => $role]),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
