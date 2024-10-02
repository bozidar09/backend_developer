<?php

namespace App\Http\Controllers;

use App\Http\Requests\MovieRequest;
use App\Models\Format;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Price;
use App\Services\BarcodeService;
use Illuminate\Validation\Rule;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with(['genre', 'price', 'copies.format'])->orderBy('title')->paginate(20);

        // callback funkcija
        // $moviesFiltered = $movies->filter(function($movie){
        //     return $movie->id < 100;
        // });
        // skraćeni zapis 
        // $moviesFiltered = $movies->filter(fn($movie) => $movie->id < 100);

        return view('admin.movies.index', compact('movies'));

        // JSON - JavaScript Object Notation
        // REST API - application interface (metode i JSON)
        // return $movies;
    }


    public function create()
    {
        $genres = Genre::all();
        $prices = Price::all();
        $formats = Format::all();

        return view('admin.movies.create', compact('genres', 'prices', 'formats'));
    }


    public function store(MovieRequest $request)
    {
        $formats = Format::all();

        $rules = [
            'title' => ['required', 'string', 'unique:movies'],
            'year' => ['required', 'numeric', 'gt:0'],
            'genre_id' => ['required', 'numeric', 'gt:0', 'exists:genres,id'],
            'price_id' => ['required', 'numeric', 'gt:0', 'exists:prices,id'],
        ];
        foreach ($formats as $format) {
            $rules[strtolower($format->type)] = ['nullable', 'integer', 'gte:0'];
        }
        $data = $request->validate($rules);

        $movie = Movie::create([
            'title' => $data['title'],
            'year' => $data['year'],
            'genre_id' => $data['genre_id'],
            'price_id' => $data['price_id'],
        ]);

        $barcodeService = new BarcodeService;
        
        $newData = [];
        foreach ($formats as $format) {
            if($data[strtolower($format->type)] !== null) {
                $barcode = $barcodeService->generate($movie, $format);
                
                for ($i=0; $i < $data[strtolower($format->type)]; $i++) { 
                    $newData[] = [
                        'barcode' => $barcode,
                        // 'movie_id' => $movie->id,
                        'format_id' => $format->id,
                    ];
                }
            }
        }

        if ($newData) {
            $movie->copies()->createMany($newData);
        }

        return redirect()->route('movies.index')->with('success', 'Uspješno spremljen film ' . $data['title'] . ' i sve njegove kopije');
    }


    public function show(Movie $movie)
    {
        $movie = Movie::where('id', $movie->id)->with(['genre', 'price', 'copies.format'])->first();

        return view('admin.movies.show', compact('movie'));
    }


    public function edit(Movie $movie)
    {
        $movie = Movie::where('id', $movie->id)->with(['genre', 'price'])->first();
        $genres = Genre::all();
        $prices = Price::all();

        return view('admin.movies.edit', compact('movie', 'genres', 'prices'));
    }

  
    public function update(MovieRequest $request, Movie $movie)
    {
        $data = $request->validate([
            'title' => ['required', 'string', Rule::unique('movies')->ignore($movie)],
            'year' => ['required', 'integer', 'gt:0'],
            'genre_id' => ['required', 'integer', 'gt:0', 'exists:genres,id'],
            'price_id' => ['required', 'integer', 'gt:0', 'exists:prices,id'],
        ]);

        // drugi način updatea jednog po jednog atributa
        // $movie->title = $data['title'];
        // $movie->year = $data['year'];
        // $movie->genre_id = $data['genre_id'];
        // $movie->price_id = $data['price_id'];
        // $movie->save();
        
        $movie->update($data);

        return redirect()->route('movies.index')->with('success', 'Uspješno izmijenjen film ' . $data['title']);
    }


    public function destroy(Movie $movie)
    {
        $title = $movie->title;
        try {
            $movie->delete();
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Ne možete obrisati film prije nego obrišete vezane kopije');
        }

        return redirect()->route('movies.index')->with('success', 'Uspješno obrisan film ' . $title);
    }
}
