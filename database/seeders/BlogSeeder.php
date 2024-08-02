<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::insert([
            [
                'title' => 'First Blog Post',
                'content' => 'Content of the first blog post.',
                'isFeatured' => true,
                'short_description' => 'Short description of the first blog post.',
                'featured_image' => 'image1.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Second Blog Post',
                'content' => 'Content of the second blog post.',
                'isFeatured' => false,
                'short_description' => 'Short description of the second blog post.',
                'featured_image' => 'image2.jpg',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
