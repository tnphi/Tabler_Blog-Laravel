<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlogTag; 

class BlogTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        BlogTag::insert([
            [
                'name' => 'Laravel',
                'status' => 1,
                'description' => 'All about Laravel framework',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'PHP',
                'status' => 1,
                'description' => 'General PHP programming',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'JavaScript',
                'status' => 1,
                'description' => 'JavaScript language and frameworks',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'CSS',
                'status' => 0,
                'description' => 'Cascading Style Sheets',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
