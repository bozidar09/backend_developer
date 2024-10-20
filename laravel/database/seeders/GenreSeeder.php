<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    private const GENRES = ['Action', 'Adventure', 'Animated', 'Comedy', 'Documentary', 'Drama', 'Fantasy', 'Historical', 'Horror', 'Musical', 'Noir', 'Romance', 'Science Fiction', 'Thriller', 'Western'];

    public function run(): void
    {
        foreach (self::GENRES as $genre) {
            Genre::factory()->create([
                'name' => $genre,
            ]);
        }
    }
}
