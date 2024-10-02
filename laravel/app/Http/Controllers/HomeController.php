<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $popularMovies = DB::table('movies')
            ->join('genres', 'movies.genre_id', '=', 'genres.id')
            ->join('copies', 'copies.movie_id', '=', 'movies.id')
            ->join('copy_rental', 'copy_rental.copy_id', '=', 'copies.id')
            ->join('rentals', 'copy_rental.rental_id', '=', 'rentals.id')
            ->join('prices', 'movies.price_id', '=', 'prices.id')
            ->select('movies.title as movie_title', 'movies.year as movie_year', 
                    'genres.name as genre', 'prices.type', DB::raw('count(movies.id) as rentals_number'))
            ->where('rentals.rental_date', '>', '2024-01-01')
            ->groupBy('copies.movie_id')
            ->orderBy('rentals_number', 'desc')
            ->limit(3)
            ->get();
        
        $moviesWithGenres = DB::table('genres')
            ->join('movies', 'movies.genre_id', '=', 'genres.id')
            ->join('prices', 'movies.price_id', '=', 'prices.id')
            ->select('movies.title as movie_title', 'movies.year as movie_year', 
                    'genres.id as genre_id', 'genres.name as genre', 'prices.type')
            ->get();
    
        $moviesByGenre = [];
        foreach ($moviesWithGenres as $key => $movie) {
            $genreName = $movie->genre;
            if(!isset($moviesByGenre[$genreName])){
                $moviesByGenre[$genreName] = [];
            }
            if (count($moviesByGenre[$genreName]) < 5){
                $moviesByGenre[$genreName][] = $movie;
            }
        }

        return view('frontend.home', [
            'popularMovies' => $popularMovies,
            'moviesByGenre' => $moviesByGenre,
        ]);
    }
}