<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    private const TAGS = ['Government', 'Crime', 'Politics', 'Weather', 'Disaster', 
                        'Health', 'Parenting', 'Shoping', 'Food', 'Travel', 'Cars',
                        'Celebrity', 'Music', 'Movies', 'TV', 
                        'Markets', 'Crypto', 'Industries', 'Energy', 'Science',
                        'Football', 'Basketball', 'Handball', 'Waterpolo', 'Tennis'];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::TAGS as $tag) {
            Tag::create([
                'name' => $tag,
            ]);
        }
    }
}
