<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all() ?? Role::factory()->create();

        foreach ($roles as $role) {
            $number = match ($role->name) {
                'Admin' => 3,
                'Writer' => 6,
                default => 12,
            };

            User::factory($number)->create([
                'role_id' => $role,
            ]);
        }
    }
}