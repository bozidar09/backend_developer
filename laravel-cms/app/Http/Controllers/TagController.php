<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        //
    }
}


<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Illuminate\Validation\Rule;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::paginate(20);

        return view('admin.genres.index', compact('genres'));
    }


    public function create()
    {
        return view('admin.genres.create');
    }


    public function store(GenreRequest $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:genres'],
        ]);

        Genre::create($data);

        return redirect()->route('genres.index')->with('success', 'Uspješno spremljen žanr ' . $data['name']);
    }


    public function show(Genre $genre)
    {
        $genre = Genre::where('id', $genre->id)->with('movies.price', 'movies.copies.format')->first();

        return view('admin.genres.show', compact('genre'));
    }


    public function edit(Genre $genre)
    {
        $genre = Genre::where('id', $genre->id)->first();

        return view('admin.genres.edit', compact('genre'));
    }


    public function update(GenreRequest $request, Genre $genre)
    {
        $data = $request->validate([
            'name' => ['required', 'string', Rule::unique('genres')->ignore($genre)],
        ]);
        
        $genre->update($data);

        return redirect()->route('genres.index')->with('success', 'Uspješno izmijenjen žanr ' . $data['name']);
    }


    public function destroy(Genre $genre)
    {
        $name = $genre->name;
        try {
            $genre->delete();
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Ne možete obrisati žanr prije nego obrišete vezane filmove');
        }

        return redirect()->route('genres.index')->with('success', 'Uspješno obrisan žanr ' . $name);
    }
}