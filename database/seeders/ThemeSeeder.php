<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        Theme::create([
            'name' => 'Elegant White',
            'slug' => 'elegant-white',
            'color_palette' => 'putih, emas',
            'is_premium' => false,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Theme::create([
            'name' => 'Rustic Garden',
            'slug' => 'rustic-garden',
            'color_palette' => 'hijau sage, cokelat',
            'is_premium' => false,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Theme::create([
            'name' => 'Modern Minimalist',
            'slug' => 'modern-minimalist',
            'color_palette' => 'hitam, putih',
            'is_premium' => true,
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
