<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Mail\ArticleCreated;
use App\Mail\ArticleDeleted;
use App\Mail\ArticleUpdated;
use App\Models\Article;
use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use App\Services\ViewCounterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Get data from database.
     */
    public function getData(): array
    {
        $data['users'] = User::whereIn('role_id', Role::whereIn('name',  ['Writer', 'Admin'])->get()->pluck('id'))->get();
        $data['categories'] = Category::all();
        $data['tags'] = Tag::all();

        return $data;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->getData();

        $latest = Article::with('author.role')->latest()->where('featured', true)->limit(2)->get();

        $usedIds = $latest->pluck('id');
        $articles = Article::with('author.role', 'category')->latest()->paginate(12);

        return view('articles.index', compact('latest', 'articles', 'data'));
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
        // Gate::authorize('create', Article::class);
        
        $user = Auth::user();

        $article = Article::create([
            'title' => $request->title,
            'body' => $request->body,
            'featured' => $request->featured ?? false,
            'user_id' => $user->id,
            'category_id' => $request->category_id,
        ]);

        $article->tags()->attach($request->tags);

        if ($image = $request->file('image')) {
             $path = $image->store("images/articles", "public");
             $article->update(['image' => $path]);
        }

        Mail::to($user->email)->send(new ArticleCreated($article, $user));

        return redirect()->route('articles.index')->withFlashMessage('Succesfully stored article ' . $request->title);
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
        // Gate::authorize('update', $article);     

        $article->update([
            'title' => $request->title,
            'body' => $request->body,
            'featured' => $request->featured ?? false,
            'category_id' => $request->category_id,
        ]);

        if ($image = $request->file('image')) {
            Storage::disk('public')->delete($article->image);

            $path = $image->store("images/articles", "public");
            $article->update(['image' => $path]);
        }

        if ($request->tags) {
            $article->tags()->sync($request->tags);
        } else {
            $article->tags()->detach();
        }
        
        $user = $request->user();
        Mail::to('algebra@mail.com')->send(new ArticleUpdated($article, $user));

        return redirect()->route('articles.index')->withFlashMessage('Succesfully updated article ' . $request->title);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $title = $article->title;
        $author = $article->author;

        try {
            $article->delete();

        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', 'Error, article not deleted');
        }

        // druga opcija - !Auth::user()->is($author)
        if (Auth::user()->id !== $author->id) {
            Mail::to($author)->send(new ArticleDeleted($article, $author));
        }

        return redirect()->route('articles.index')->with('success', 'Succesfully deleted article ' . $title);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyImage(Article $article)
    {
        Storage::disk('public')->delete($article->image);
        $article->update(['image' => null]);

        $article = Article::where('id', $article->id)->with('category', 'author', 'comments', 'tags')->first();
        $categories = Category::all();
        $tags = Tag::all();

        return view('articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Display the specified resource.
     */
    public function byAuthor(User $user)
    {
        $data = $this->getData();
        
        $articles = $user->articles()->with('author', 'tags')->latest()->paginate(9);
        $header = $user->fullName();

        return view('articles.index', compact('articles', 'header', 'data'));
    }

    /**
     * Display the specified resource.
     */
    public function byTag(Tag $tag)
    {
        $data = $this->getData();

        $articles = $tag->articles()->with('author', 'tags')->latest()->paginate(9);
        $header = $tag->name;

        return view('articles.index', compact('articles', 'header', 'data'));
    }

    /**
     * Display the specified resource.
     */
    public function byCategory(Category $category)
    {
        $data = $this->getData();

        // $articles = Article::where('category_id', $id)->with('author', 'tags')->latest()->paginate(10);
        // $articles = Article::whereCategoryId($id)->with('author', 'tags')->latest()->paginate(10);
        $articles = $category->articles()->with('author', 'tags')->latest()->paginate(9);
        $header = $category->name;

        return view('articles.index', compact('articles', 'header', 'data'));
    }

    /**
     * Display the filtered resource.
     */
    public function filterArticles(ArticleRequest $request)
    {
        $data = $this->getData();
        $header = 'Filtered articles';

        $articles = Article::with('tags')->get();
        if ($request->users) {
            $articles = $articles->whereIn('user_id', $request->users);
        }
        if ($request->categories) {
            $articles = $articles->whereIn('category_id', $request->categories);
        }
        if ($request->tags) {
            $articleIds = Tag::join('article_tag', 'article_tag.tag_id', '=', 'tags.id')
                ->select('article_tag.article_id')->whereIn('tag_id', $request->tags)->get()->pluck('article_id');
            $articles = $articles->whereIn('id', $articleIds);
        }
        $articles = $articles->pluck('id');
        $articles = Article::whereIn('id', $articles)->with('author.role', 'category')->latest()->paginate(12);

        return view('articles.index', compact('header', 'articles', 'data'));
    }

    /**
     * Display the specified resource.
     */
    public function testMail(Article $article)
    {
        // return new ArticleCreated($article, Auth::user());
        // return new ArticleUpdated($article, Auth::user());
        return new ArticleDeleted($article, Auth::user());
    }
}