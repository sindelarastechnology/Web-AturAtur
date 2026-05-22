@extends('layouts.landing')

@section('title', 'Cara Kerja')

@section('styles')
<style>
    .steps { display: flex; flex-direction: column; gap: 2rem; max-width: 700px; margin: 0 auto 4rem; }
    .step { display: flex; gap: 1.5rem; align-items: flex-start; background: white; border-radius: 1rem; padding: 1.75rem; box-shadow: 0 2px 15px rgba(0,0,0,0.04); }
    .step-num { width: 56px; height: 56px; min-width: 56px; background: linear-gradient(135deg, #8B1A4A, #D4447C); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem; }
    .step-content h3 { font-family: 'Playfair Display', serif; font-size: 1.1rem; margin-bottom: 0.35rem; color: #1a1a2e; }
    .step-content p { font-size: 0.88rem; color: #888; line-height: 1.6; }

    .cta-section { background: #f5f3ef; text-align: center; padding: 4rem 1.5rem; margin-bottom: 0; }
    .cta-section h2 { font-family: 'Playfair Display', serif; font-size: clamp(1.3rem, 2.5vw, 1.8rem); color: #1a1a2e; margin-bottom: 0.75rem; }
    .cta-section p { color: #888; font-size: 0.95rem; margin-bottom: 1.5rem; }
    .cta-section .btn-cta { display: inline-block; padding: 0.85rem 2.25rem; background: #8B1A4A; color: white; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 1rem; transition: opacity 0.2s; }
    .cta-section .btn-cta:hover { opacity: 0.9; }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Cara Kerja</h1>
        <p>Buat undangan digital impianmu hanya dalam 4 langkah mudah</p>
    </div>

    <div class="container">
        <div class="steps">
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-content">
                    <h3>Pilih Tema & Paket</h3>
                    <p>Jelajahi berbagai tema undangan yang tersedia. Setiap tema dirancang dengan gaya yang elegan dan bisa disesuaikan. Pilih paket Basic atau Premium sesuai kebutuhanmu.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-content">
                    <h3>Order via WhatsApp</h3>
                    <p>Hubungi kami melalui WhatsApp untuk melakukan pemesanan. Tim kami akan menyiapkan akun dan undanganmu dalam waktu kurang dari 1 jam. Pembayaran bisa via transfer bank atau QRIS.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-content">
                    <h3>Isi Data Sendiri</h3>
                    <p>Setelah akun aktif, login ke dashboard untuk mengisi data pengantin, upload foto-foto favorit, atur acara, dan tambahkan daftar tamu. Semua bisa kamu lakukan sendiri dengan mudah.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num">4</div>
                <div class="step-content">
                    <h3>Bagikan ke Tamu</h3>
                    <p>Setelah undangan siap, setiap tamu akan mendapatkan link personal dengan sapaan nama mereka sendiri. Kamu bisa salin link dan kirimkan ke masing-masing tamu via WhatsApp.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="cta-section">
        <div class="container">
            <h2>Siap memulai?</h2>
            <p>Hubungi kami sekarang dan buat undangan digital impianmu</p>
            <a href="https://wa.me/{{ config('app.wa_number') }}?text=Halo%20AturAtur%2C%20saya%20mau%20pesan%20undangan%20digital" target="_blank" class="btn-cta">Pesan Sekarang via WhatsApp</a>
        </div>
    </div>
@endsection
