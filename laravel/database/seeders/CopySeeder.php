<?php

namespace Database\Seeders;

use App\Models\Copy;
use App\Models\Format;
use App\Models\Movie;
use App\Services\BarcodeService;
use Illuminate\Database\Seeder;

class CopySeeder extends Seeder
{
    public function run(): void
    {
        $formats = Format::all() ?? Format::factory()->create();
        $movies = Movie::all() ?? Movie::factory()->create();

        $barcodeService = new BarcodeService();

        foreach ($formats as $format) {
            foreach ($movies as $movie) {
                $barcode = $barcodeService->generate($movie, $format);

                Copy::factory(rand(1, 3))->create([
                    'barcode' => $barcode,
                    'movie_id' => $movie,
                    'format_id' => $format,
                ]);
            }
        }
    }
}
