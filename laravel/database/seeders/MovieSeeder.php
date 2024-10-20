<?php

namespace Database\Seeders;

// use App\Models\Copy;
// use App\Models\Format;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Price;
// use App\Services\BarcodeService;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $genres = Genre::all() ?? Genre::factory()->create();
        $prices = Price::all() ?? Price::factory()->create();
        $moviesData = include_once(resource_path('data/movies.php'));

        foreach ($genres as $genre) {
            foreach ($prices as $price) {
                Movie::factory(rand(1, 3))
                    ->state(function() use(&$moviesData){
                        $key = array_rand($moviesData);
                        $title = $moviesData[$key]['title'];
                        $year = $moviesData[$key]['year'];
                        unset($moviesData[$key]);
                        
                        return [
                            'title' => $title, 
                            'year' => $year,
                        ];
                    })
                    ->create([
                        'genre_id' => $genre,
                        'price_id' => $price,
                    ]);
            }
        }

        // drugi način za kreiranje filmova
        // Movie::factory(100)->make()->each(function ($movie) {
        //     $movie->genre()->associate(Genre::inRandomOrder()->first());
        //     $movie->price()->associate(Price::inRandomOrder()->first());
        //     $movie->save();
        // });


        // kreiranje filmova i kopija u jednom

        // $formats = Format::all() ?? Format::factory()->create();
        // $barcodeService = new BarcodeService();

        // foreach ($genres as $genre) {
        //     foreach ($prices as $price) {
        //         Movie::factory(rand(1, 3))
        //             ->create([
        //             'genre_id' => $genre,
        //             'price_id' => $price,
        //             ])
        //             ->each(function($movie) use($formats, $barcodeService) {
        //                 foreach ($formats as $format) {
        //                    $barcode = $barcodeService->generate($movie, $format);

        //                     Copy::factory(rand(1, 3))->create([
        //                         'barcode' => $barcode,
        //                         'movie_id' => $movie,
        //                         'format_id' => $format,
        //                     ]);
        //                 }
        //             }
        //         );
        //     }
        // }
    }
}
