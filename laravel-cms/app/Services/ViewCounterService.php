<?php

namespace App\Services;

use App\Models\Article;

class ViewCounterService
{
    public function count(Article $article) 
    {
        // TODO session/timer validation
        $article->increment('views');
    }
}