<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $mailProviders = ['gmail', 'yahoo', 'protonmail', 'yandex'];

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'avatar' => fake()->gravatar(public_path('storage/images/users'), 'identicon'),
            'email' => $firstName . '.' . $lastName . fake()->unique()->randomNumber(3) . '@' . fake()->randomElement($mailProviders) . '.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role_id' => Role::inRandomOrder()->first() ?? Role::factory()->create(),
            'job' => fake()->optional()->jobTitle(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
