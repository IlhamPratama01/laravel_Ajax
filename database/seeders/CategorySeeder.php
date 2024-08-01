<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['kategori' => 'Math', 'slug' => 'math', 'color' => 'red'],
            ['kategori' => 'Science', 'slug' => 'science', 'color' => 'green'],
            ['kategori' => 'History', 'slug' => 'history', 'color' => 'blue'],
            ['kategori' => 'Pemrogaman Python', 'slug' => 'pemrogaman-python', 'color' => 'yellow'],
            ['kategori' => 'Pemrogaman JavaScript', 'slug' => 'pemrogaman-javascript', 'color' => 'purple'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }


    }
}
