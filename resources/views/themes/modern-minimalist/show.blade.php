<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $invitation->title }} - AturAtur</title>
    <meta name="description" content="Undangan pernikahan {{ $invitation->groom_name ?? 'Mempelai Pria' }} & {{ $invitation->bride_name ?? 'Mempelai Wanita' }}">
    <meta property="og:title" content="{{ $invitation->title }} - AturAtur">
    <meta property="og:description" content="Undangan pernikahan {{ $invitation->groom_name ?? 'Mempelai Pria' }} & {{ $invitation->bride_name ?? 'Mempelai Wanita' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @if ($invitation->cover_photo)
    <meta property="og:image" content="{{ asset('storage/' . $invitation->cover_photo) }}">
    @elseif ($invitation->groom_photo && $invitation->bride_photo)
    <meta property="og:image" content="{{ asset('storage/' . $invitation->groom_photo) }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <style>
        @if ($invitation->custom_colors)
        :root {
            --theme-primary: {{ $invitation->custom_colors['primary'] ?? '#c9a84c' }};
            --theme-secondary: {{ $invitation->custom_colors['secondary'] ?? '#8B1A4A' }};
            --theme-accent: {{ $invitation->custom_colors['accent'] ?? '#D4447C' }};
            --theme-bg: {{ $invitation->custom_colors['background'] ?? '#faf8f5' }};
            --theme-text: {{ $invitation->custom_colors['text'] ?? '#2c2c3a' }};
        }
        @endif

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: #2d2d2d;
            background: #fcf8f7;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .serif {
            font-family: 'Playfair Display', Georgia, serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1.5rem;
            position: relative;
            z-index: 1;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        section {
            padding: 5rem 0;
            position: relative;
        }

        .section-bg-alt {
            background: linear-gradient(180deg, #fcf8f7 0%, #f8f0ed 100%);
        }

        .section-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2rem;
            color: #b76e79;
            text-align: center;
            margin-bottom: 0.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .section-subtitle {
            text-align: center;
            font-size: 0.8rem;
            color: #c9a0a6;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
            font-weight: 500;
        }

        .divider {
            width: 50px;
            height: 2px;
            background: linear-gradient(90deg, #b76e79, #d4a0a8);
            margin: 1rem auto 2.5rem;
            border-radius: 2px;
        }

        .animate-fade {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .animate-fade.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .animate-scale {
            opacity: 0;
            transform: scale(0.8);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .animate-scale.visible {
            opacity: 1;
            transform: scale(1);
        }

        .animate-up {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .animate-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .cover-stagger>* {
            opacity: 0;
            transform: translateY(20px);
            animation: staggerFadeIn 0.6s ease forwards;
        }

        .cover-stagger>*:nth-child(1) {
            animation-delay: 0.1s;
        }

        .cover-stagger>*:nth-child(2) {
            animation-delay: 0.3s;
        }

        .cover-stagger>*:nth-child(3) {
            animation-delay: 0.5s;
        }

        .cover-stagger>*:nth-child(4) {
            animation-delay: 0.7s;
        }

        .cover-stagger>*:nth-child(5) {
            animation-delay: 0.9s;
        }

        .cover-stagger>*:nth-child(6) {
            animation-delay: 1.1s;
        }

        @keyframes staggerFadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes countdownPop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }

            100% {
                transform: scale(1);
            }
        }

        .countdown-item .num {
            display: inline-block;
            transition: transform 0.2s;
        }

        .countdown-item .num.pop {
            animation: countdownPop 0.3s ease;
        }

        .couple-photo-ring {
            animation: pulseGlow 2s ease-in-out infinite;
        }

        @keyframes pulseGlow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(183, 110, 121, 0.3);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(183, 110, 121, 0);
            }
        }

        .gallery-item img {
            transition: transform 0.5s, opacity 0.5s;
            opacity: 0;
        }

        .gallery-item img.loaded {
            opacity: 1;
        }

        .lightbox {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .lightbox.active {
            opacity: 1;
        }

        .lightbox img {
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .lightbox.active img {
            transform: scale(1);
        }

        .event-card {
            transition-delay: calc(var(--i, 0) * 0.15s);
        }

        .bg-pattern .shape {
            animation: shapeDrift 12s ease-in-out infinite;
        }

        .bg-pattern .s1 {
            animation-delay: 0s;
        }

        .bg-pattern .s2 {
            animation-delay: -3s;
        }

        .bg-pattern .s3 {
            animation-delay: -6s;
        }

        .bg-pattern .s4 {
            animation-delay: -9s;
        }

        @keyframes shapeDrift {

            0%,
            100% {
                transform: rotate(0deg) translateY(0);
            }

            33% {
                transform: rotate(2deg) translateY(-5px);
            }

            66% {
                transform: rotate(-1deg) translateY(3px);
            }
        }

        .section-divider svg {
            animation: dividerPulse 4s ease-in-out infinite;
        }

        @keyframes dividerPulse {

            0%,
            100% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }
        }

        .cover-decoration {
            animation: decoFloat 3s ease-in-out infinite;
        }

        @keyframes decoFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        #petals-container {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9999;
            overflow: hidden;
        }

        .petal {
            position: absolute;
            top: -30px;
            width: 18px;
            height: 18px;
            opacity: 0.5;
            animation: petalFall linear infinite;
        }

        .petal svg {
            width: 100%;
            height: 100%;
        }

        @keyframes petalFall {
            0% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 0.5;
            }

            100% {
                transform: translateY(110vh) rotate(720deg) scale(0.3);
                opacity: 0;
            }
        }

        .floating-music {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 9998;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #b76e79, #d4a0a8);
            border: none;
            color: white;
            font-size: 1.3rem;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(183, 110, 121, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .floating-music:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 30px rgba(183, 110, 121, 0.4);
        }

        .floating-music.playing {
            animation: musicPulse 2s infinite;
        }

        @keyframes musicPulse {

            0%,
            100% {
                box-shadow: 0 4px 20px rgba(183, 110, 121, 0.3);
            }

            50% {
                box-shadow: 0 4px 40px rgba(183, 110, 121, 0.6);
            }
        }

        #cover {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #fcf8f7 0%, #f5eae6 40%, #ecd9d4 100%);
            overflow: hidden;
            text-align: center;
        }

        .cover-bg-decor {
            position: absolute;
            inset: 0;
        }

        .cover-bg-decor .circle1 {
            position: absolute;
            top: -20%;
            right: -15%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(183, 110, 121, 0.08), transparent 70%);
        }

        .cover-bg-decor .circle2 {
            position: absolute;
            bottom: -25%;
            left: -20%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(212, 160, 168, 0.08), transparent 70%);
        }

        .cover-bg-decor .ring {
            position: absolute;
            top: 5%;
            left: 5%;
            width: 200px;
            height: 200px;
            border: 1px solid rgba(183, 110, 121, 0.1);
            border-radius: 50%;
            animation: ringFloat 8s ease-in-out infinite;
        }

        .cover-bg-decor .ring2 {
            position: absolute;
            bottom: 10%;
            right: 8%;
            width: 150px;
            height: 150px;
            border: 1px solid rgba(212, 160, 168, 0.1);
            border-radius: 50%;
            animation: ringFloat 10s ease-in-out infinite reverse;
        }

        @keyframes ringFloat {

            0%,
            100% {
                transform: translateY(0) scale(1);
            }

            50% {
                transform: translateY(-20px) scale(1.05);
            }
        }

        .cover-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            padding: 2rem;
        }

        .cover-guest {
            font-size: 0.75rem;
            letter-spacing: 5px;
            text-transform: uppercase;
            color: #c9a0a6;
            margin-bottom: 1rem;
        }

        .cover-guest-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.15rem;
            color: #b76e79;
            margin-bottom: 2rem;
            font-style: italic;
        }

        .cover-title {
            font-size: 0.7rem;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: #c9a0a6;
            margin-bottom: 0.75rem;
        }

        .cover-decoration {
            font-size: 1.5rem;
            color: #d4a0a8;
            margin-bottom: 0.5rem;
            letter-spacing: 8px;
        }

        .cover-names {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(2.2rem, 6vw, 3.8rem);
            color: #4a3335;
            line-height: 1.15;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .cover-names .and {
            display: block;
            font-size: 1rem;
            color: #b76e79;
            margin: 0.4rem 0;
            font-weight: 400;
            font-style: italic;
            letter-spacing: 2px;
        }

        .cover-names span {
            display: block;
        }

        .cover-date {
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            color: #8a6a6e;
            letter-spacing: 3px;
            margin-top: 1rem;
            font-weight: 300;
        }

        .countdown {
            display: flex;
            justify-content: center;
            gap: 0.75rem;
            margin: 1.5rem 0;
        }

        .countdown-item {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 0.65rem 0.85rem;
            min-width: 64px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .countdown-item .num {
            font-size: 1.6rem;
            font-weight: 700;
            display: block;
            color: #4a3335;
        }

        .countdown-item .label {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #b76e79;
            margin-top: 2px;
        }

        .envelope-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: linear-gradient(135deg, #b76e79, #d4a0a8);
            color: white;
            border: none;
            cursor: pointer;
            padding: 1rem 2.5rem;
            font-size: 0.95rem;
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            letter-spacing: 1px;
            transition: transform 0.3s, box-shadow 0.3s;
            margin-top: 1.5rem;
            box-shadow: 0 4px 20px rgba(183, 110, 121, 0.25);
        }

        .envelope-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(183, 110, 121, 0.35);
        }

        .envelope-btn.opened {
            background: linear-gradient(135deg, #9a5d66, #b76e79);
        }

        .invitation-body {
            display: none;
        }

        .invitation-body.visible {
            display: block;
        }

        .quote-section {
            text-align: center;
            max-width: 650px;
            margin: 0 auto;
            padding: 3rem 0;
            position: relative;
        }

        .quote-mark {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 4rem;
            color: #d4a0a8;
            line-height: 1;
            margin-bottom: -1rem;
            opacity: 0.5;
        }

        .quote-text {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.15rem;
            color: #6b5558;
            line-height: 1.9;
            font-style: italic;
            padding: 0 1rem;
        }

        .couple-grid {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2.5rem;
        }

        @media (min-width: 640px) {
            .couple-grid {
                flex-direction: row;
                justify-content: center;
                align-items: flex-start;
            }
        }

        .couple-card {
            text-align: center;
            max-width: 280px;
        }

        .couple-photo-wrap {
            position: relative;
            width: 200px;
            height: 200px;
            margin: 0 auto 1.25rem;
        }

        .couple-photo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(183, 110, 121, 0.2);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
        }

        .couple-photo-ring {
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 1.5px solid rgba(183, 110, 121, 0.2);
        }

        .couple-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.4rem;
            color: #4a3335;
            margin-bottom: 0.3rem;
            font-weight: 600;
        }

        .couple-parents {
            font-size: 0.8rem;
            color: #c9a0a6;
        }

        .couple-and {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 2rem;
            color: #d4a0a8;
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            font-style: italic;
        }

        @media (min-width: 640px) {
            .couple-and {
                padding: 0 1.5rem;
            }
        }

        .event-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 1.25rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .event-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
        }

        .event-type {
            display: inline-block;
            background: linear-gradient(135deg, #f5eae6, #ecd9d4);
            color: #b76e79;
            padding: 0.25rem 1.25rem;
            border-radius: 20px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .event-title {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.3rem;
            color: #4a3335;
            margin-bottom: 0.5rem;
        }

        .event-date {
            font-size: 1rem;
            color: #b76e79;
            font-weight: 500;
            margin-bottom: 0.15rem;
        }

        .event-time {
            color: #c9a0a6;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .event-venue {
            font-weight: 600;
            color: #4a3335;
            margin-bottom: 0.2rem;
            font-size: 0.9rem;
        }

        .event-address {
            color: #c9a0a6;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .map-btn {
            display: inline-block;
            background: linear-gradient(135deg, #b76e79, #d4a0a8);
            color: white;
            text-decoration: none;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: opacity 0.2s, transform 0.2s;
        }

        .map-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .story-content {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .story-text {
            color: #6b5558;
            line-height: 1.9;
            font-size: 0.95rem;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        @media (min-width: 640px) {
            .gallery-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .gallery-item {
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            aspect-ratio: 1;
            position: relative;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .gallery-item:hover img {
            transform: scale(1.08);
        }

        .gallery-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(0, 0, 0, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .gallery-item:hover::after {
            opacity: 1;
        }

        .lightbox {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(0, 0, 0, 0.92);
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox img {
            max-width: 100%;
            max-height: 90vh;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .lightbox-close {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
            color: white;
            font-size: 2.5rem;
            cursor: pointer;
            background: none;
            border: none;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .lightbox-close:hover {
            opacity: 1;
        }

        .rsvp-form {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            max-width: 480px;
            margin: 0 auto;
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #b76e79;
            margin-bottom: 0.35rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1.5px solid #ecd9d4;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            font-family: inherit;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #b76e79;
            box-shadow: 0 0 0 3px rgba(183, 110, 121, 0.1);
        }

        .form-group input:read-only {
            background: #f8f0ed;
            color: #c9a0a6;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #b76e79, #d4a0a8);
            color: white;
            border: none;
            padding: 0.85rem;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            letter-spacing: 1px;
        }

        .btn-submit:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            transform: none;
        }

        .btn-submit.loading {
            position: relative;
            color: transparent;
        }

        .btn-submit.loading::after {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 22px;
            height: 22px;
            border: 2.5px solid white;
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .wish-list {
            max-width: 600px;
            margin: 2rem auto 0;
        }

        .wish-item {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.9);
            transition: transform 0.2s;
        }

        .wish-item:hover {
            transform: translateY(-1px);
        }

        .wish-item .sender {
            font-weight: 600;
            color: #4a3335;
            font-size: 0.95rem;
        }

        .wish-item .date {
            font-size: 0.7rem;
            color: #c9a0a6;
            margin-top: 0.15rem;
        }

        .wish-item .msg {
            margin-top: 0.5rem;
            color: #6b5558;
            line-height: 1.6;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #f0faf0;
            border: 1px solid #a8d8a8;
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #2d6a2d;
            text-align: center;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #c9a0a6;
            font-size: 0.9rem;
        }

        .bank-card {
            max-width: 400px;
            margin: 0 auto;
            border-radius: 16px;
            padding: 1.75rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            font-family: 'Inter', sans-serif;
        }

        .bank-card .bg-pattern {
            position: absolute;
            top: -50%;
            right: -30%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .bank-card .bg-pattern2 {
            position: absolute;
            bottom: -40%;
            left: -20%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .bank-card .bank-name {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 1;
            letter-spacing: 1px;
        }

        .bank-card .chip {
            width: 40px;
            height: 30px;
            background: linear-gradient(135deg, #e8d5b0, #d4b88a);
            border-radius: 4px;
            margin-bottom: 0.75rem;
            position: relative;
            z-index: 1;
        }

        .bank-card .account-label {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            opacity: 0.8;
            margin-bottom: 0.25rem;
            position: relative;
            z-index: 1;
        }

        .bank-card .account-number {
            font-size: 1.3rem;
            font-weight: 700;
            letter-spacing: 3px;
            margin-bottom: 0.25rem;
            position: relative;
            z-index: 1;
            font-family: 'Courier New', monospace;
        }

        .bank-card .copy-btn {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.3rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
            z-index: 1;
        }

        .bank-card .copy-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        footer {
            background: #4a3335;
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            padding: 3rem 1.5rem;
            position: relative;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, #b76e79, #d4a0a8, transparent);
        }

        footer .names {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 1.4rem;
            color: white;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        footer .date {
            color: #d4a0a8;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }

        footer .credit {
            font-size: 0.75rem;
            opacity: 0.4;
        }

        footer .credit a {
            color: #d4a0a8;
            text-decoration: none;
        }


        @media (max-width: 640px) {

            .section-divider,
            .couple-arch-side,
            .couple-arch-top,
            .arch-flower,
            .corner-deco,
            .header-deco,
            .bg-pattern,
            .sparkle-container {
                display: none;
            }
        }

        .section-divider {
            text-align: center;
            padding: 0.75rem 0;
            position: relative;
            overflow: visible;
            pointer-events: none;
        }

        .couple-arch-wrap {
            position: relative;
            padding: 2.5rem 1.5rem 1rem;
            margin: 0 -0.75rem;
        }

        .couple-arch-top {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 85%;
            height: 50px;
            border: 2px solid rgba(183, 110, 121, 0.12);
            border-bottom: none;
            border-radius: 100px 100px 0 0;
            pointer-events: none;
        }

        .couple-arch-side {
            position: absolute;
            top: 0;
            width: 18px;
            height: 100px;
            border-radius: 9px 9px 0 0;
            pointer-events: none;
        }

        .couple-arch-side.left {
            left: 0;
            background: linear-gradient(180deg, rgba(183, 110, 121, 0.15), transparent);
        }

        .couple-arch-side.right {
            right: 0;
            background: linear-gradient(180deg, rgba(183, 110, 121, 0.15), transparent);
        }

        .arch-flower {
            position: absolute;
            font-size: 1rem;
            color: rgba(183, 110, 121, 0.3);
            pointer-events: none;
        }

        .arch-flower.f1 {
            top: -4px;
            left: 20%;
        }

        .arch-flower.f2 {
            top: -4px;
            right: 20%;
        }

        .arch-flower.f3 {
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1.3rem;
        }

        .arch-flower.f4 {
            top: 12px;
            left: 8%;
        }

        .arch-flower.f5 {
            top: 12px;
            right: 8%;
        }

        .corner-deco {
            position: absolute;
            font-size: 0.75rem;
            color: rgba(183, 110, 121, 0.12);
            pointer-events: none;
            line-height: 1;
            font-family: serif;
        }

        .corner-deco.tl {
            top: 5px;
            left: 8px;
        }

        .corner-deco.tr {
            top: 5px;
            right: 8px;
            transform: scaleX(-1);
        }

        .corner-deco.bl {
            bottom: 5px;
            left: 8px;
            transform: scaleY(-1);
        }

        .corner-deco.br {
            bottom: 5px;
            right: 8px;
            transform: scale(-1, -1);
        }

        .event-card,
        .rsvp-form,
        .bank-card,
        .wish-item {
            position: relative;
        }

        .header-deco {
            display: inline-block;
            font-size: 0.85rem;
            color: rgba(183, 110, 121, 0.2);
            vertical-align: middle;
        }

        .header-deco.left {
            margin-right: 5px;
        }

        .header-deco.right {
            margin-left: 5px;
        }

        .bg-pattern {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .bg-pattern .shape {
            position: absolute;
            border: 1px solid rgba(183, 110, 121, 0.04);
        }

        .bg-pattern .s1 {
            width: 100px;
            height: 100px;
            top: 8%;
            left: -30px;
            transform: rotate(45deg);
            border-radius: 4px;
        }

        .bg-pattern .s2 {
            width: 150px;
            height: 150px;
            bottom: 5%;
            right: -40px;
            border-radius: 50%;
        }

        .bg-pattern .s3 {
            width: 70px;
            height: 70px;
            top: 45%;
            right: 5%;
            transform: rotate(60deg);
        }

        .bg-pattern .s4 {
            width: 110px;
            height: 110px;
            bottom: 25%;
            left: -15px;
            border-radius: 50%;
        }

        .sparkle-container {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 9997;
            overflow: hidden;
        }

        .sparkle-dot {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        @keyframes sparkleAnim {
            0% {
                transform: translateY(100vh) scale(0);
                opacity: 0;
            }

            20% {
                opacity: 0.5;
            }

            80% {
                opacity: 0.3;
            }

            100% {
                transform: translateY(-5vh) scale(1.5);
                opacity: 0;
            }
        }

        .floating-share {
            position: fixed; bottom: 2rem; left: 2rem; z-index: 9998;
            width: 48px; height: 48px; border-radius: 50%;
            background: white; border: 1px solid #b76e79; color: #b76e79;
            font-size: 1.3rem; cursor: pointer;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: all 0.3s;
            display: none; align-items: center; justify-content: center;
        }
        .floating-share:hover { background: #b76e79; color: white; transform: scale(1.08); }
        @if ($invitation->custom_css)
        {{ $invitation->custom_css }}
        @endif
        </style></head><body><div id="petals-container"></div><div class="sparkle-container" id="sparkle-container"></div><div id="cover"><div class="cover-bg-decor"><div class="circle1"></div><div class="circle2"></div><div class="ring"></div><div class="ring2"></div></div><div class="cover-content"><div class="cover-stagger"><div class="cover-guest">Kepada Yth.</div><div class="cover-guest-name">{{ $guestName }}</div><div class="cover-decoration">&diams;
        &diams;
        &diams;
        </div><div class="cover-title">Undangan Pernikahan</div><div class="cover-names"><span>{{ $invitation->groom_nickname ?? $invitation->groom_name }}</span><span class="and">&</span><span>{{ $invitation->bride_nickname ?? $invitation->bride_name }}</span></div>@php $firstEvent = $invitation->events->first(); @endphp @if ($firstEvent)<div class="cover-date">{{ \Carbon\Carbon::parse($firstEvent->date)->isoFormat('D MMMM YYYY') }}</div><div class="countdown" id="countdown" data-date="{{ \Carbon\Carbon::parse($firstEvent->date)->format('Y-m-d') }}"><div class="countdown-item"><span class="num" id="cd-days">0</span><span class="label">Hari</span></div><div class="countdown-item"><span class="num" id="cd-hours">0</span><span class="label">Jam</span></div><div class="countdown-item"><span class="num" id="cd-minutes">0</span><span class="label">Menit</span></div><div class="countdown-item"><span class="num" id="cd-seconds">0</span><span class="label">Detik</span></div></div>@endif<button class="envelope-btn" onclick="openInvitation(this)">Buka Undangan</button></div></div></div>@php $ytId = $invitation->music_url ? (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $invitation->music_url, $m) ? $m[1] : null) : null; @endphp @if ($ytId)<button class="floating-music" id="musicToggle" onclick="toggleMusic()">&#9835;
        </button><div id="youtube-player" data-video="{{ $ytId }}"></div>@endif<button class="floating-share" id="shareBtn" onclick="shareInvitation()" style="display:none;" title="Bagikan Undangan">&#8599;</button><div class="invitation-body" id="invitationBody">@if (session('success'))<div style="max-width:800px;margin:1rem auto 0;padding:0 1.5rem;"><div class="alert-success">{{ session('success') }}</div></div>@endif@if ($invitation->opening_quote)<section id="quote" class="section-bg-alt"><div class="container"><div class="quote-section animate-fade"><div class="quote-mark">&ldquo;
        </div><p class="quote-text">{{ $invitation->opening_quote }}</p></div></div></section><div class="section-divider"><svg viewBox="0 0 120 16" width="120" height="16"><circle cx="12" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M18 8 L22 4 L26 8 L22 12Z" fill="#b76e79" opacity="0.2"/><circle cx="32" cy="8" r="2" fill="#d4a0a8" opacity="0.35"/><path d="M40 8 L44 4 L48 8 L44 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="54" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><circle cx="60" cy="8" r="3" fill="#b76e79" opacity="0.15"/><circle cx="66" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M72 8 L76 4 L80 8 L76 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="88" cy="8" r="2" fill="#b76e79" opacity="0.35"/><path d="M94 8 L98 4 L102 8 L98 12Z" fill="#b76e79" opacity="0.2"/><circle cx="108" cy="8" r="1.5" fill="#d4a0a8" opacity="0.3"/></svg></div>@endif<section id="couple"><div class="container"><div class="bg-pattern"><div class="shape s1"></div><div class="shape s2"></div><div class="shape s3"></div><div class="shape s4"></div></div><div class="section-title"><span class="header-deco left">&#10022;
        </span>Mempelai <span class="header-deco right">&#10022;
        </span></div><div class="section-subtitle">The Happy Couple</div><div class="divider"></div><div class="couple-arch-wrap"><div class="couple-arch-top"><span class="arch-flower f1">&#10022;
        </span><span class="arch-flower f2">&#10022;
        </span><span class="arch-flower f3">&#10047;
        </span><span class="arch-flower f4">&#10022;
        </span><span class="arch-flower f5">&#10022;
        </span></div><div class="couple-arch-side left"></div><div class="couple-arch-side right"></div><div class="couple-grid animate-fade"><div class="couple-card"><div class="couple-photo-wrap"><img src="{{ $invitation->groom_photo ? asset('storage/' . $invitation->groom_photo) : 'data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22><rect fill=%22%23f5eae6%22 width=%22200%22 height=%22200%22 rx=%22100%22/><text fill=%22%23b76e79%22 font-size=%2240%22 x=%2275%22 y=%22115%22>&#9794;</text></svg>' }}" alt="{{ $invitation->groom_name }}" class="couple-photo"><div class="couple-photo-ring"></div></div><div class="couple-name">{{ $invitation->groom_name }}</div><div class="couple-parents">Putra dari {{ $invitation->groom_father ?? '...' }} & {{ $invitation->groom_mother ?? '...' }}</div></div><div class="couple-and">&</div><div class="couple-card"><div class="couple-photo-wrap"><img src="{{ $invitation->bride_photo ? asset('storage/' . $invitation->bride_photo) : 'data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22><rect fill=%22%23f5eae6%22 width=%22200%22 height=%22200%22 rx=%22100%22/><text fill=%22%23b76e79%22 font-size=%2240%22 x=%2275%22 y=%22115%22>&#9792;</text></svg>' }}" alt="{{ $invitation->bride_name }}" class="couple-photo"><div class="couple-photo-ring"></div></div><div class="couple-name">{{ $invitation->bride_name }}</div><div class="couple-parents">Putri dari {{ $invitation->bride_father ?? '...' }} & {{ $invitation->bride_mother ?? '...' }}</div></div></div></div></div></section><div class="section-divider"><svg viewBox="0 0 120 16" width="120" height="16"><circle cx="12" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M18 8 L22 4 L26 8 L22 12Z" fill="#b76e79" opacity="0.2"/><circle cx="32" cy="8" r="2" fill="#d4a0a8" opacity="0.35"/><path d="M40 8 L44 4 L48 8 L44 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="54" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><circle cx="60" cy="8" r="3" fill="#b76e79" opacity="0.15"/><circle cx="66" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M72 8 L76 4 L80 8 L76 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="88" cy="8" r="2" fill="#b76e79" opacity="0.35"/><path d="M94 8 L98 4 L102 8 L98 12Z" fill="#b76e79" opacity="0.2"/><circle cx="108" cy="8" r="1.5" fill="#d4a0a8" opacity="0.3"/></svg></div>@if ($invitation->events->count() > 0)<section id="events" class="section-bg-alt"><div class="container"><div class="bg-pattern"><div class="shape s1"></div><div class="shape s2"></div><div class="shape s3"></div><div class="shape s4"></div></div><div class="section-title"><span class="header-deco left">&#10022;
        </span>Acara <span class="header-deco right">&#10022;
        </span></div><div class="section-subtitle">Save The Date</div><div class="divider"></div>@foreach ($invitation->events as $event)<div class="event-card animate-fade" style="--i: {{ $loop->index }}"><span class="corner-deco tl">&#10022;
        </span><span class="corner-deco tr">&#10022;
        </span><span class="corner-deco bl">&#10022;
        </span><span class="corner-deco br">&#10022;
        </span><div class="event-type">{{ $event->type }}</div><div class="event-title serif">{{ $event->title }}</div><div class="event-date">{{ \Carbon\Carbon::parse($event->date)->isoFormat('dddd, D MMMM YYYY') }}</div><div class="event-time">Pukul {{ \Carbon\Carbon::parse($event->time_start)->format('H:i') }}@if ($event->time_end)- {{ \Carbon\Carbon::parse($event->time_end)->format('H:i') }} WITA @else WITA @endif</div>@if ($event->venue_name)<div class="event-venue">{{ $event->venue_name }}</div>@endif@if ($event->address)<div class="event-address">{{ $event->address }}</div>@endif@if ($event->maps_url)<a href="{{ $event->maps_url }}" target="_blank" class="map-btn">Lihat Peta</a>@endif<a href="{{ url('/calendar/' . $invitation->slug . '/' . $event->id) }}" target="_blank" class="map-btn" style="margin-left:0.5rem;">&#128197; Simpan</a></div>@endforeach</div></section>@endif<div class="section-divider"><svg viewBox="0 0 120 16" width="120" height="16"><circle cx="12" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M18 8 L22 4 L26 8 L22 12Z" fill="#b76e79" opacity="0.2"/><circle cx="32" cy="8" r="2" fill="#d4a0a8" opacity="0.35"/><path d="M40 8 L44 4 L48 8 L44 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="54" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><circle cx="60" cy="8" r="3" fill="#b76e79" opacity="0.15"/><circle cx="66" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M72 8 L76 4 L80 8 L76 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="88" cy="8" r="2" fill="#b76e79" opacity="0.35"/><path d="M94 8 L98 4 L102 8 L98 12Z" fill="#b76e79" opacity="0.2"/><circle cx="108" cy="8" r="1.5" fill="#d4a0a8" opacity="0.3"/></svg></div>@if ($invitation->love_story)<section id="story"><div class="container"><div class="bg-pattern"><div class="shape s1"></div><div class="shape s2"></div><div class="shape s3"></div><div class="shape s4"></div></div><div class="section-title"><span class="header-deco left">&#10022;
        </span>Kisah Kami <span class="header-deco right">&#10022;
        </span></div><div class="section-subtitle">Our Love Story</div><div class="divider"></div><div class="story-content animate-fade"><p class="story-text">{{ $invitation->love_story }}</p></div></div></section>@endif<div class="section-divider"><svg viewBox="0 0 120 16" width="120" height="16"><circle cx="12" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M18 8 L22 4 L26 8 L22 12Z" fill="#b76e79" opacity="0.2"/><circle cx="32" cy="8" r="2" fill="#d4a0a8" opacity="0.35"/><path d="M40 8 L44 4 L48 8 L44 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="54" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><circle cx="60" cy="8" r="3" fill="#b76e79" opacity="0.15"/><circle cx="66" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M72 8 L76 4 L80 8 L76 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="88" cy="8" r="2" fill="#b76e79" opacity="0.35"/><path d="M94 8 L98 4 L102 8 L98 12Z" fill="#b76e79" opacity="0.2"/><circle cx="108" cy="8" r="1.5" fill="#d4a0a8" opacity="0.3"/></svg></div>@if ($invitation->photos->count() > 0)<section id="gallery" class="section-bg-alt"><div class="container"><div class="bg-pattern"><div class="shape s1"></div><div class="shape s2"></div><div class="shape s3"></div><div class="shape s4"></div></div><div class="section-title"><span class="header-deco left">&#10022;
        </span>Galeri <span class="header-deco right">&#10022;
        </span></div><div class="section-subtitle">Precious Moments</div><div class="divider"></div><div class="gallery-grid">@foreach ($invitation->photos as $photo)<div class="gallery-item animate-fade" data-src="{{ asset('storage/' . $photo->filename) }}"><img src="{{ asset('storage/' . $photo->filename) }}" alt="{{ $photo->original_name ?? 'Foto' }}" loading="lazy" onload="this.classList.add('loaded')"></div>@endforeach</div></div></section>@endif<div class="section-divider"><svg viewBox="0 0 120 16" width="120" height="16"><circle cx="12" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M18 8 L22 4 L26 8 L22 12Z" fill="#b76e79" opacity="0.2"/><circle cx="32" cy="8" r="2" fill="#d4a0a8" opacity="0.35"/><path d="M40 8 L44 4 L48 8 L44 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="54" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><circle cx="60" cy="8" r="3" fill="#b76e79" opacity="0.15"/><circle cx="66" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M72 8 L76 4 L80 8 L76 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="88" cy="8" r="2" fill="#b76e79" opacity="0.35"/><path d="M94 8 L98 4 L102 8 L98 12Z" fill="#b76e79" opacity="0.2"/><circle cx="108" cy="8" r="1.5" fill="#d4a0a8" opacity="0.3"/></svg></div>@if ($invitation->bank_name && $invitation->bank_account)<section id="bank"><div class="container"><div class="bg-pattern"><div class="shape s1"></div><div class="shape s2"></div><div class="shape s3"></div><div class="shape s4"></div></div><div class="section-title"><span class="header-deco left">&#10022;
        </span>Kirim Hadiah <span class="header-deco right">&#10022;
        </span></div><div class="section-subtitle">Wedding Gift</div><div class="divider"></div>@php
            $bankColors = [
                'BCA' => '#0066AE',
                'BRI' => '#00509E',
                'BNI' => '#003780',
                'Mandiri' => '#00477E',
                'CIMB Niaga' => '#7F1432',
                'BSI' => '#1B9B4A',
                'BTN' => '#0051A8',
                'Danamon' => '#004799',
                'Maybank' => '#D32F2F',
                'Permata' => '#0E6EB0',
            ];
            $bg = $bankColors[$invitation->bank_name] ?? '#5C1130';
        @endphp <div class="bank-card animate-fade" style="background:{{ $bg }};"><div class="bg-pattern"></div><div class="bg-pattern2"></div><div class="bank-name">{{ $invitation->bank_name }}</div><div class="chip"></div><div class="account-label">Nomor Rekening</div><div class="account-number" id="bankAccount">{{ $invitation->bank_account }}</div><button class="copy-btn" onclick="copyBankAccount()">Salin No. Rekening</button></div></div></section>@endif<div class="section-divider"><svg viewBox="0 0 120 16" width="120" height="16"><circle cx="12" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M18 8 L22 4 L26 8 L22 12Z" fill="#b76e79" opacity="0.2"/><circle cx="32" cy="8" r="2" fill="#d4a0a8" opacity="0.35"/><path d="M40 8 L44 4 L48 8 L44 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="54" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><circle cx="60" cy="8" r="3" fill="#b76e79" opacity="0.15"/><circle cx="66" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M72 8 L76 4 L80 8 L76 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="88" cy="8" r="2" fill="#b76e79" opacity="0.35"/><path d="M94 8 L98 4 L102 8 L98 12Z" fill="#b76e79" opacity="0.2"/><circle cx="108" cy="8" r="1.5" fill="#d4a0a8" opacity="0.3"/></svg></div><section id="rsvp" class="section-bg-alt"><div class="container"><div class="bg-pattern"><div class="shape s1"></div><div class="shape s2"></div><div class="shape s3"></div><div class="shape s4"></div></div><div class="section-title"><span class="header-deco left">&#10022;
        </span>Konfirmasi Kehadiran <span class="header-deco right">&#10022;
        </span></div><div class="section-subtitle">RSVP</div><div class="divider"></div>@if ($guest)<form method="POST" action="{{ url('/rsvp/' . $guest->id) }}" class="rsvp-form animate-fade" onsubmit="return submitForm(this)"><span class="corner-deco tl">&#10022;
        </span><span class="corner-deco tr">&#10022;
        </span><span class="corner-deco bl">&#10022;
        </span><span class="corner-deco br">&#10022;
        </span>@csrf <div class="form-group"><label>Nama</label><input type="text" value="{{ $guest->name }}" readonly></div><div class="form-group"><label>Kehadiran</label><select name="rsvp_status" required><option value="">-- Pilih --</option><option value="hadir" @if ($guest->rsvp_status === 'hadir') selected @endif>Hadir</option><option value="tidak_hadir" @if ($guest->rsvp_status === 'tidak_hadir') selected @endif>Tidak Hadir</option><option value="mungkin" @if ($guest->rsvp_status === 'mungkin') selected @endif>Masih Ragu</option></select></div><div class="form-group"><label>Jumlah Tamu</label><select name="guest_count" required>@for ($i = 1; $i <= 10; $i++)<option value="{{ $i }}" @if ($guest->guest_count == $i) selected @endif>{{ $i }} orang</option>@endfor</select></div><button type="submit" class="btn-submit">Kirim Konfirmasi</button></form>@else <div class="rsvp-form" style="text-align:center;color:#c9a0a6;"><p>Hubungi pengantin untuk konfirmasi kehadiran.</p></div>@endif</div></section><div class="section-divider"><svg viewBox="0 0 120 16" width="120" height="16"><circle cx="12" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M18 8 L22 4 L26 8 L22 12Z" fill="#b76e79" opacity="0.2"/><circle cx="32" cy="8" r="2" fill="#d4a0a8" opacity="0.35"/><path d="M40 8 L44 4 L48 8 L44 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="54" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><circle cx="60" cy="8" r="3" fill="#b76e79" opacity="0.15"/><circle cx="66" cy="8" r="1.5" fill="#b76e79" opacity="0.3"/><path d="M72 8 L76 4 L80 8 L76 12Z" fill="#d4a0a8" opacity="0.2"/><circle cx="88" cy="8" r="2" fill="#b76e79" opacity="0.35"/><path d="M94 8 L98 4 L102 8 L98 12Z" fill="#b76e79" opacity="0.2"/><circle cx="108" cy="8" r="1.5" fill="#d4a0a8" opacity="0.3"/></svg></div><section id="wishes"><div class="container"><div class="bg-pattern"><div class="shape s1"></div><div class="shape s2"></div><div class="shape s3"></div><div class="shape s4"></div></div><div class="section-title"><span class="header-deco left">&#10022;
        </span>Ucapan & Doa <span class="header-deco right">&#10022;
        </span></div><div class="section-subtitle">Wishes & Prayers</div><div class="divider"></div><form method="POST" action="{{ url('/wishes/' . $invitation->id) }}" class="rsvp-form animate-fade" onsubmit="return submitForm(this)"><span class="corner-deco tl">&#10022;
        </span><span class="corner-deco tr">&#10022;
        </span><span class="corner-deco bl">&#10022;
        </span><span class="corner-deco br">&#10022;
        </span>@csrf <div class="form-group"><label>Nama</label><input type="text" name="sender_name" value="{{ $guest?->name ?? old('sender_name') }}" required maxlength="150" placeholder="Nama Anda"></div><div class="form-group"><label>Ucapan & Doa</label><textarea name="message" required rows="4" placeholder="Tulis ucapan dan doa untuk pengantin...">{{ old('message') }}</textarea></div><button type="submit" class="btn-submit">Kirim Ucapan</button></form>@if ($invitation->wishes->count() > 0)<div class="wish-list">@foreach ($invitation->wishes as $wish)<div class="wish-item animate-fade"><span class="corner-deco tl">&#10022;
        </span><span class="corner-deco tr">&#10022;
        </span><span class="corner-deco bl">&#10022;
        </span><span class="corner-deco br">&#10022;
        </span><div class="sender">{{ $wish->sender_name }}</div><div class="msg">{{ $wish->message }}</div><div class="date">{{ $wish->created_at->diffForHumans() }}</div></div>@endforeach</div>@else <div class="empty-state">Belum ada ucapan. Jadilah yang pertama memberi ucapan.</div>@endif</div></section><footer><div class="container"><div class="names serif">{{ $invitation->groom_nickname ?? $invitation->groom_name }} & {{ $invitation->bride_nickname ?? $invitation->bride_name }}</div>@if ($firstEvent)<div class="date">{{ \Carbon\Carbon::parse($firstEvent->date)->isoFormat('D MMMM YYYY') }}</div>@endif<div class="credit">Dibuat dengan <a href="{{ config('app.url') }}">AturAtur</a></div></div></footer></div><div class="lightbox" id="lightbox" onclick="closeLightbox(event)"><button class="lightbox-close" onclick="closeLightbox(event)">&times;
        </button><img id="lightbox-img" src="" alt=""></div><script>
            function createSparkles() {
                var container = document.getElementById('sparkle-container');
                if (!container) return;
                var colors = ['#b76e79', '#d4a0a8', '#f0d5d9', '#e8c4c9', '#ffd5dd'];
                for (var i = 0; i < 15; i++) {
                    var dot = document.createElement('div');
                    dot.className = 'sparkle-dot';
                    var size = 3 + Math.random() * 5;
                    dot.style.width = size + 'px';
                    dot.style.height = size + 'px';
                    dot.style.left = Math.random() * 100 + '%';
                    dot.style.animation = 'sparkleAnim ' + (6 + Math.random() * 10) + 's ease-in-out infinite';
                    dot.style.animationDelay = Math.random() * 10 + 's';
                    dot.style.background = colors[i % colors.length];
                    container.appendChild(dot);
                }
            }
            createSparkles();

            function createPetals() {
                var container = document.getElementById('petals-container');
                var colors = ['#b76e79', '#d4a0a8', '#e8c4c9', '#c9a0a6', '#f0d5d9'];
                for (var i = 0; i < 20; i++) {
                    var petal = document.createElement('div');
                    petal.className = 'petal';
                    var size = 12 + Math.random() * 16;
                    petal.style.width = size + 'px';
                    petal.style.height = size + 'px';
                    petal.style.left = Math.random() * 100 + '%';
                    petal.style.animationDuration = (10 + Math.random() * 15) + 's';
                    petal.style.animationDelay = Math.random() * 20 + 's';
                    petal.style.opacity = 0.2 + Math.random() * 0.3;
                    petal.innerHTML = '<svg viewBox="0 0 24 24" fill="' + colors[i % colors.length] +
                        '"><path d="M12 2C12 2 8 6 8 10C8 13.3 10.7 16 12 16C13.3 16 16 13.3 16 10C16 6 12 2 12 2Z"/></svg>';
                    container.appendChild(petal);
                }
            }
            createPetals();

            var musicBtn = document.getElementById('musicToggle');
            var playerDiv = document.getElementById('youtube-player');
            var ytPlayer = null;
            var isPlaying = false;
            var apiReady = false;
            var apiLoadAttempts = 0;

            function loadYouTubeAPI() {
                if (typeof YT !== 'undefined' && YT.Player) {
                    onYouTubeIframeAPIReady();
                    return;
                }
                if (document.getElementById('youtube-api-script')) return;
                var tag = document.createElement('script');
                tag.id = 'youtube-api-script';
                tag.src = 'https://www.youtube.com/iframe_api';
                tag.onerror = function() {
                    apiLoadAttempts++;
                    if (apiLoadAttempts < 3) setTimeout(loadYouTubeAPI, 2000);
                };
                document.body.appendChild(tag);
            }

            if (playerDiv) loadYouTubeAPI();

            window.onYouTubeIframeAPIReady = function() {
                apiReady = true;
                if (!playerDiv) return;
                try {
                    ytPlayer = new YT.Player('youtube-player', {
                        height: '0',
                        width: '0',
                        videoId: playerDiv.dataset.video,
                        playerVars: {
                            autoplay: 0,
                            controls: 0,
                            disablekb: 1,
                            fs: 0,
                            modestbranding: 1,
                            playsinline: 1
                        },
                        events: {
                            onReady: function(e) {
                                e.target.setVolume(30);
                            },
                            onStateChange: function(e) {
                                if (e.data === YT.PlayerState.ENDED) {
                                    e.target.seekTo(0);
                                    e.target.playVideo();
                                }
                                if (e.data === YT.PlayerState.PLAYING) {
                                    isPlaying = true;
                                    if (musicBtn) musicBtn.classList.add('playing');
                                }
                            }
                        }
                    });
                } catch (e) {
                    console.warn('YouTube init failed:', e);
                }
            };

            function tryPlayMusic() {
                if (ytPlayer && apiReady && ytPlayer.playVideo) {
                    try {
                        ytPlayer.mute();
                        ytPlayer.playVideo();
                        setTimeout(function() {
                            try {
                                ytPlayer.unMute();
                            } catch (e) {}
                        }, 500);
                        if (musicBtn) {
                            musicBtn.style.display = 'flex';
                            musicBtn.classList.add('playing');
                        }
                        isPlaying = true;
                    } catch (e) {
                        console.warn('Play failed:', e);
                    }
                }
            }

            function toggleMusic() {
                if (!ytPlayer || !apiReady) return;
                try {
                    if (isPlaying) {
                        ytPlayer.pauseVideo();
                        if (musicBtn) musicBtn.classList.remove('playing');
                    } else {
                        ytPlayer.mute();
                        ytPlayer.playVideo();
                        setTimeout(function() {
                            try {
                                ytPlayer.unMute();
                            } catch (e) {}
                        }, 200);
                        if (musicBtn) musicBtn.classList.add('playing');
                    }
                    isPlaying = !isPlaying;
                } catch (e) {
                    console.warn('Toggle failed:', e);
                }
            }

            function openInvitation(btn) {
                btn.classList.add('opened');
                document.getElementById('invitationBody').classList.add('visible');
                btn.disabled = true;
                btn.textContent = '\u2713 Terbuka';
                btn.style.cursor = 'default';
                setTimeout(function() {
                    if (musicBtn) musicBtn.style.display = 'flex';
                    tryPlayMusic();
                    setTimeout(function() {
                        document.getElementById('couple').scrollIntoView({
                            behavior: 'smooth'
                        });
                    }, 600);
                }, 300);
            }

            var countdownEl = document.getElementById('countdown');
            if (countdownEl) {
                var targetDate = new Date(countdownEl.getAttribute('data-date') + 'T00:00:00').getTime();

                function updateCountdown() {
                    var now = new Date().getTime();
                    var diff = targetDate - now;
                    var els = {
                        days: document.getElementById('cd-days'),
                        hours: document.getElementById('cd-hours'),
                        minutes: document.getElementById('cd-minutes'),
                        seconds: document.getElementById('cd-seconds')
                    };
                    if (diff <= 0) {
                        els.days.textContent = '0';
                        els.hours.textContent = '0';
                        els.minutes.textContent = '0';
                        els.seconds.textContent = '0';
                        return;
                    }
                    var vals = {
                        days: Math.floor(diff / (1000 * 60 * 60 * 24)),
                        hours: Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)),
                        minutes: Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)),
                        seconds: Math.floor((diff % (1000 * 60)) / 1000)
                    };
                    for (var k in els) {
                        if (els[k].textContent !== String(vals[k])) {
                            els[k].textContent = vals[k];
                            els[k].classList.remove('pop');
                            void els[k].offsetWidth;
                            els[k].classList.add('pop');
                        }
                    }
                }
                updateCountdown();
                setInterval(updateCountdown, 1000);
            }

            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });
            document.querySelectorAll('.animate-fade').forEach(function(el) {
                observer.observe(el);
            });

            document.querySelectorAll('.gallery-item').forEach(function(el) {
                el.addEventListener('click', function() {
                    var src = this.getAttribute('data-src');
                    if (src) {
                        openLightbox(src);
                    }
                });
            });

            function openLightbox(src) {
                document.getElementById('lightbox-img').src = src;
                document.getElementById('lightbox').classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox(e) {
                if (e.target === e.currentTarget || e.target.tagName === 'BUTTON') {
                    document.getElementById('lightbox').classList.remove('active');
                    document.body.style.overflow = '';
                }
            }
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.getElementById('lightbox').classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            function submitForm(form) {
                var btn = form.querySelector('.btn-submit');
                btn.classList.add('loading');
                btn.disabled = true;
                return true;
            }

            /* ─── WEB SHARE API ─── */
            var shareBtn = document.getElementById('shareBtn');
            if (shareBtn && navigator.share) {
                shareBtn.style.display = 'flex';
                window.shareInvitation = function() {
                    navigator.share({
                        title: '{{ $invitation->title }}',
                        text: 'Undangan pernikahan {{ $invitation->groom_name ?? "Mempelai" }} & {{ $invitation->bride_name ?? "Mempelai" }}',
                        url: window.location.href
                    }).catch(function(){});
                };
            }
            function copyBankAccount() {
                var acc = document.getElementById('bankAccount');
                if (!acc) return;
                if (!navigator.clipboard) {
                    var ta = document.createElement('textarea');
                    ta.value = acc.textContent;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    try {
                        document.execCommand('copy');
                    } catch (e) {}
                    document.body.removeChild(ta);
                    var btn = document.querySelector('.copy-btn');
                    var orig = btn.textContent;
                    btn.textContent = 'Tersalin!';
                    setTimeout(function() {
                        btn.textContent = orig;
                    }, 2000);
                    return;
                }
                navigator.clipboard.writeText(acc.textContent).then(function() {
                    var btn = document.querySelector('.copy-btn');
                    var orig = btn.textContent;
                    btn.textContent = 'Tersalin!';
                    setTimeout(function() {
                        btn.textContent = orig;
                    }, 2000);
                });
            }
        </script></body></html>
