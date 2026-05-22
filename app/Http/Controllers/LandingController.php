<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Package;
use App\Models\Theme;
use App\Models\User;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $themes = Theme::where('is_active', 1)->orderBy('sort_order')->get();
        $packages = Package::where('is_active', 1)->orderBy('sort_order')->get();
        $waNumber = config('app.wa_number');
        $totalClients = User::where('role', 'client')->count();
        $totalInvitations = Invitation::count();

        return view('landing.index', compact('themes', 'packages', 'waNumber', 'totalClients', 'totalInvitations'));
    }

    public function themes(): View
    {
        $themes = Theme::where('is_active', 1)->orderBy('sort_order')->get();
        $categories = Theme::where('is_active', 1)->whereNotNull('category')->distinct()->pluck('category')->sort()->values();
        $waNumber = config('app.wa_number');

        return view('landing.themes', compact('themes', 'categories', 'waNumber'));
    }

    public function howItWorks(): View
    {
        $waNumber = config('app.wa_number');

        return view('landing.how-it-works', compact('waNumber'));
    }

    public function themeDemo(string $slug): View
    {
        $theme = Theme::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        $waPilih = 'https://wa.me/' . config('app.wa_number') . '?text=Halo%20AturAtur%2C%20saya%20tertarik%20dengan%20tema%20' . urlencode($theme->name) . '.%20Boleh%20info%20paket%20dan%20harganya%3F';

        return view('landing.theme-demo', compact('theme', 'waPilih'));
    }
}
