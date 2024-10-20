<?php

namespace App\Http\Controllers;

use App\Http\Requests\CopyRequest;
use App\Models\Copy;
use App\Models\Format;
use App\Models\Movie;
use App\Services\BarcodeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CopyController extends Controller
{
    public function index()
    {
        $quantities = Copy::join('movies', 'movies.id', '=', 'copies.movie_id')
        ->join('formats', 'formats.id', '=', 'copies.format_id')
        ->select('movies.id as movie_id', 'movies.title', 'movies.year', 'copies.barcode',
        'formats.id as format_id', 'formats.type', DB::raw('count(movies.id) as quantity'))
        ->groupBy('movies.id', 'copies.barcode', 'formats.id')
        ->orderBy('movies.title')
        ->paginate(20);

        return view('admin.copies.index', compact('quantities'));
    }


    public function create()
    {
        $movies = Movie::all();
        $formats = Format::all();

        return view('admin.copies.create', compact('movies', 'formats'));
    }


    public function store(CopyRequest $request)
    {
        $formats = Format::all();
        
        $rules['movie_id'] = ['required', 'integer', 'gt:0', 'exists:movies,id'];
        foreach ($formats as $format) {
            $rules[strtolower($format->type)] = ['nullable', 'integer', 'gte:0'];
        }
        $data = $request->validate($rules);

        $barcodeService = new BarcodeService;
        $movie = Movie::where('id', $data['movie_id'])->first();

        foreach ($formats as $format) {
            if($data[strtolower($format->type)] !== null) {
                $barcode = $barcodeService->generate($movie, $format);
                
                for ($i=0; $i < $data[strtolower($format->type)]; $i++) { 
                    $newData[] = [
                        'barcode' => $barcode,
                        'movie_id' => $movie->id,
                        'format_id' => $format->id,
                    ];
                }
            }
        }

        $movie->copies()->createMany($newData);

        return redirect()->route('copies.index')->with('success', 'Uspješno spremljene kopije filma ' . $movie->title);
    }


    public function show(Copy $copy)
    {
        $copies = Copy::where('barcode', $copy->barcode)->with(['format', 'movie'])->paginate(20);
        
        return view('admin.copies.show', compact('copies', 'copy'));
    }


    public function edit(Copy $copy)
    {
        return view('admin.copies.edit', compact('copy'));
    }


    public function update(CopyRequest $request, Copy $copy)
    {
        $data = $request->validate([
            'barcode' => ['required', 'string'],
            'available' => ['required', 'integer', 'gte:0', 'lte:1'],
        ]);
        
        $copy->update($data);

        return redirect('/copies')->with('success', 'Uspješno izmijenjena kopija ' . $data['barcode']);
    }


    public function destroy(Copy $copy)
    {
        $barcode = $copy->barcode;

        try {
            $copy->delete();
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Ne možete obrisati kopiju filma prije nego obrišete vezane posudbe');
        }

        $quantities = $copy->where('barcode', $copy->barcode)->get();
        if(!count($quantities)) return redirect('/copies')->with('success', 'Uspješno obrisana kopija sa barcodeom ' . $barcode);

        return redirect()->back()->with('success', 'Uspješno obrisana kopija sa barcodeom ' . $barcode);
    }

    public function destroyAll(Copy $copy)
    {
        $barcode = $copy->barcode;
        try {
            $copy->delete();
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Ne možete obrisati kopije filma prije nego obrišete vezane posudbe');
        }

        return redirect()->back()->with('success', 'Uspješno obrisane sve kopije sa barcodeom ' . $barcode);
    }
}
