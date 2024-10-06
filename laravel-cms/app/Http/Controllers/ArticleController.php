<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Services\ViewCounterService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        $tags = Tag::join('article_tag', 'article_tag.tag_id', '=', 'tags.id')
        ->select('tags.name', DB::raw('count(tags.id) as occurence'))
        ->groupBy('tags.id')->orderBy('occurence', 'desc')->limit(4)->get();

        $latest = Article::with('author.role')->latest()->where('featured', true)->limit(2)->get();

        $usedIds = $latest->pluck('id');
        $articles = Article::with('author.role', 'category')->latest()->paginate(12);

        return view('articles', compact('categories', 'tags', 'latest', 'articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        $tags = Tag::all();

        return view('articles.create', compact('categories', 'users', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'unique:articles,title'],
            'image' => ['nullable', 'image'],
            'body' => ['required', 'string'],
            'featured' => ['nullable', 'integer', 'gte:0', 'lte:1'],
            'category_id' => ['required', 'integer', 'gt:0', 'exists:categories,id'],
            'user_id' => ['required', 'integer', 'gt:0', 'exists:users,id'],
            'tag_id' => ['required', 'integer', 'gt:0', 'exists:tags,id'],
        ]);
        $data['slug'] = Str::slug($data['title']);

        $article = Article::create($data);
        $article->tags()->attach($data['tag_id']);

        return redirect()->route('articles.index')->with('success', 'Succesfully stored article ' . $data['title']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article = Article::where('id', $article->id)->with('category', 'author', 'comments', 'tags')->first();

        (new ViewCounterService())->count($article);

        return view('article.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $article = Article::where('id', $article->id)->with('category', 'author', 'comments', 'tags')->first();

        $tagIds = $article->tags->pluck('id');
        $tags = Tag::whereNotIn('id', $tagIds)->get();

        return view('article.edit', compact('article', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $data = $request->validate([
            'title' => ['required', 'string', Rule::unique('title')->ignore($article)],
            'slug' => ['required', 'string', Rule::unique('slug')->ignore($article)],
            'image' => ['nullable', 'image'],
            'body' => ['required', 'string'],
            'featured' => ['nullable', 'integer', 'gte:0', 'lte:1'],
            'category_id' => ['required', 'integer', 'gt:0', 'exists:categories,id'],
            'user_id' => ['required', 'integer', 'gt:0', 'exists:users,id'],
        ]);

        $rules['new_tag_id'] = ['nullable', 'integer', 'gt:0', 'exists:tags,id'];
        $article = Article::where('id', $article->id)->with('pivot')->first();
        foreach ($article->pivot as $article_tag) {
            $rules['tag_' . $article_tag->id] = ['nullable', 'integer', 'gt:0', 'exists:tags,id'];
        }
        $tagData = array_unique($request->validate($rules));

        if (count($tagData) > 4) {
            throw ValidationException::withMessages(['new_tag_id' => "Not allowed more than 4 tags"]);
        }

        foreach ($article->pivot as $article_tag) {
            $tagData['tag_' . $article_tag->id] ? $article->tags()->updateExistingPivot($article_tag->id, [
                'tag_id' => $data['tag_' . $article_tag->id]
                ]) : $article->tags()->detach($article_tag->id);
        }
        $article->update($data);
        

        return redirect()->route('articles.index')->with('success', 'Succesfully stored article ' . $data['title']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $title = $article->title;
        try {
            DB::transaction(function() use($article) {
                $article = Article::where('id', $article->id)->with('comments', 'tags')->first();
                foreach ($article->tags as $tag) {
                    $article->tags()->where('id', $tag->id)->detach($tag->id);
                }

                // $commentIds = $article->comments->pluck('id');
                // $article->comments()->whereIn('id', $commentIds)->delete();

                $article->delete();
            });
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Error, article not deleted');
        }

        return redirect()->route('articles.index')->with('success', 'Succesfully deleted article ' . $title);
    }
}