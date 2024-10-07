<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $featured = Article::with('author.role')->where('featured', true)->first();

        $latest = Article::with('author.role')->latest()->where('featured', true)->where('id', '<>', $featured->id)->limit(2)->get();

        $usedIds = $latest->pluck('id');
        $usedIds[] = $featured->id;
        $articles = Article::with('author.role', 'category')->latest()->whereNotIn('id', $usedIds)->paginate(9);

        return view('home.index', compact('featured', 'latest', 'articles'));
    }

    /**
     * Display the specified resource.
     */
    public function showCategory(Category $category)
    {
        $latest = Article::with('author.role')->where('category_id', $category->id)->orderBy('featured', 'desc')->latest()->limit(2)->get();

        $usedIds = $latest->pluck('id');
        $articles = Article::with('author.role', 'category')->where('category_id', $category->id)->orderBy('views', 'desc')->latest()->paginate(9);

        return view('home.show-category', compact('category', 'latest', 'articles'));
    }

    /**
     * Display the specified resource.
     */
    public function showTag(Tag $tag)
    {
        $articles = Tag::with('articles.author.role', 'articles.category')->where('id', $tag->id)->latest()->paginate(9);

        return view('home.show-tag', compact('tag', 'articles'));
    }

    /**
     * Display the specified resource.
     */
    public function showArticle(Article $article)
    {
        $article = Article::where('id', $article->id)->with('author', 'category', 'comments', 'tags')->first();

        return view('home.show-article', compact('article'));
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
        
        return redirect()->route('showArticle', $article->id)->with('success', 'Succesfully stored comment');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editComment(Article $article, Comment $comment)
    {
        $article = Article::where('id', $article->id)->with('category', 'author', 'comments', 'tags')->first();

        $tagIds = $article->tags->pluck('id');
        $tags = Tag::whereNotIn('id', $tagIds)->get();

        return view('editArticleComment', compact('article', 'tags'));
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

        return redirect()->route('showArticle', $article->id)->with('success', 'Succesfully updated comment');
    }
}
