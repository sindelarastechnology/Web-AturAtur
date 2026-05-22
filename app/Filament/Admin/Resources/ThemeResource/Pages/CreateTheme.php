<?php

namespace App\Filament\Admin\Resources\ThemeResource\Pages;

use App\Filament\Admin\Resources\ThemeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\File;

class CreateTheme extends CreateRecord
{
    protected static string $resource = ThemeResource::class;

    protected function afterCreate(): void
    {
        $record = $this->record;
        $themeDir = resource_path("views/themes/{$record->slug}");

        if (File::exists($themeDir)) {
            return;
        }

        File::makeDirectory($themeDir, 0755, true);

        $stub = <<<'BLADE'
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $invitation->title }} - AturAtur</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
html { scroll-behavior: smooth; }
body { font-family: 'Inter', 'Segoe UI', sans-serif; color: #2d2d2d; background: #fcf8f7; line-height: 1.6; overflow-x: hidden; }
.serif { font-family: 'Playfair Display', Georgia, serif; }
.container { max-width: 800px; margin: 0 auto; padding: 0 1.5rem; position: relative; z-index: 1; }
img { max-width: 100%; height: auto; display: block; }
section { padding: 5rem 0; position: relative; }
.section-bg-alt { background: linear-gradient(180deg, #fcf8f7 0%, #f8f0ed 100%); }
.section-title { font-family: 'Playfair Display', Georgia, serif; font-size: 2rem; color: #b76e79; text-align: center; margin-bottom: 0.5rem; font-weight: 600; letter-spacing: 0.5px; }
.section-subtitle { text-align: center; font-size: 0.8rem; color: #c9a0a6; letter-spacing: 4px; text-transform: uppercase; margin-bottom: 2.5rem; font-weight: 500; }
.divider { width: 50px; height: 2px; background: linear-gradient(90deg, #b76e79, #d4a0a8); margin: 1rem auto 2.5rem; border-radius: 2px; }
.animate-fade { opacity: 0; transform: translateY(30px); transition: opacity 0.8s ease, transform 0.8s ease; }
.animate-fade.visible { opacity: 1; transform: translateY(0); }
</style>
</head>
<body>
<div class="container" style="min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:3rem 1.5rem;">
    <div class="animate-fade visible serif" style="font-size:1rem;color:#c9a0a6;letter-spacing:4px;text-transform:uppercase;margin-bottom:1rem;">The Wedding of</div>
    <h1 class="animate-fade visible serif" style="font-size:2.5rem;color:#2d2d2d;margin-bottom:0.5rem;">
        {{ $invitation->groom_name ?? 'Mempelai Pria' }} & {{ $invitation->bride_name ?? 'Mempelai Wanita' }}
    </h1>
    <div class="animate-fade visible divider" style="margin:1.5rem auto;"></div>
    <p class="animate-fade visible" style="font-size:1rem;color:#888;margin-bottom:2rem;">
        Kepada Yth. Bapak/Ibu/Saudara/i <strong>{{ $guestName }}</strong>
    </p>
    @if ($invitation->opening_quote)
    <div class="animate-fade visible" style="max-width:600px;font-style:italic;color:#b76e79;font-size:1.1rem;line-height:1.8;font-family:'Playfair Display',serif;margin-bottom:3rem;">
        {{ $invitation->opening_quote }}
    </div>
    @endif
    @if ($invitation->events->count())
        @foreach ($invitation->events as $event)
        <div class="animate-fade visible" style="margin-bottom:2rem;">
            <h3 style="font-family:'Playfair Display',serif;font-size:1.3rem;color:#2d2d2d;margin-bottom:0.3rem;">{{ $event->title }}</h3>
            @if ($event->date) <p style="color:#b76e79;font-weight:600;">{{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}</p> @endif
            @if ($event->time_start) <p style="color:#888;">{{ $event->time_start }} - {{ $event->time_end ?? 'Selesai' }}</p> @endif
            @if ($event->venue_name) <p style="color:#888;">{{ $event->venue_name }}</p> @endif
        </div>
        @endforeach
    @endif
    <div class="animate-fade visible" style="margin-top:2rem;">
        <p style="color:#888;font-size:0.9rem;">Merupakan suatu kehormatan apabila Bapak/Ibu/Saudara/i berkenan hadir.</p>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var els = document.querySelectorAll('.animate-fade');
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(e) { if (e.isIntersecting) { e.target.classList.add('visible'); } });
    }, { threshold: 0.1 });
    els.forEach(function(el) { observer.observe(el); });
});
</script>
</body>
</html>
BLADE;

        File::put($themeDir . '/show.blade.php', $stub);
    }
}
