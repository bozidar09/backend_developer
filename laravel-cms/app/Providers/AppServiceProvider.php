<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (!$this->app->environment('production')) {
            $faker = fake();
            $faker->addProvider(new \Ottaviano\Faker\Gravatar($faker));
            $faker->addProvider(new \Smknstd\FakerPicsumImages\FakerPicsumImagesProvider($faker));
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $categories = Category::all();

        $tags = Tag::join('article_tag', 'article_tag.tag_id', '=', 'tags.id')
        ->select('tags.id', 'tags.name', DB::raw('count(tags.id) as occurence'))
        ->groupBy('tags.id')->orderBy('occurence', 'desc')->limit(4)->get();

        // Using closure based composers...
        Facades\View::composer('*', function(View $view) use($categories, $tags){
            $view->with([
                'categories' => $categories,
                'tags' => $tags,
            ]);
        });
    }
}
