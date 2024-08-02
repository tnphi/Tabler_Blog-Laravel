<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PivotBlogTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pivot_blog_tag')->insert([
            [
                'blog_id' => 1,
                'tag_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_id' => 1,
                'tag_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'blog_id' => 2,
                'tag_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
