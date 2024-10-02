<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    private const PRICES = ['Old', 'New', 'Classic', 'Blockbuster'];

    public function run(): void
    {
        foreach (self::PRICES as $price) {
            Price::factory()->create([
                'type' => $price,
            ]);
        }
    }
}
