<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'Member',
            'email' => 'algebra@mail.com',
            'password' => Hash::make('123'),
            'role_id' => Role::where('name', 'admin')->first()->id,
        ]);

        // User avatar path fix
        $users = User::all();
        foreach ($users as $user) {
            $user->update(['avatar' => str_replace('/var/www/backend_developer/laravel-cms/public/storage', '', $user->avatar)]);
        }
    }
}