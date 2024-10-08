<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CategoryFactory::CATEGORIES as $key => $category) {
            Category::create([
                'name' => $category,
                'order' => $key,
            ]);
        }
    }
}
