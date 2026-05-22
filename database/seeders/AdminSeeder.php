<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin AturAtur',
            'email' => 'admin@aturatur.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'is_verified' => true,
            'is_active' => true,
        ]);
    }
}
