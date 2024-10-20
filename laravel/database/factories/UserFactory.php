<?php

namespace Database\Factories;

use App\Services\MembershipService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


//  @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>

class UserFactory extends Factory
{
    // The current password being used by the factory.
    protected static ?string $password;

    public function definition(): array
    {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
        $mailProviders = ['gmail', 'yahoo', 'protonmail', 'yandex'];

        $membership = new MembershipService();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'member_id' => $membership->generate(),
            'email' => $firstName . '.' . $lastName . fake()->unique()->randomNumber(3) . '@' . fake()->randomElement($mailProviders) . '.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    // Indicate that the model's email address should be unverified.
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
