<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public const CATEGORIES = ['News', 'Life', 'Entertainment', 'Finance', 'Sports'];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::CATEGORIES as $key => $category) {
            Category::create([
                'name' => $category,
                'order' => $key,
            ]);
        }
    }
}
