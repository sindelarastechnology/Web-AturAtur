@extends('layouts.landing')

@section('title', 'Pilih Tema')

@section('styles')
<style>
    .filter-bar {
        display: flex; justify-content: center; gap: 0.5rem; margin-bottom: 2.5rem; flex-wrap: wrap;
    }
    .filter-btn {
        padding: 0.45rem 1.25rem; border: 2px solid #e5e7eb; border-radius: 50px;
        background: white; color: #666; font-size: 0.82rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s; font-family: 'Poppins', sans-serif;
    }
    .filter-btn:hover { border-color: #D4447C; color: #D4447C; }
    .filter-btn.active { background: #8B1A4A; color: white; border-color: #8B1A4A; }

    .themes-grid {
        display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; padding-bottom: 3rem;
    }
    @media (max-width: 900px) { .themes-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 550px) { .themes-grid { grid-template-columns: 1fr; } }

    .theme-card {
        background: white; border-radius: 1rem; overflow: hidden;
        box-shadow: 0 2px 15px rgba(0,0,0,0.06); transition: transform 0.3s, opacity 0.3s;
    }
    .theme-card:hover { transform: translateY(-5px); }
    .theme-card.hidden { display: none; }

    .theme-preview {
        height: 220px; display: flex; align-items: center; justify-content: center;
        font-family: 'Playfair Display', serif; color: white; font-size: 1.2rem;
        text-align: center; padding: 1rem; position: relative;
    }
    .theme-card .body { padding: 1.25rem; }
    .theme-card .body h3 { font-family: 'Playfair Display', serif; font-size: 1.1rem; margin-bottom: 0.6rem; color: #1a1a2e; }
    .theme-card .body .badge {
        display: inline-block; padding: 0.2rem 0.75rem; border-radius: 20px;
        font-size: 0.72rem; font-weight: 600; margin-bottom: 0.75rem;
    }
    .badge-free { background: #ecfdf5; color: #065f46; }
    .badge-premium { background: #fef3c7; color: #92400e; }
    .theme-card .body .palette { font-size: 0.8rem; color: #888; margin-bottom: 0.75rem; }
    .theme-card .body .actions { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    .theme-card .body .actions a {
        padding: 0.45rem 1.1rem; border-radius: 50px; font-size: 0.8rem;
        font-weight: 600; text-decoration: none; transition: all 0.2s;
    }
    .btn-demo {
        border: 1.5px solid #8B1A4A; color: #8B1A4A; background: transparent;
    }
    .btn-demo:hover { background: #8B1A4A; color: white; }
    .btn-pilih {
        background: #D4447C; color: white; border: 1.5px solid #D4447C;
    }
    .btn-pilih:hover { opacity: 0.85; }

    .cta-custom {
        background: #f5f3ef; border-radius: 1rem; padding: 2.5rem; text-align: center;
        margin-bottom: 2rem;
    }
    .cta-custom p { font-size: 0.95rem; color: #666; margin-bottom: 1rem; }
    .cta-custom a {
        display: inline-block; padding: 0.75rem 2rem; background: #8B1A4A;
        color: white; border-radius: 50px; text-decoration: none; font-weight: 700;
        font-size: 0.95rem; transition: opacity 0.2s;
    }
    .cta-custom a:hover { opacity: 0.9; }

    .empty-state { grid-column: 1/-1; text-align: center; color: #aaa; padding: 3rem; }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Pilih Tema Undanganmu</h1>
        <p>Semua tema responsif dan siap pakai</p>
    </div>

    <div class="container">
        <div class="filter-bar" id="filterBar">
            <button class="filter-btn active" data-filter="all" onclick="filterThemes('all', this)">Semua</button>
            <button class="filter-btn" data-filter="free" onclick="filterThemes('free', this)">Basic</button>
            <button class="filter-btn" data-filter="premium" onclick="filterThemes('premium', this)">Premium</button>
            @foreach ($categories as $cat)
            <button class="filter-btn" data-filter="{{ $cat }}" onclick="filterThemes('{{ $cat }}', this)">{{ ucfirst($cat) }}</button>
            @endforeach
        </div>

        <div class="themes-grid" id="themesGrid">
            @forelse ($themes as $theme)
                @php
                    $gradients = [
                        'linear-gradient(135deg, #8B1A4A, #D4447C)',
                        'linear-gradient(135deg, #2d5016, #5a8f3c)',
                        'linear-gradient(135deg, #1a365d, #2b6cb0)',
                        'linear-gradient(135deg, #744210, #b7791f)',
                        'linear-gradient(135deg, #1a1a2e, #4a4a6a)',
                        'linear-gradient(135deg, #702459, #b34a8a)',
                    ];
                    $bg = $theme->preview_image
                        ? 'url(' . asset($theme->preview_image) . ') center/cover no-repeat'
                        : $gradients[$loop->index % count($gradients)];
                    $waPilih = 'https://wa.me/' . config('app.wa_number') . '?text=Halo%20AturAtur%2C%20saya%20tertarik%20dengan%20tema%20' . urlencode($theme->name) . '.%20Boleh%20info%20paket%20dan%20harganya%3F';
                @endphp
                <div class="theme-card" data-premium="{{ $theme->is_premium ? 'true' : 'false' }}" data-category="{{ $theme->category ?? '' }}">
                    <div class="theme-preview" style="background: {{ $bg }};">
                        {{ $theme->name }}
                    </div>
                    <div class="body">
                        <h3>{{ $theme->name }}</h3>
                        <div style="display:flex;gap:0.35rem;flex-wrap:wrap;margin-bottom:0.5rem;">
                            <span class="badge {{ $theme->is_premium ? 'badge-premium' : 'badge-free' }}">
                                {{ $theme->is_premium ? 'Premium' : 'Basic' }}
                            </span>
                            @if ($theme->category)
                            <span class="badge" style="background:#eff6ff;color:#1e40af;">{{ $theme->category }}</span>
                            @endif
                        </div>
                        @if ($theme->color_palette)
                            <div class="palette">{{ $theme->color_palette }}</div>
                        @endif
                        @if ($theme->description)
                            <div style="font-size:0.8rem;color:#888;margin-bottom:0.75rem;">{{ $theme->description }}</div>
                        @endif
                        <div class="actions">
                            <a href="{{ url('/tema/' . $theme->slug) }}" class="btn-demo">Lihat Demo</a>
                            <a href="{{ $waPilih }}" target="_blank" class="btn-pilih">Pilih Tema</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="empty-state">Belum ada tema tersedia.</p>
            @endforelse
        </div>

        <div class="cta-custom">
            <p>Tema yang kamu cari belum ada? Hubungi kami untuk request tema custom.</p>
            <a href="https://wa.me/{{ config('app.wa_number') }}?text=Halo%20AturAtur%2C%20saya%20mau%20request%20tema%20custom%20untuk%20undangan%20saya" target="_blank">Hubungi via WhatsApp</a>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function filterThemes(filter, btn) {
        document.querySelectorAll('.filter-btn').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');

        document.querySelectorAll('.theme-card').forEach(function(card) {
            if (filter === 'all') {
                card.classList.remove('hidden');
            } else if (filter === 'free') {
                card.classList.toggle('hidden', card.getAttribute('data-premium') === 'true');
            } else if (filter === 'premium') {
                card.classList.toggle('hidden', card.getAttribute('data-premium') !== 'true');
            } else {
                var cat = card.getAttribute('data-category');
                card.classList.toggle('hidden', cat !== filter);
            }
        });
    }
</script>
@endsection
