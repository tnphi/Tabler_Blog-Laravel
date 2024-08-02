<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        BlogCategory::insert([
            [
                'name' => 'Technology',
                'status' => 1,
                'parent_id' => 0,
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Programming',
                'status' => 1,
                'parent_id' => 1, // Assuming 'Technology' has ID 1
                'level' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Lifestyle',
                'status' => 1,
                'parent_id' => 0,
                'level' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Health',
                'status' => 1,
                'parent_id' => 3, // Assuming 'Lifestyle' has ID 3
                'level' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
