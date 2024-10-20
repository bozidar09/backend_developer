<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::paginate(20);
        
        return view('comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $articles = Article::all();
        $users = User::all();

        return view('comments.create', compact('articles', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request)
    {
        Comment::create([
            'text' => $request->text,
            'article_id' => $request->article_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('comments.index')->with('success', 'Succesfully stored comment');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment = Comment::where('id', $comment->id)->with('user', 'article')->first();

        return view('comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        $comment = Comment::where('id', $comment->id)->with('user', 'article')->first();
        $articles = Article::all();
        $users = User::all();

        return view('comments.create', compact('comment', 'articles', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->update([
            'text' => $request->text,
            'article_id' => $request->article_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('comments.index')->with('success', 'Succesfully updated comment');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();
        } catch (\PDOException $e) { 
            return redirect()->back()->with('danger', "Error, comment not deleted");
        }

        return redirect()->route('comments.index')->with('success', 'Succesfully deleted comment');
    }
}