<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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

            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Using closure based composers...
        Facades\View::composer('home.*', function(View $view) {
            $categories = Category::all();

            $tags = Tag::join('article_tag', 'article_tag.tag_id', '=', 'tags.id')
            ->select('tags.id', 'tags.name', 'tags.slug', DB::raw('count(tags.id) as occurence'))
            ->groupBy('tags.id', 'tags.name', 'tags.slug')->orderBy('occurence', 'desc')->limit(4)->get();

            $view->with([
                'layoutCategories' => $categories,
                'layoutTags' => $tags,
            ]);
        });

        // Admin allow all policy
        Gate::before(function (User $user, string $ability){
            return $user->role->name === "Admin" ? true : null;
        });

        // Blade check role
        Blade::if('role', function(string|array $role){
            $userRole = mb_strtolower(Role::where('id', Auth::user()->role_id)->first()->name);
            return is_array($role) ? in_array($userRole, $role) : $userRole === $role;
        });
    }
}
