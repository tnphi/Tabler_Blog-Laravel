<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'easyname', // Tên dễ nhớ
            'phone' => '123456789',
            'address' => '123 Main St',
            'role' => '1',
            'email' => 'easyname@example.com',
            'password' => Hash::make('password'), // Mật khẩu dễ nhớ
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
