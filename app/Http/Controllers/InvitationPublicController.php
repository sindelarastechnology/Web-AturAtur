<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invitation;
use App\Models\Wish;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvitationPublicController extends Controller
{
    public function show(Request $request, string $slug, ?string $guestSlug = null): View
    {
        $invitation = Invitation::where('slug', $slug)
            ->where('is_active', 1)
            ->with([
                'theme',
                'events' => fn($q) => $q->orderBy('date')->orderBy('time_start'),
                'photos' => fn($q) => $q->where('type', 'gallery')->orderBy('sort_order'),
                'wishes' => fn($q) => $q->where('is_approved', 1)->latest()->limit(20),
            ])
            ->firstOrFail();

        $guest = null;

        if ($guestSlug) {
            $guest = Guest::where('invitation_id', $invitation->id)
                ->where('slug', $guestSlug)
                ->first();
        }

        // Also check ?to= query param for backward compatibility
        if (!$guest && $request->query('to')) {
            $guest = Guest::where('invitation_id', $invitation->id)
                ->where('slug', $request->query('to'))
                ->first();
            $guestSlug = $guest?->slug;
        }

        $guestName = $guest?->name
            ?? ($guestSlug ? Str::title(str_replace('-', ' ', $guestSlug)) : 'Tamu Undangan');

        // Fail-safe: fallback to first available theme if assigned theme not found
        $themeSlug = $invitation->theme?->slug;
        $viewPath = "themes.{$themeSlug}.show";
        if (!$themeSlug || !ViewFacade::exists($viewPath)) {
            $fallback = \App\Models\Theme::where('is_active', 1)->first();
            $themeSlug = $fallback?->slug ?? 'elegant-white';
            $viewPath = "themes.{$themeSlug}.show";

            if (!ViewFacade::exists($viewPath)) {
                $viewPath = 'themes.elegant-white.show';
            }
        }

        try {
            return view($viewPath, compact('invitation', 'guestName', 'guest'));
        } catch (\Exception $e) {
            Log::error('Gagal render undangan: ' . $e->getMessage(), [
                'slug' => $slug,
                'guest' => $guestSlug,
                'theme' => $themeSlug,
                'invitation_id' => $invitation->id,
            ]);

            $viewPath = 'themes.elegant-white.show';
            return view($viewPath, compact('invitation', 'guestName', 'guest'));
        }
    }

    public function rsvp(Request $request, Guest $guest): RedirectResponse
    {
        $invitation = $guest->invitation;
        $firstEvent = $invitation?->events()->orderBy('date')->first();

        if ($firstEvent && $firstEvent->date->isPast()) {
            return back()->with('error', 'Maaf, batas waktu konfirmasi kehadiran sudah lewat.');
        }

        $data = $request->validate([
            'rsvp_status' => 'required|in:hadir,tidak_hadir,mungkin',
            'guest_count' => 'required|integer|min:1|max:10',
        ]);

        $guest->update([
            'rsvp_status' => $data['rsvp_status'],
            'guest_count' => $data['guest_count'],
            'rsvp_at' => now(),
        ]);

        return back()->with('success', 'Konfirmasi kehadiran berhasil dikirim. Terima kasih!');
    }

    public function storeWish(Request $request, Invitation $invitation): RedirectResponse
    {
        $data = $request->validate([
            'sender_name' => 'required|max:150',
            'message' => 'required|max:2000',
        ]);

        Wish::create([
            'invitation_id' => $invitation->id,
            'sender_name' => strip_tags($data['sender_name']),
            'message' => strip_tags($data['message']),
            'is_approved' => false,
        ]);

        return back()->with('success', 'Ucapan berhasil dikirim dan akan ditampilkan setelah disetujui.');
    }

    public function downloadCalendar(string $slug, Event $event)
    {
        $invitation = Invitation::where('slug', $slug)->where('is_active', 1)->firstOrFail();

        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//AturAtur//Undangan//ID\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "DTSTART:" . $event->date->format('Ymd') . 'T' . str_replace(':', '', $event->time_start) . "00\r\n";
        if ($event->time_end) {
            $ics .= "DTEND:" . $event->date->format('Ymd') . 'T' . str_replace(':', '', $event->time_end) . "00\r\n";
        }
        $ics .= "SUMMARY:" . addcslashes($event->title, "\\,\;") . "\r\n";
        $ics .= "DESCRIPTION:" . addcslashes("Pernikahan {$invitation->groom_name} & {$invitation->bride_name}", "\\,\;") . "\r\n";
        if ($event->venue_name) {
            $ics .= "LOCATION:" . addcslashes($event->venue_name, "\\,\;") . "\r\n";
        }
        $ics .= "END:VEVENT\r\n";
        $ics .= "END:VCALENDAR\r\n";

        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="undangan-' . $event->id . '.ics"',
        ]);
    }
}
