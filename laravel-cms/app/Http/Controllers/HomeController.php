<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        $featured = Article::with('author.role')->where('featured', true)->first();
        $latest = Article::with('author.role')->latest()->where('featured', true)->where('id', '<>', $featured->id)->limit(2)->get();

        $usedIds = $latest->pluck('id');
        $usedIds[] = $featured->id;
        $articles = Article::with('author.role', 'category')->latest()->whereNotIn('id', $usedIds)->paginate(9);

        $tags = Tag::join('article_tag', 'article_tag.tag_id', '=', 'tags.id')
            ->select('tags.name', DB::raw('count(tags.id) as occurence'))
            ->groupBy('tags.id')->orderBy('occurence', 'desc')->limit(4)->get();

        return view('home', compact('categories', 'featured', 'latest', 'articles', 'tags'));
    }
}
