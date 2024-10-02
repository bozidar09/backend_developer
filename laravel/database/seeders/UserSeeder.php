<?php

namespace Database\Seeders;

// use App\Models\Copy;
// use App\Models\Rental;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i=0; $i < 15; $i++) {
            User::factory()->create();
        }

        // svakom useru će stvoriti random broj rentala i random broj posuđenih kopija
        // User::factory(10)
        //     ->create()
        //     ->each(fn() => Rental::factory(rand(1, 3))
        //             ->create()
        //             ->each(function($rental){
        //                 for ($i=0; $i < rand(1,3); $i++) { 
        //                     $date = $rental->return_date ? fake()->dateTimeBetween($rental->rental_date, $rental->return_date) : fake()->optional()->dateTimeBetween($rental->rental_date, 'now');              
        //                     if ($i = 0) {
        //                         $date = $rental->return_date ?? null;
        //                     }
        //                     $copy = Copy::factory()->create(['available' => $date ? 1 : 0]);

        //                     $rental->copies()->attach($copy, [
        //                         'copy_id' => $copy->id,
        //                         'return_date' => $date,
        //                     ]);
        //                 }
        //             })
        // );
    }
}
