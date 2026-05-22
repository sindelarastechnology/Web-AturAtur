<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Theme;
use Illuminate\Database\Seeder;

class PackageThemeSeeder extends Seeder
{
    public function run(): void
    {
        $packages = Package::pluck('id', 'slug');
        $themes = Theme::pluck('id', 'slug');

        $basic = $packages['basic'];
        $premium = $packages['premium'];
        $ultimate = $packages['ultimate'];

        $elegantWhite = $themes['elegant-white'];
        $rusticGarden = $themes['rustic-garden'];
        $modernMinimalist = $themes['modern-minimalist'];

        Package::find($basic)->themes()->sync([$elegantWhite]);
        Package::find($premium)->themes()->sync([$rusticGarden, $modernMinimalist]);
        Package::find($ultimate)->themes()->sync([$elegantWhite, $rusticGarden, $modernMinimalist]);
    }
}
