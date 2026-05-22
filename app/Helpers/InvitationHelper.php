<?php

use App\Models\Guest;
use App\Models\Invitation;
use Carbon\Carbon;

if (!function_exists('generateGuestLink')) {
    function generateGuestLink(Invitation $invitation, Guest $guest): string
    {
        return config('app.url') . '/' . $invitation->slug . '/' . $guest->slug;
    }
}

if (!function_exists('generateWaMessage')) {
    function generateWaMessage(string $guestName, Invitation $invitation, ?string $guestSlug = null): string
    {
        $groom = $invitation->groom_nickname ?? $invitation->groom_name ?? 'Pengantin Pria';
        $bride = $invitation->bride_nickname ?? $invitation->bride_name ?? 'Pengantin Wanita';
        $baseLink = $invitation->slug
            ? config('app.url') . '/' . $invitation->slug
            : config('app.url');
        $link = $guestSlug ? $baseLink . '/' . $guestSlug : $baseLink;

        return "Assalamu'alaikum {$guestName}, kami mengundang Anda ke pernikahan {$groom} & {$bride}. Berikut undangan digitalnya: {$link}";
    }
}

if (!function_exists('formatDateIndonesia')) {
    function formatDateIndonesia(Carbon $date): string
    {
        $hari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
        ];
        $bulan = [
            'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
            'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
            'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
            'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
        ];

        $namaHari = $hari[$date->format('l')];
        $namaBulan = $bulan[$date->format('F')];

        return "{$namaHari}, {$date->format('j')} {$namaBulan} {$date->format('Y')}";
    }
}
