<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
            'slug' => Str::slug($title),
            'image' => fake()->imageUrl(),
            'body' => fake()->text(mt_rand(500, 1000)),
            'category_id' => Category::inRandomOrder()->first() ?? Category::factory()->create(),
            'user_id' => User::where('role_id', $role)->inRandomOrder()->first() ?? User::factory()->create(['role_id' => $role]),
        ];
    }
}
