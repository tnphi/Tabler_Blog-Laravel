<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PivotBlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pivot_blog_category')->insert([
            [
                'blog_id' => 1,
                'category_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_id' => 1,
                'category_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_id' => 2,
                'category_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
