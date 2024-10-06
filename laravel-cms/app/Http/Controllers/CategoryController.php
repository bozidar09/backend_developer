<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Validation\Rule;

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
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:categories'],
            'order' => ['required', 'integer', 'gt:0'],
        ]);

        Category::create($data);

        return redirect()->route('categpries.index')->with('success', 'Succesfully stored category ' . $data['name']);
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
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', Rule::unique('categories')->ignore($category)],
            'order' => ['required', 'integer', 'gt:0'],
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Succesfully updated category' . $data['name']);
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