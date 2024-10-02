<?php

namespace Database\Seeders;

use App\Models\Copy;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all() ?? User::factory()->create();

        foreach ($users as $user) {
            Rental::factory(rand(1, 3))
            ->create(['user_id' => $user])
            ->each(function($rental){
                $date = $rental->return_date;
                for ($i=0; $i < rand(1, 3); $i++) { 
                    $copy = Copy::factory()->create(['available' => $date ? 1 : 0]);

                    $rental->copies()->attach($copy->id, [
                        'return_date' => $date,
                    ]);

                    $date = $rental->return_date ? fake()->dateTimeBetween($rental->rental_date, $rental->return_date) : fake()->optional()->dateTimeBetween($rental->rental_date, 'now');
                }
            });
        }
    }
}
