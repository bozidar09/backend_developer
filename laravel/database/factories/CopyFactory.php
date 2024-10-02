<?php

namespace Database\Factories;

use App\Models\Format;
use App\Models\Movie;
use App\Services\BarcodeService;
use Illuminate\Database\Eloquent\Factories\Factory;


//  @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Copy>

class CopyFactory extends Factory
{
    public function definition(): array
    {
        $movie = Movie::inRandomOrder()->first() ?? Movie::factory()->create();
        $format = Format::inRandomOrder()->first() ?? Format::factory()->create();

        // primjer servisa
        $barcodeService = new BarcodeService();

        return [
            'barcode' => $barcodeService->generate($movie, $format),
            'movie_id' => $movie,
            'format_id' => $format,
        ];
    }
}
