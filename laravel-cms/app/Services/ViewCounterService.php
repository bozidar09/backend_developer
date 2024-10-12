<?php

namespace App\Services;

use App\Models\Article;

class ViewCounterService
{
    public function count(Article $article): void
    {
        if ($views = request()->session()->get('views')) {
            if (array_key_exists($article->id, $views) && ($views[$article->id]->diffInSeconds(now()) < 60)) {
                return;
            }
        }

        request()->session()->put('views', [$article->id => now()]);
        $article->increment('views');
    }
}