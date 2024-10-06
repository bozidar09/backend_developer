<?php

namespace App\Services;

use App\Models\Article;

class ViewCounterService
{
    public function count(Article $article): void
    {
        if (request()->session()->has('views')) {
            $views = request()->session()->get('views');
            if (array_key_exists($article->id, $views)) {
                if($views[$article->id]['created_at']->diffInSeconds(now()) < 60) {
                    return;
                }
            }
        }
        request()->session()->put($views[$article->id]['created_at'], now());
        $article->increment('views');
    }
}