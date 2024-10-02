<?php

namespace App\Http\Controllers;

use App\Http\Request;
use App\Models\Article;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $articles = Article::paginate(9);
        $latest = Article::latest()->limit(2)->get();
        $featured = Article::where('featured', true)->first();

        return view('welcome', compact('categories', 'articles', 'latest', 'featured'));
    }
}
