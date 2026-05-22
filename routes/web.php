<?php

use App\Http\Controllers\InvitationPublicController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index']);
Route::get('/tema', [LandingController::class, 'themes']);
Route::get('/tema/{slug}', [LandingController::class, 'themeDemo']);
Route::get('/cara-kerja', [LandingController::class, 'howItWorks']);

Route::get('/guests/export/{invitation}', function (App\Models\Invitation $invitation) {
    $guests = $invitation->guests()->with('gift')->orderBy('created_at')->get();
    $csv = "Nama,Telepon,Grup,RSVP,Jumlah Tamu,Hadiah Type,Hadiah Jumlah,Hadiah Keterangan\n";
    foreach ($guests as $g) {
        $row = [
            '"' . str_replace('"', '""', $g->name) . '"',
            $g->phone ?? '',
            $g->group_label ?? '',
            $g->rsvp_status ?? 'pending',
            $g->guest_count ?? 1,
            $g->gift?->type ?? '',
            $g->gift?->amount ?? '',
            '"' . str_replace('"', '""', $g->gift?->description ?? '') . '"',
        ];
        $csv .= implode(',', $row) . "\n";
    }
    return response()->streamDownload(function () use ($csv) { echo $csv; }, 'tamu-' . now()->format('Ymd') . '.csv', ['Content-Type' => 'text/csv']);
})->middleware('auth')->name('guests.export');

Route::post('/rsvp/{guest}', [InvitationPublicController::class, 'rsvp'])->middleware('throttle:5,1');
Route::post('/wishes/{invitation}', [InvitationPublicController::class, 'storeWish'])->middleware('throttle:3,1');

Route::get('/calendar/{slug}/{event}', [InvitationPublicController::class, 'downloadCalendar'])->name('calendar.download');

Route::get('/{slug}/{guestSlug?}', [InvitationPublicController::class, 'show'])
    ->middleware('track.view')
    ->where('slug', '[a-zA-Z0-9\-]+')
    ->where('guestSlug', '[a-zA-Z0-9\-]+');
