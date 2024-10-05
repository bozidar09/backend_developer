<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            User::factory($role->id * 3)->create([
                'role_id' => $role,
            ]);
        }
    }
}