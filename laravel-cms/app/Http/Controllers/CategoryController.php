<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(10);

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
            'order' => $request->order,
        ]);

        return redirect()->route('categpries.index')->with('success', 'Succesfully stored category ' . $request->name);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = Category::where('id', $category->id)->with('articles')->first();

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category = Category::where('id', $category->id)->first();

        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->name,
            'order' => $request->order,
        ]);

        return redirect()->route('categories.index')->with('success', 'Succesfully updated category' . $request->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $name = $category->name;
        try {
            $category->delete();
        } catch (\PDOException $e) {
            return redirect()->route('categories.index')->with('danger', "Can't delete category before related articles");
        }

        return redirect()->route('categories.index')->with('success', 'Succesfully deleted category ' . $name);
    }
}