<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::paginate(10);

        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        $data = $request->additionalTag;

        if (str_contains($data , ',')) {
            $tags = explode(',', $data );
        } else {
            $tags[] = $data;
        }

        foreach ($tags as $tag) {
            Validator::make(['additionalTag' => $tag], ['additionalTag' => 'required|unique:tags,name'])->validateWithBag('additionalTagCreation');
            Tag::create(['name' => $tag]);
        }

        return redirect()->route('tags.index')->with('success', 'Succesfully stored tag' . $request->name);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag)
    {
        $tag = Tag::where('id', $tag->id)->with('articles.author')->first();

        return view('tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        $tag = Tag::where('id', $tag->id)->first();

        return view('tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update([
            'name' => $request->name,
        ]);

        return redirect()->route('tags.index')->with('success', 'Succesfully updated tag' . $request->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $name = $tag->name;
        try {
            $tag->delete();
        } catch (\PDOException $e) {
            return redirect()->back()->with('danger', "You cannot delete tag before related articles");
        }

        return redirect()->router('tags.index')->with('success', 'Succesfully deleted tag ' . $name);
    }
}