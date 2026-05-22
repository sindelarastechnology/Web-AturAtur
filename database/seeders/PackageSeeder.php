<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        Package::updateOrCreate(['slug' => 'basic'], [
            'name' => 'Basic',
            'max_photos' => 0,
            'max_guests' => 50,
            'duration_days' => -1,
            'price_display' => 'Rp75.000',
            'features' => [
                'RSVP Online',
                'Ucapan & Doa',
                'Daftar Tamu',
                'Musik Latar',
                'Aktif Selamanya',
            ],
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Package::updateOrCreate(['slug' => 'premium'], [
            'name' => 'Premium',
            'max_photos' => 10,
            'max_guests' => -1,
            'duration_days' => -1,
            'price_display' => 'Rp150.000',
            'features' => [
                '10 Foto Galeri',
                'Tamu Unlimited',
                'RSVP Online',
                'Ucapan & Doa',
                'Link Per Tamu',
                'Musik Latar',
                'Aktif Selamanya',
            ],
            'is_active' => true,
            'sort_order' => 2,
        ]);

        Package::updateOrCreate(['slug' => 'ultimate'], [
            'name' => 'Ultimate',
            'max_photos' => -1,
            'max_guests' => -1,
            'duration_days' => -1,
            'price_display' => 'Rp250.000',
            'features' => [
                'Foto Unlimited',
                'Tamu Unlimited',
                'RSVP Online',
                'Ucapan & Doa',
                'Link Per Tamu',
                'Musik Latar',
                'Aktif Selamanya',
                'Semua Tema Premium',
                'Support Prioritas',
            ],
            'is_active' => true,
            'sort_order' => 3,
        ]);
    }
}
