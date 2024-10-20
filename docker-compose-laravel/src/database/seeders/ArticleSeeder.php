<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all() ?? Category::factory()->create();
        $role = Role::where('name', 'Writer')->first();
        $users = User::where('role_id', $role->id)->get() ?? User::factory()->create(['role_id' => $role]);

        $path = public_path('storage/images/articles');
        !File::isDirectory($path) ? File::makeDirectory($path, 0755, true, true) : '';    

        foreach ($categories as $category) {
            foreach ($users as $user) {
                Article::factory(mt_rand(1, 3))->create([
                        'category_id' => $category,
                        'user_id' => $user,
                    ])->each(function($article){
                        $tags = Tag::inRandomOrder()->limit(mt_rand(1, 3))->pluck('id');
                        $article->tags()->attach($tags);

                        if ($article->id % 5 === 0) {
                            $article->update(['featured' => 1]);
                        }
                    });
            }
        }

        // Article image factory path fix
        $articles = Article::all();
        foreach ($articles as $article) {
            $article->update(['image' => preg_replace('/.*(?:\/public\/storage)/', '', $article->image)]);
        }
    }
}
