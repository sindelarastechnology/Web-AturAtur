@extends('layouts.landing')

@section('title', $theme->name . ' - Preview Tema')

@section('styles')
<style>
    .demo-container {
        max-width: 720px;
        margin: 0 auto;
        padding: 2rem 1.5rem 4rem;
    }
    .demo-preview-img {
        width: 100%;
        border-radius: 1rem;
        box-shadow: 0 4px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
        aspect-ratio: 16 / 9;
        object-fit: cover;
        background: #f0f0f0;
    }
    .demo-preview-fallback {
        width: 100%;
        border-radius: 1rem;
        aspect-ratio: 16 / 9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        color: white;
        text-align: center;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .demo-meta {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }
    .demo-badge {
        padding: 0.3rem 0.9rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .demo-badge-free { background: #ecfdf5; color: #065f46; }
    .demo-badge-premium { background: #fef3c7; color: #92400e; }
    .demo-badge-cat { background: #eff6ff; color: #1e40af; }
    .demo-name {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: #1a1a2e;
        margin-bottom: 0.75rem;
    }
    .demo-palette {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 1rem;
    }
    .demo-desc {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.7;
        margin-bottom: 2rem;
    }
    .demo-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .demo-actions .btn {
        padding: 0.7rem 2rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .demo-actions .btn-primary {
        background: #D4447C;
        color: white;
        border: 1.5px solid #D4447C;
    }
    .demo-actions .btn-primary:hover { opacity: 0.85; }
    .demo-actions .btn-secondary {
        border: 1.5px solid #8B1A4A;
        color: #8B1A4A;
        background: transparent;
    }
    .demo-actions .btn-secondary:hover { background: #8B1A4A; color: white; }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>{{ $theme->name }}</h1>
        <p>Preview tema undangan digital</p>
    </div>

    <div class="container">
        <div class="demo-container">
            @php
                $gradients = [
                    'linear-gradient(135deg, #8B1A4A, #D4447C)',
                    'linear-gradient(135deg, #2d5016, #5a8f3c)',
                    'linear-gradient(135deg, #1a365d, #2b6cb0)',
                    'linear-gradient(135deg, #744210, #b7791f)',
                    'linear-gradient(135deg, #1a1a2e, #4a4a6a)',
                    'linear-gradient(135deg, #702459, #b34a8a)',
                ];
                $fallbackGradient = $gradients[crc32($theme->slug) % count($gradients)];
            @endphp

            @if ($theme->preview_image)
                <img src="{{ asset($theme->preview_image) }}" alt="{{ $theme->name }}" class="demo-preview-img">
            @else
                <div class="demo-preview-fallback" style="background: {{ $fallbackGradient }};">
                    {{ $theme->name }}
                </div>
            @endif

            <div class="demo-meta">
                <span class="demo-badge {{ $theme->is_premium ? 'demo-badge-premium' : 'demo-badge-free' }}">
                    {{ $theme->is_premium ? 'Premium' : 'Basic' }}
                </span>
                @if ($theme->category)
                    <span class="demo-badge demo-badge-cat">{{ $theme->category }}</span>
                @endif
            </div>

            <h2 class="demo-name">{{ $theme->name }}</h2>

            @if ($theme->color_palette)
                <div class="demo-palette">{{ $theme->color_palette }}</div>
            @endif

            @if ($theme->description)
                <div class="demo-desc">{{ $theme->description }}</div>
            @endif

            <div class="demo-actions">
                <a href="{{ $waPilih }}" target="_blank" class="btn btn-primary">Pilih Tema</a>
                <a href="/tema" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection
