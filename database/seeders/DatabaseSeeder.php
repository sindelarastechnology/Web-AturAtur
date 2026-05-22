<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PackageSeeder::class,
            ThemeSeeder::class,
            PackageThemeSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
