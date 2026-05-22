<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AturAtur') - Undangan Digital Pernikahan Elegan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; color: #333; background: #FAFAFA; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, .font-serif { font-family: 'Playfair Display', Georgia, serif; }
        .container { max-width: 1140px; margin: 0 auto; padding: 0 1.5rem; }

        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05); transition: box-shadow 0.3s;
        }
        .navbar.scrolled { box-shadow: 0 2px 20px rgba(0,0,0,0.08); }
        .navbar .container { display: flex; align-items: center; justify-content: space-between; height: 70px; }
        .nav-logo { font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 800; color: #8B1A4A; text-decoration: none; letter-spacing: -0.5px; }
        .nav-logo span { color: #D4447C; }
        .nav-menu { display: flex; align-items: center; gap: 2rem; list-style: none; }
        .nav-menu a { text-decoration: none; color: #555; font-size: 0.9rem; font-weight: 500; transition: color 0.2s; }
        .nav-menu a:hover, .nav-menu a.active, .nav-menu a.active-page { color: #8B1A4A; }
        .nav-actions { display: flex; align-items: center; gap: 0.75rem; }
        .nav-actions .btn-outline { padding: 0.45rem 1.25rem; border: 1.5px solid #8B1A4A; border-radius: 50px; color: #8B1A4A; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: all 0.2s; }
        .nav-actions .btn-outline:hover { background: #8B1A4A; color: white; }
        .nav-actions .btn-primary { padding: 0.45rem 1.25rem; background: #8B1A4A; border-radius: 50px; color: white; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: opacity 0.2s; }
        .nav-actions .btn-primary:hover { opacity: 0.9; }
        .hamburger { display: none; flex-direction: column; gap: 5px; cursor: pointer; background: none; border: none; padding: 4px; }
        .hamburger span { width: 24px; height: 2px; background: #8B1A4A; transition: all 0.3s; border-radius: 2px; }

        .page-header { padding-top: 120px; padding-bottom: 2.5rem; text-align: center; }
        .page-header h1 { font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 3vw, 2.5rem); color: #1a1a2e; margin-bottom: 0.5rem; }
        .page-header p { color: #888; font-size: 0.95rem; max-width: 500px; margin: 0 auto; }

        footer { background: #1a1a2e; color: rgba(255,255,255,0.6); padding: 2rem 0; text-align: center; font-size: 0.8rem; }

        @media (max-width: 768px) {
            .nav-menu { display: none; position: absolute; top: 70px; left: 0; right: 0; background: white; flex-direction: column; padding: 1.5rem; gap: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
            .nav-menu.open { display: flex; }
            .hamburger { display: flex; }
            .nav-actions .btn-primary, .nav-actions .btn-outline { font-size: 0.8rem; padding: 0.35rem 1rem; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar" id="navbar">
        <div class="container">
            <a href="/" class="nav-logo">Atur<span>Atur</span></a>
            <ul class="nav-menu" id="navMenu">
                <li><a href="/" class="{{ request()->is('/') ? 'active-page' : '' }}">Beranda</a></li>
                <li><a href="/tema" class="{{ request()->is('tema') ? 'active-page' : '' }}">Tema</a></li>
                <li><a href="/cara-kerja" class="{{ request()->is('cara-kerja') ? 'active-page' : '' }}">Cara Kerja</a></li>
                <li><a href="/#harga">Harga</a></li>
            </ul>
            <div class="nav-actions">
                <a href="/dashboard/login" class="btn-outline">Login</a>
                <a href="https://wa.me/{{ config('app.wa_number') }}?text=Halo%20AturAtur%2C%20saya%20mau%20pesan%20undangan%20digital" target="_blank" class="btn-primary">Pesan Sekarang</a>
                <button class="hamburger" id="hamburger" onclick="toggleMenu()" aria-label="Menu">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer>
        <div class="container">&copy; 2025 AturAtur. All rights reserved.</div>
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
    </script>
    @yield('scripts')
</body>
</html>
