<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Http\Request;
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

        return view('home.index', compact('categories', 'featured', 'latest', 'articles', 'tags'));
    }

    /**
     * Display the specified resource.
     */
    public function showCategory(Category $category)
    {
        $categories = Category::all();

        $tags = Tag::join('article_tag', 'article_tag.tag_id', '=', 'tags.id')
        ->select('tags.name', DB::raw('count(tags.id) as occurence'))
        ->groupBy('tags.id')->orderBy('occurence', 'desc')->limit(4)->get();

        $latest = Article::with('author.role')->where('category_id', $category->id)->orderBy('featured', true)->latest()->limit(2)->get();

        $usedIds = $latest->pluck('id');
        $articles = Article::with('author.role', 'category')->where('category_id', $category->id)->orderBy('views', 'desc')->latest()->paginate(12);

        return view('showCategory', compact('categories', 'tags', 'latest', 'articles'));
    }

    /**
     * Display the specified resource.
     */
    public function showArticle(Article $article)
    {
        $categories = Category::all();

        $tags = Tag::join('article_tag', 'article_tag.tag_id', '=', 'tags.id')
        ->select('tags.name', DB::raw('count(tags.id) as occurence'))
        ->groupBy('tags.id')->orderBy('occurence', 'desc')->limit(4)->get(); 

        $article = Article::where('id', $article->id)->with('author', 'category', 'comments', 'tags')->first();

        return view('showArticle', compact('categories', 'tags', 'article'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeComment(Article $article, Request $request)
    {
        $data = $request->validate([
            'text' => ['required', 'string'],
            'article_id' => ['required', 'integer', 'gt:0', 'exists:articles,id'],
            'user_id' => ['required', 'integer', 'gt:0', 'exists:users,id'],
        ]);

        Comment::create($data);
        
        return redirect()->route('showArticle')->with('success', 'Succesfully stored comment');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article, Comment $comment)
    {
        $article = Article::where('id', $article->id)->with('category', 'author', 'comments', 'tags')->first();

        $tagIds = $article->tags->pluck('id');
        $tags = Tag::whereNotIn('id', $tagIds)->get();

        return view('editArticle', compact('article', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateComment(Article $article, Comment $comment, Request $request)
    {
        $data = $request->validate([
            'text' => ['required', 'string'],
            'article_id' => ['required', 'integer', 'gt:0', 'exists:articles,id'],
            'user_id' => ['required', 'integer', 'gt:0', 'exists:users,id'],
        ]);

        $comment->update($data);

        return redirect()->route('showArticle')->with('success', 'Succesfully updated comment');
    }
}
