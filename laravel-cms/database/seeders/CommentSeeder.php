<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = Article::all() ?? Article::factory()->create();

        foreach ($articles as $article) {
            $users = User::inRandomOrder()->limit(mt_rand(3, 5))->get() ?? User::factory()->create();

            foreach ($users as $user) {
                Comment::factory(mt_rand(1, 3))->create([
                        'article_id' => $article,
                        'user_id' => $user,
                ]);
            }
        }
    }
}
