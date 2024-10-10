<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Services\ViewCounterService;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            $featured = Article::with('author.role')->where('category_id', $category->id)->where('featured', true)->first();
            $latest = Article::with('author.role', 'category')->where('category_id', $category->id)->where('id', '<>', $featured->id)->latest()->limit(3)->get();

            $articles[$category->name] = [
                    'featured' => $featured, 
                    'latest' => $latest
                    ];
        }

        return view('home.index', compact('articles', 'categories'));
    }

    /**
     * Display the specified resource.
     */
    public function showCategory(Category $category)
    {
        $latest = $category->articles()->with('author.role')->orderBy('featured', 'desc')->latest()->limit(2)->get();

        $usedIds = $latest->pluck('id');
        $articles = Article::with('author.role', 'category')->where('category_id', $category->id)->orderBy('views', 'desc')->latest()->paginate(9);

        return view('home.show-category', compact('category', 'latest', 'articles'));
    }

    /**
     * Display the specified resource.
     */
    public function showUser(User $user)
    {
        $user = User::where('id', $user->id)->with('role')->first();
        $articles = $user->articles()->with('author.role', 'category')->orderBy('views', 'desc')->latest()->paginate(9);

        return view('home.show-user', compact('user', 'articles'));
    }

    /**
     * Display the specified resource.
     */
    public function showTag(Tag $tag)
    {
        $articles = $tag->articles()->with('author.role', 'category')->latest()->paginate(9);

        return view('home.show-tag', compact('tag', 'articles'));
    }

    /**
     * Display the specified resource.
     */
    public function showArticle(Article $article, ViewCounterService $viewCounter)
    {
        $article = Article::where('id', $article->id)->with('author', 'category', 'comments', 'tags')->first();
        $viewCounter->count($article);

        return view('home.show-article', compact('article'));
    }
}
