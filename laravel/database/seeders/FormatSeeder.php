<?php

namespace Database\Seeders;

use App\Models\Format;
use Illuminate\Database\Seeder;

class FormatSeeder extends Seeder
{
    private const FORMATS = ['VHS', 'CD', 'DVD', 'Blu-ray'];

    public function run(): void
    {
        foreach (self::FORMATS as $format) {
            Format::factory()->create([
                'type' => $format,
            ]);
        }
    }
}
