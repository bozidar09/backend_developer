<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormatRequest;
use App\Models\Format;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FormatController extends Controller
{
    public function index()
    {
        $formats = Format::paginate(20);

        return view('admin.formats.index', compact('formats'));
    }


    public function create()
    {
        return view('admin.formats.create');
    }


    public function store(FormatRequest $request)
    {
        $data = $request->validate([
            'type' => ['required', 'string', 'unique:formats'],
            'coefficient' => ['required', 'numeric', 'gt:0'],
        ]);

        Format::create($data);

        return redirect()->route('formats.index')->with('success', 'Uspješno spremljen medij ' . $data['type']);
    }


    public function show(Format $format)
    {
        $movies = Format::join('copies', 'copies.format_id', '=', 'formats.id')
            ->join('movies', 'movies.id', '=', 'copies.movie_id')
            ->join('prices', 'prices.id', '=', 'movies.price_id')
            ->join('genres', 'genres.id', '=', 'movies.genre_id')
            ->select('movies.*', 'genres.name as genre', 'prices.type as price', DB::raw('count(movies.id) as amount'))
            ->where('formats.id', $format->id)
            ->groupBy('movies.id')
            ->orderBy('movies.title')
            ->get();
        
        return view('admin.formats.show', compact('format', 'movies'));
    }


    public function edit(Format $format)
    {
        return view('admin.formats.edit', compact('format'));
    }


    public function update(FormatRequest $request, Format $format)
    {
        $data = $request->validate([
            'type' => ['required', 'string', Rule::unique('formats')->ignore($format)],
            'coefficient' => ['required', 'numeric', 'gt:0'],
        ]);

        $format->update($data);

        return redirect()->route('formats.index')->with('success', 'Uspješno izmijenjen medij ' . $data['type']);
    }


    public function destroy(Format $format)
    {
        $type = $format->type;
        try {
            $format->delete();
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Ne možete obrisati medij prije nego obrišete vezane kopije filmova');
        }

        return redirect()->route('formats.index')->with('success', 'Uspješno obrisan medij ' . $type);
    }
}
