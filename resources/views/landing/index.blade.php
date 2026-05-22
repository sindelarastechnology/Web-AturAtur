<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AturAtur - Undangan Digital Pernikahan Elegan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background: #FAFAFA;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .text-maroon {
            color: #8B1A4A;
        }

        .text-pink {
            color: #D4447C;
        }

        .text-gold {
            color: #C9A84C;
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s;
        }

        .navbar.scrolled {
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        }

        .navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 70px;
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 800;
            color: #8B1A4A;
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .nav-logo span {
            color: #D4447C;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .nav-menu a {
            text-decoration: none;
            color: #555;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
            position: relative;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: #8B1A4A;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .nav-actions .btn-outline {
            padding: 0.45rem 1.25rem;
            border: 1.5px solid #8B1A4A;
            border-radius: 50px;
            color: #8B1A4A;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .nav-actions .btn-outline:hover {
            background: #8B1A4A;
            color: white;
        }

        .nav-actions .btn-primary {
            padding: 0.45rem 1.25rem;
            background: #8B1A4A;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .nav-actions .btn-primary:hover {
            opacity: 0.9;
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 4px;
        }

        .hamburger span {
            width: 24px;
            height: 2px;
            background: #8B1A4A;
            transition: all 0.3s;
            border-radius: 2px;
        }

        section {
            padding: 5rem 0;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.6rem, 3.5vw, 2.4rem);
            text-align: center;
            margin-bottom: 0.75rem;
            color: #1a1a2e;
        }

        .section-subtitle {
            text-align: center;
            color: #888;
            font-size: 0.95rem;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        #hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding-top: 70px;
            background: linear-gradient(135deg, #FAFAFA 0%, #fdf2f8 50%, #FAFAFA 100%);
            position: relative;
            overflow: hidden;
        }

        #hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(212, 68, 124, 0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        #hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(139, 26, 74, 0.06) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.2rem);
            color: #1a1a2e;
            line-height: 1.2;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero-title em {
            color: #D4447C;
            font-style: normal;
        }

        .hero-sub {
            font-size: clamp(0.95rem, 1.2vw, 1.1rem);
            color: #777;
            line-height: 1.7;
            margin-bottom: 2rem;
            max-width: 580px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }

        .hero-buttons .btn-primary {
            padding: 0.9rem 2.5rem;
            background: #8B1A4A;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .hero-buttons .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 26, 74, 0.25);
        }

        .hero-buttons .btn-secondary {
            padding: 0.9rem 2.5rem;
            border: 2px solid #8B1A4A;
            color: #8B1A4A;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .hero-buttons .btn-secondary:hover {
            background: #8B1A4A;
            color: white;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
            flex-wrap: wrap;
        }

        .hero-stats .stat {
            text-align: center;
        }

        .hero-stats .stat .num {
            font-size: 1.5rem;
            font-weight: 700;
            color: #8B1A4A;
            display: block;
        }

        .hero-stats .stat .label {
            font-size: 0.8rem;
            color: #999;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 900px) {
            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .steps-grid {
                grid-template-columns: 1fr;
            }
        }

        .step-card {
            text-align: center;
            padding: 2rem 1.25rem;
            position: relative;
        }

        .step-num {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #8B1A4A, #D4447C);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .step-card h3 {
            font-size: 1.05rem;
            margin-bottom: 0.5rem;
            color: #1a1a2e;
        }

        .step-card p {
            font-size: 0.85rem;
            color: #888;
            line-height: 1.5;
        }

        .themes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 800px) {
            .themes-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .themes-grid {
                grid-template-columns: 1fr;
            }
        }

        .theme-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
            transition: transform 0.3s;
        }

        .theme-card:hover {
            transform: translateY(-5px);
        }

        .theme-preview {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            color: white;
            font-size: 1.3rem;
            position: relative;
        }

        .theme-card .body {
            padding: 1.25rem;
        }

        .theme-card .body h3 {
            font-size: 1.05rem;
            margin-bottom: 0.5rem;
        }

        .theme-card .body .badge {
            display: inline-block;
            padding: 0.2rem 0.75rem;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }

        .theme-card .body .badge-free {
            background: #ecfdf5;
            color: #065f46;
        }

        .theme-card .body .badge-premium {
            background: #fef3c7;
            color: #92400e;
        }

        .theme-card .body .btn-demo {
            display: inline-block;
            margin-top: 0.75rem;
            padding: 0.4rem 1.25rem;
            border: 1.5px solid #8B1A4A;
            color: #8B1A4A;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .theme-card .body .btn-demo:hover {
            background: #8B1A4A;
            color: white;
        }

        .themes-footer {
            text-align: center;
            margin-top: 2rem;
        }

        .themes-footer a {
            display: inline-block;
            color: #8B1A4A;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .themes-footer a:hover {
            text-decoration: underline;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 800px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        .feature-card {
            background: white;
            border-radius: 1rem;
            padding: 1.75rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .feature-card:hover {
            transform: translateY(-3px);
        }

        .feature-icon {
            font-size: 1.75rem;
            margin-bottom: 0.75rem;
            display: block;
        }

        .feature-card h3 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: #1a1a2e;
        }

        .feature-card p {
            font-size: 0.85rem;
            color: #888;
            line-height: 1.6;
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            max-width: 960px;
            margin: 0 auto;
        }

        @media (max-width: 900px) {
            .pricing-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .pricing-grid {
                grid-template-columns: 1fr;
            }
        }

        .pricing-card {
            background: white;
            border-radius: 1.25rem;
            padding: 2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.06);
            position: relative;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.04);
        }

        .pricing-card.featured {
            border: 2px solid #C9A84C;
            transform: scale(1.03);
        }

        .pricing-card.ultimate {
            border: 2px solid #8B1A4A;
            background: linear-gradient(180deg, #fff 0%, #fdf2f8 100%);
        }

        .pricing-badge {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #C9A84C, #e8c95a);
            color: white;
            padding: 0.3rem 1.25rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .pricing-badge.vip {
            background: linear-gradient(135deg, #8B1A4A, #D4447C);
        }

        .pricing-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
        }

        .pricing-price {
            font-size: 1.8rem;
            font-weight: 800;
            color: #8B1A4A;
            margin-bottom: 1rem;
        }

        .pricing-price span {
            font-size: 0.85rem;
            font-weight: 400;
            color: #999;
        }

        .pricing-features {
            list-style: none;
            text-align: left;
            margin-bottom: 1.25rem;
        }

        .pricing-features li {
            padding: 0.35rem 0;
            font-size: 0.85rem;
            color: #555;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .pricing-features li::before {
            content: '✓';
            color: #C9A84C;
            font-weight: 700;
        }

        .pricing-card .btn-order {
            display: block;
            padding: 0.75rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .pricing-card .btn-order.basic {
            background: #f5f0f2;
            color: #8B1A4A;
        }

        .pricing-card .btn-order.basic:hover {
            background: #8B1A4A;
            color: white;
        }

        .pricing-card .btn-order.premium {
            background: #8B1A4A;
            color: white;
        }

        .pricing-card .btn-order.premium:hover {
            opacity: 0.9;
        }

        .pricing-card .btn-order.ultimate {
            background: linear-gradient(135deg, #8B1A4A, #D4447C);
            color: white;
        }

        .pricing-card .btn-order.ultimate:hover {
            opacity: 0.9;
        }

        .pricing-note {
            text-align: center;
            font-size: 0.8rem;
            color: #aaa;
            margin-top: 1.5rem;
        }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 800px) {
            .testimonials-grid {
                grid-template-columns: 1fr;
            }
        }

        .testimonial-card {
            background: white;
            border-radius: 1rem;
            padding: 1.75rem;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.04);
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .testimonial-card::before {
            content: '"';
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            color: #C9A84C;
            position: absolute;
            top: 0.25rem;
            left: 1rem;
            line-height: 1;
            opacity: 0.3;
        }

        .testimonial-card p {
            font-size: 0.88rem;
            color: #666;
            line-height: 1.7;
            margin-bottom: 1rem;
            font-style: italic;
        }

        .testimonial-card .author {
            font-weight: 600;
            font-size: 0.85rem;
            color: #8B1A4A;
        }

        .testimonial-card .location {
            font-size: 0.78rem;
            color: #aaa;
        }

        #cta {
            background: #8B1A4A;
            text-align: center;
            padding: 5rem 1.5rem;
            position: relative;
            overflow: hidden;
        }

        #cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(212, 68, 124, 0.2) 0%, transparent 50%);
        }

        #cta .container {
            position: relative;
            z-index: 1;
        }

        #cta h2 {
            color: white;
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            margin-bottom: 0.75rem;
        }

        #cta p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        #cta .btn-cta {
            display: inline-block;
            padding: 1rem 2.5rem;
            background: white;
            color: #8B1A4A;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.05rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        #cta .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        footer {
            background: #1a1a2e;
            color: rgba(255, 255, 255, 0.6);
            padding: 3rem 0 2rem;
        }

        footer .container {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 700px) {
            footer .container {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 450px) {
            footer .container {
                grid-template-columns: 1fr;
            }
        }

        footer .brand .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 800;
            color: white;
            margin-bottom: 0.5rem;
            display: block;
        }

        footer .brand .logo span {
            color: #D4447C;
        }

        footer .brand p {
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }

        footer h4 {
            color: white;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        footer a {
            display: block;
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            transition: color 0.2s;
        }

        footer a:hover {
            color: white;
        }

        .footer-bottom {
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            margin-top: 2rem;
            padding-top: 1.5rem;
            font-size: 0.8rem;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 1.5rem;
                gap: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .nav-menu.open {
                display: flex;
            }

            .nav-actions .btn-outline,
            .nav-actions .btn-primary {
                font-size: 0.8rem;
                padding: 0.35rem 1rem;
            }

            .hamburger {
                display: flex;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="nav-logo">Atur<span>Atur</span></a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="/">Beranda</a></li>
                <li><a href="/tema">Tema</a></li>
                <li><a href="/cara-kerja">Cara Kerja</a></li>
                <li><a href="#harga">Harga</a></li>
            </ul>
            <div class="nav-actions">
                <a href="/dashboard/login" class="btn-outline">Login</a>
                <a href="https://wa.me/{{ $waNumber }}?text=Halo%20AturAtur%2C%20saya%20mau%20pesan%20undangan%20digital"
                    target="_blank" class="btn-primary">Pesan Sekarang</a>
                <button class="hamburger" id="hamburger" onclick="toggleMenu()" aria-label="Menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>

    <section id="hero">
        <div class="container hero-content">
            <h1 class="hero-title">Undangan Digital Elegan, <em>Siap Dibagikan</em> dalam Hitungan Menit</h1>
            <p class="hero-sub">Buat undangan pernikahan online yang cantik dan personal. Pesan via WhatsApp, langsung
                jadi.</p>
            <div class="hero-buttons">
                <a href="https://wa.me/{{ $waNumber }}?text=Halo%20AturAtur%2C%20saya%20mau%20pesan%20undangan%20digital"
                    target="_blank" class="btn-primary">Pesan Sekarang</a>
                <a href="/tema" class="btn-secondary">Lihat Contoh</a>
            </div>
            <div class="hero-stats">
                <div class="stat"><span class="num">{{ $totalClients > 0 ? $totalClients : '500' }}+</span><span class="label">Pasangan</span></div>
                <div class="stat"><span class="num">{{ $totalInvitations > 0 ? $totalInvitations * 25 : '10.000' }}+</span><span class="label">Tamu</span></div>
                <div class="stat"><span class="num">{{ $themes->count() }}+</span><span class="label">Tema</span></div>
            </div>
        </div>
    </section>

    <section id="cara-kerja" style="background:#f5f3ef;">
        <div class="container">
            <h2 class="section-title">Cara Kerja</h2>
            <p class="section-subtitle">Cukup 4 langkah mudah, undangan impianmu siap dibagikan</p>
            <div class="steps-grid">
                <div class="step-card fade-in">
                    <div class="step-num">1</div>
                    <h3>Pilih Tema & Paket</h3>
                    <p>Pilih tema favorit dan paket yang sesuai dengan kebutuhanmu.</p>
                </div>
                <div class="step-card fade-in">
                    <div class="step-num">2</div>
                    <h3>Order via WhatsApp</h3>
                    <p>Hubungi kami, kami siapkan akun dalam kurang dari 1 jam.</p>
                </div>
                <div class="step-card fade-in">
                    <div class="step-num">3</div>
                    <h3>Isi Data Sendiri</h3>
                    <p>Login dashboard, isi data pengantin dan upload foto sesukamu.</p>
                </div>
                <div class="step-card fade-in">
                    <div class="step-num">4</div>
                    <h3>Bagikan ke Tamu</h3>
                    <p>Salin link personal tiap tamu, kirim via WhatsApp langsung.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tema">
        <div class="container">
            <h2 class="section-title">Tema Pilihan</h2>
            <p class="section-subtitle">Pilih tema favoritmu, setiap tema bisa disesuaikan dengan warna dan gaya yang
                kamu mau</p>
            <div class="themes-grid">
                @foreach ($themes->take(3) as $theme)
                    <div class="theme-card fade-in">
                        @php
                            $colors = ['#e8d5c4', '#d4e8d8', '#d5dce8', '#f0e0e8', '#e0e0e0'];
                            $bg = $theme->color_palette
                                ? 'linear-gradient(135deg, #8B1A4A, #D4447C)'
                                : $colors[$loop->index % count($colors)];
                        @endphp
                        <div class="theme-preview" style="background: {{ $bg }};">
                            {{ $theme->name }}
                        </div>
                        <div class="body">
                            <h3>{{ $theme->name }}</h3>
                            <span class="badge {{ $theme->is_premium ? 'badge-premium' : 'badge-free' }}">
                                {{ $theme->is_premium ? 'Premium' : 'Basic' }}
                            </span>
                            <a href="/tema" class="btn-demo">Lihat Demo</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="themes-footer">
                <a href="/tema">Lihat Semua Tema &rarr;</a>
            </div>
        </div>
    </section>

    <section id="fitur" style="background:#f5f3ef;">
        <div class="container">
            <h2 class="section-title">Fitur Lengkap</h2>
            <p class="section-subtitle">Semua yang kamu butuhkan untuk undangan digital yang berkesan</p>
            <div class="features-grid">
                <div class="feature-card fade-in">
                    <span class="feature-icon">🔗</span>
                    <h3>Link Personal per Tamu</h3>
                    <p>Setiap tamu dapat link dengan sapaan namanya sendiri, membuat undangan terasa lebih spesial.</p>
                </div>
                <div class="feature-card fade-in">
                    <span class="feature-icon">📸</span>
                    <h3>Galeri Foto</h3>
                    <p>Upload hingga 10 foto prewedding favoritmu, tampil dalam galeri yang cantik.</p>
                </div>
                <div class="feature-card fade-in">
                    <span class="feature-icon">✉️</span>
                    <h3>RSVP Online</h3>
                    <p>Tamu konfirmasi kehadiran langsung dari halaman undangan, pantau siapa saja yang hadir.</p>
                </div>
                <div class="feature-card fade-in">
                    <span class="feature-icon">💬</span>
                    <h3>Ucapan & Doa</h3>
                    <p>Terima ucapan dari tamu secara real-time, kelola dan tampilkan yang terbaik.</p>
                </div>
                <div class="feature-card fade-in">
                    <span class="feature-icon">📅</span>
                    <h3>Info Acara Lengkap</h3>
                    <p>Akad, resepsi, lokasi, dan peta terintegrasi. Tamu tidak akan bingung.</p>
                </div>
                <div class="feature-card fade-in">
                    <span class="feature-icon">📱</span>
                    <h3>Mobile Friendly</h3>
                    <p>Tampil sempurna di semua perangkat, dari HP hingga laptop.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="harga">
        <div class="container">
            <h2 class="section-title">Pilihan Paket</h2>
            <p class="section-subtitle">Harga terjangkau untuk undangan digital impianmu</p>
            <div class="pricing-grid">
                @foreach ($packages as $package)
                    <div
                        class="pricing-card fade-in
                        {{ $package->slug === 'premium' ? 'featured' : '' }}
                        {{ $package->slug === 'ultimate' ? 'ultimate' : '' }}">
                        @if ($package->slug === 'premium')
                            <div class="pricing-badge">Terpopuler</div>
                        @elseif ($package->slug === 'ultimate')
                            <div class="pricing-badge vip">Terlengkap</div>
                        @endif
                        <h3>{{ $package->name }}</h3>
                        <div class="pricing-price">{{ $package->price_display }} <span>/sekali</span></div>
                        <ul class="pricing-features">
                            @if ($package->features)
                                @foreach ($package->features as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            @endif
                        </ul>
                        <a href="https://wa.me/{{ $waNumber }}?text=Halo%20AturAtur%2C%20saya%20mau%20pesan%20paket%20{{ urlencode($package->name) }}"
                            target="_blank"
                            class="btn-order
                            {{ $package->slug === 'premium' ? 'premium' : ($package->slug === 'ultimate' ? 'ultimate' : 'basic') }}">
                            Pesan {{ $package->name }}
                        </a>
                    </div>
                @endforeach
            </div>
            <p class="pricing-note">Pembayaran via Transfer Bank / QRIS. Konfirmasi via WhatsApp.</p>
        </div>
    </section>

    <section id="testimoni" style="background:#f5f3ef;">
        <div class="container">
            <h2 class="section-title">Kata Mereka</h2>
            <p class="section-subtitle">Apa kata pasangan yang sudah menggunakan AturAtur</p>
            <div class="testimonials-grid">
                <div class="testimonial-card fade-in">
                    <p>"Undangannya cantik banget! Tamu-tamu pada tanya bikin di mana 😍"</p>
                    <div class="author">Rini & Danu</div>
                    <div class="location">Surabaya</div>
                </div>
                <div class="testimonial-card fade-in">
                    <p>"Prosesnya cepat, kurang dari 1 jam sudah bisa dibagikan ke tamu."</p>
                    <div class="author">Sari & Budi</div>
                    <div class="location">Malang</div>
                </div>
                <div class="testimonial-card fade-in">
                    <p>"Fitur link per tamu favoritku, jadi terasa lebih personal!"</p>
                    <div class="author">Dewi & Arif</div>
                    <div class="location">Jakarta</div>
                </div>
            </div>
        </div>
    </section>

    <section id="cta">
        <div class="container">
            <h2 class="fade-in">Siap Membuat Undangan Impianmu?</h2>
            <p class="fade-in">Gabung dengan 500+ pasangan yang sudah mempercayai AturAtur</p>
            <a href="https://wa.me/{{ $waNumber }}?text=Halo%20AturAtur%2C%20saya%20mau%20pesan%20undangan%20digital"
                target="_blank" class="btn-cta fade-in">Pesan Sekarang via WhatsApp</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="brand">
                <span class="logo">Atur<span>Atur</span></span>
                <p>Undangan digital yang berkesan untuk hari bahagiamu.</p>
            </div>
            <div>
                <h4>Layanan</h4>
                <a href="/tema">Tema</a>
                <a href="/#harga">Harga</a>
                <a href="/cara-kerja">Cara Kerja</a>
            </div>
            <div>
                <h4>Bantuan</h4>
                <a href="https://wa.me/{{ $waNumber }}" target="_blank">WhatsApp</a>
                <a href="mailto:hello@aturatur.com">Email</a>
            </div>
            <div>
                <h4>Ikuti Kami</h4>
                <a href="https://instagram.com/aturatur" target="_blank">Instagram</a>
            </div>
        </div>
        <div class="container footer-bottom">
            &copy; 2025 AturAtur. All rights reserved.
        </div>
    </footer>

    <script>
        function toggleMenu() {
            document.getElementById('navMenu').classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            var menu = document.getElementById('navMenu');
            var hamburger = document.getElementById('hamburger');
            if (!menu.contains(e.target) && !hamburger.contains(e.target)) {
                menu.classList.remove('open');
            }
        });

        window.addEventListener('scroll', function() {
            var navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.fade-in').forEach(function(el) {
            observer.observe(el);
        });
    </script>
</body>

</html>
