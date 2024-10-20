<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = public_path('storage/images/users');
        !File::isDirectory($path) ? File::makeDirectory($path, 0755, true, true) : '';    

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

        // User avatar factory path fix
        $users = User::all();
        foreach ($users as $user) {
            $user->update(['avatar' => preg_replace('/.*(?:\/public\/storage)/', '', $user->avatar)]);
        }
    }
}