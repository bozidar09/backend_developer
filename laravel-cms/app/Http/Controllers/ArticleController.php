<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Services\ViewCounterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $latest = Article::with('author.role')->latest()->where('featured', true)->limit(2)->get();

        $usedIds = $latest->pluck('id');
        $articles = Article::with('author.role', 'category')->latest()->paginate(12);

        return view('articles.index', compact('latest', 'articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Article::class);

        $categories = Category::all();
        $tags = Tag::all();

        return view('articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        Gate::authorize('create', Article::class);

        $article = Article::create([
            'title' => $request->title,
            'image' => $request->image,
            'body' => $request->body,
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        $article->tags()->attach($request->tags);

        if ($image = $request->file('image')) {
             $path = $image->store("images/articles/$article->slug", "public");
             $article->update(['image' => $path]);
        }

        return redirect()->route('articles.index')->with('success', 'Succesfully stored article ' . $request->title);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article, ViewCounterService $viewCounter)
    {
        $article = Article::where('id', $article->id)->with('category', 'author', 'comments', 'tags')->first();

        $viewCounter->count($article);

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);

        $article = Article::where('id', $article->id)->with('category', 'author', 'comments', 'tags')->first();
        $categories = Category::all();
        $tags = Tag::all();

        return view('articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        Gate::authorize('update', $article);     

        $article->update([
            'title' => $request->title,
            'body' => $request->body,
            'category_id' => $request->category,
        ]);

        if ($image = $request->file('image')) {
            Storage::disk('public')->delete($article->image);

            $path = $image->store("images/articles/$article->id", "public");
            $article->update(['image' => $path]);
        }

        if ($request->tags) {
            $article->tags()->sync($request->tags);
        } else {
            $article->tags()->detach();
        }

        return redirect()->route('articles.index')->with('success', 'Succesfully updated article ' . $request->title);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $title = $article->title;
        try {
            $article->delete();

        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Error, article not deleted');
        }

        return redirect()->route('articles.index')->with('success', 'Succesfully deleted article ' . $title);
    }

    /**
     * Display the specified resource.
     */
    public function byAuthor(User $user)
    {
        $articles = $user->articles()->with('author', 'tags')->latest()->paginate(9);
        $header = $user->fullName();

        return view('articles.index', compact('articles', 'header'));
    }

    /**
     * Display the specified resource.
     */
    public function byTag(Tag $tag)
    {
        $articles = $tag->articles()->with('author', 'tags')->latest()->paginate(9);
        $header = $tag->name;

        return view('articles.index', compact('articles', 'header'));
    }

    /**
     * Display the specified resource.
     */
    public function byCategory(Category $category)
    {
        // $articles = Article::where('category_id', $id)->with('author', 'tags')->latest()->paginate(10);
        // $articles = Article::whereCategoryId($id)->with('author', 'tags')->latest()->paginate(10);
        $articles = $category->articles()->with('author', 'tags')->latest()->paginate(9);
        $header = $category->name;

        return view('articles.index', compact('articles', 'header'));
    }

}