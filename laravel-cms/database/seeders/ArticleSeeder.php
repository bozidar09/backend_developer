<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $categories = Category::all() ?? Category::factory()->create();
            $role = Role::where('name', 'Writer')->first();
            $users = User::where('role_id', $role->id)->get() ?? User::factory()->create(['role_id' => $role->id]);

            foreach ($categories as $category) {
                foreach ($users as $user) {
                    Article::factory(mt_rand(1, 3))->create([
                            'category_id' => $category,
                            'user_id' => $user,
                        ])->each(function($article){
                            $tags = Tag::inRandomOrder()->limit(mt_rand(1, 3))->get();
                            foreach ($tags as $tag) { 
                                $article->tags()->attach($tag);
                            }

                            if ($article->id % 10 === 0) {
                                $article->update(['featured' => 1]);
                            }
                        });
                }
            }
    }
}
