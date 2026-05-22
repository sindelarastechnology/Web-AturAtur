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
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Jost:wght@200;300;400;500;600&family=Alex+Brush&display=swap"
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

        /* ─── RESET & BASE ─── */
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }

        body {
            font-family: 'Jost', sans-serif;
            color: #2a1f1a;
            background: #0e0a08;
            line-height: 1.7;
            overflow-x: hidden;
            cursor: none;
        }

        /* ─── CUSTOM CURSOR ─── */
        .cursor {
            position: fixed;
            width: 8px;
            height: 8px;
            background: #c9956a;
            border-radius: 50%;
            pointer-events: none;
            z-index: 99999;
            transform: translate(-50%, -50%);
            transition: transform 0.1s;
            mix-blend-mode: difference;
        }

        .cursor-ring {
            position: fixed;
            width: 36px;
            height: 36px;
            border: 1px solid rgba(201, 149, 106, 0.5);
            border-radius: 50%;
            pointer-events: none;
            z-index: 99998;
            transform: translate(-50%, -50%);
            transition: all 0.15s ease;
        }

        @media (hover: none) {

            .cursor,
            .cursor-ring {
                display: none;
            }

            body {
                cursor: auto;
            }
        }

        /* ─── CSS VARIABLES ─── */
        :root {
            --gold: #c9956a;
            --gold-light: #e8c49a;
            --gold-pale: #f5e6d3;
            --cream: #fdf8f3;
            --dark: #0e0a08;
            --dark-mid: #1a1410;
            --brown: #5c3d2a;
            --text: #3d2b1f;
            --text-muted: #8a7060;
            --border: rgba(201, 149, 106, 0.2);
        }

        /* ─── CANVAS PARTICLES ─── */
        #particleCanvas {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            opacity: 0.6;
        }

        /* ─── PRELOADER ─── */
        #preloader {
            position: fixed;
            inset: 0;
            background: var(--dark);
            z-index: 100000;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 1.5rem;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        #preloader.hide {
            opacity: 0;
            visibility: hidden;
        }

        .preloader-ring {
            width: 64px;
            height: 64px;
            border: 1px solid rgba(201, 149, 106, 0.15);
            border-top-color: var(--gold);
            border-radius: 50%;
            animation: spinLoader 1.2s linear infinite;
        }

        @keyframes spinLoader {
            to {
                transform: rotate(360deg);
            }
        }

        .preloader-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 0.9rem;
            letter-spacing: 5px;
            color: rgba(201, 149, 106, 0.6);
            text-transform: uppercase;
            font-weight: 300;
        }

        /* ─── COVER ─── */
        #cover {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--dark);
            overflow: hidden;
            text-align: center;
            z-index: 2;
        }

        .cover-bg {
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse 60% 50% at 50% 0%, rgba(201, 149, 106, 0.08) 0%, transparent 70%),
                radial-gradient(ellipse 40% 60% at 80% 100%, rgba(120, 60, 30, 0.12) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 20% 80%, rgba(201, 149, 106, 0.06) 0%, transparent 60%);
        }

        /* Ornate corner SVG frames */
        .cover-corner {
            position: absolute;
            width: 160px;
            height: 160px;
            opacity: 0.35;
        }

        .cover-corner.tl {
            top: 0;
            left: 0;
        }

        .cover-corner.tr {
            top: 0;
            right: 0;
            transform: scaleX(-1);
        }

        .cover-corner.bl {
            bottom: 0;
            left: 0;
            transform: scaleY(-1);
        }

        .cover-corner.br {
            bottom: 0;
            right: 0;
            transform: scale(-1, -1);
        }

        @media (max-width: 640px) {
            .cover-corner {
                width: 100px;
                height: 100px;
                opacity: 0.25;
            }
        }

        .cover-line-top,
        .cover-line-bottom {
            position: absolute;
            left: 10%;
            right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.3;
        }

        .cover-line-top {
            top: 40px;
        }

        .cover-line-bottom {
            bottom: 40px;
        }

        .cover-content {
            position: relative;
            z-index: 3;
            padding: 3rem 2rem;
            max-width: 640px;
            width: 100%;
        }

        .cover-eyebrow {
            font-family: 'Jost', sans-serif;
            font-size: 0.65rem;
            font-weight: 400;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0;
            animation: revealUp 0.9s ease 0.4s forwards;
        }

        .cover-guest-label {
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(201, 149, 106, 0.5);
            margin-bottom: 0.3rem;
            opacity: 0;
            animation: revealUp 0.9s ease 0.6s forwards;
        }

        .cover-guest-name {
            font-family: 'Alex Brush', cursive;
            font-size: clamp(1.4rem, 4vw, 2rem);
            color: var(--gold-light);
            margin-bottom: 2rem;
            opacity: 0;
            animation: revealUp 0.9s ease 0.8s forwards;
            font-style: normal;
        }

        .cover-ornament {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 1.2rem 0;
            opacity: 0;
            animation: revealFade 1s ease 1s forwards;
        }

        .cover-ornament::before,
        .cover-ornament::after {
            content: '';
            flex: 1;
            max-width: 80px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold));
            opacity: 0.4;
        }

        .cover-ornament::after {
            background: linear-gradient(90deg, var(--gold), transparent);
        }

        .cover-ornament-icon {
            color: var(--gold);
            font-size: 0.8rem;
            letter-spacing: 3px;
            opacity: 0.7;
        }

        .cover-names-wrap {
            margin: 0.5rem 0 1rem;
            opacity: 0;
            animation: revealUp 1.1s ease 1.1s forwards;
        }

        .cover-name-groom,
        .cover-name-bride {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.8rem, 9vw, 5.5rem);
            font-weight: 300;
            color: #fff;
            line-height: 1;
            letter-spacing: -1px;
        }

        .cover-name-groom em,
        .cover-name-bride em {
            font-style: italic;
            color: var(--gold-light);
        }

        .cover-and-symbol {
            font-family: 'Alex Brush', cursive;
            font-size: clamp(2rem, 5vw, 3.5rem);
            color: var(--gold);
            display: block;
            line-height: 1.4;
            opacity: 0.85;
        }

        .cover-date-strip {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            background: rgba(201, 149, 106, 0.08);
            border: 1px solid rgba(201, 149, 106, 0.2);
            padding: 0.6rem 1.8rem;
            border-radius: 2px;
            margin: 1.2rem 0;
            opacity: 0;
            animation: revealUp 1s ease 1.3s forwards;
        }

        .cover-date-strip span {
            font-family: 'Jost', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold-light);
            font-weight: 300;
        }

        .cover-date-strip .dot {
            width: 3px;
            height: 3px;
            background: var(--gold);
            border-radius: 50%;
            opacity: 0.5;
        }

        /* COUNTDOWN */
        .countdown {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin: 1.5rem 0;
            opacity: 0;
            animation: revealFade 1s ease 1.5s forwards;
        }

        .countdown-item {
            position: relative;
            min-width: 68px;
            padding: 0.75rem 0.5rem;
            border: 1px solid rgba(201, 149, 106, 0.2);
            background: rgba(201, 149, 106, 0.05);
            text-align: center;
            backdrop-filter: blur(4px);
        }

        .countdown-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(201, 149, 106, 0.04), transparent);
        }

        .countdown-item .num {
            display: block;
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 300;
            color: #fff;
            line-height: 1;
        }

        .countdown-item .label {
            font-family: 'Jost', sans-serif;
            font-size: 0.55rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0.8;
            margin-top: 4px;
            display: block;
        }

        .envelope-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            cursor: pointer;
            padding: 1rem 2.5rem;
            font-family: 'Jost', sans-serif;
            font-size: 0.75rem;
            font-weight: 400;
            letter-spacing: 4px;
            text-transform: uppercase;
            transition: all 0.4s ease;
            margin-top: 1rem;
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: revealFade 1s ease 1.7s forwards;
        }

        .envelope-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gold);
            transform: translateX(-101%);
            transition: transform 0.4s ease;
            z-index: 0;
        }

        .envelope-btn:hover {
            color: var(--dark);
        }

        .envelope-btn:hover::before {
            transform: translateX(0);
        }

        .envelope-btn span {
            position: relative;
            z-index: 1;
        }

        .envelope-btn.opened {
            background: var(--gold);
            color: var(--dark);
            cursor: default;
            pointer-events: none;
        }

        .envelope-btn.opened::before {
            display: none;
        }

        @keyframes revealUp {
            0% {
                opacity: 0;
                transform: translateY(24px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes revealFade {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes countdownPop {
            0% {
                transform: scale(1);
            }

            40% {
                transform: scale(1.2);
                color: var(--gold-light);
            }

            100% {
                transform: scale(1);
            }
        }

        .countdown-item .num.pop {
            animation: countdownPop 0.35s ease;
        }

        /* ─── INVITATION BODY ─── */
        .invitation-body {
            display: none;
            background: var(--cream);
        }

        .invitation-body.visible {
            display: block;
        }

        /* ─── MUSIC BTN ─── */
        .floating-music {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 9998;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--dark);
            border: 1px solid var(--gold);
            color: var(--gold);
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
            transition: all 0.3s;
            display: none;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .floating-music:hover {
            background: var(--gold);
            color: var(--dark);
            transform: scale(1.08);
        }

        .floating-music.playing {
            border-color: var(--gold-light);
        }

        .floating-music.playing {
            animation: musicPulse 2.5s ease-in-out infinite;
        }

        @keyframes musicPulse {

            0%,
            100% {
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4), 0 0 0 0 rgba(201, 149, 106, 0.4);
            }

            50% {
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4), 0 0 0 10px rgba(201, 149, 106, 0);
            }
        }

        /* ─── SECTIONS SHARED ─── */
        section {
            padding: 6rem 0;
            position: relative;
        }

        .section-bg-alt {
            background: #f7f0e8;
        }

        .section-bg-dark {
            background: var(--dark-mid);
        }

        .container {
            max-width: 840px;
            margin: 0 auto;
            padding: 0 1.75rem;
            position: relative;
            z-index: 1;
        }

        .section-kicker {
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem;
            font-weight: 400;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: var(--gold);
            text-align: center;
            margin-bottom: 0.6rem;
        }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 300;
            color: var(--text);
            text-align: center;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .section-title em {
            font-style: italic;
            color: var(--brown);
        }

        .section-title-light {
            color: #fff;
        }

        .section-title-light em {
            color: var(--gold-light);
        }

        .divider-ornate {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin: 1.2rem auto 3rem;
        }

        .divider-ornate::before,
        .divider-ornate::after {
            content: '';
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold));
            opacity: 0.4;
        }

        .divider-ornate::after {
            background: linear-gradient(90deg, var(--gold), transparent);
        }

        .divider-ornate-icon {
            width: 24px;
            height: 24px;
            color: var(--gold);
            opacity: 0.7;
            flex-shrink: 0;
        }

        /* ─── SECTION SEPARATOR ─── */
        .sep {
            width: 100%;
            overflow: hidden;
            line-height: 0;
            background: var(--cream);
            position: relative;
            z-index: 2;
        }

        .sep.dark-to-cream {
            background: var(--dark-mid);
        }

        .sep svg {
            display: block;
            width: 100%;
        }

        /* ─── QUOTE ─── */
        #quote {
            background: var(--dark);
            padding: 5rem 0;
            position: relative;
            overflow: hidden;
        }

        #quote::before {
            content: '\201C';
            font-family: 'Cormorant Garamond', serif;
            font-size: 30rem;
            color: rgba(201, 149, 106, 0.03);
            position: absolute;
            top: -8rem;
            left: -3rem;
            line-height: 1;
            pointer-events: none;
        }

        .quote-inner {
            max-width: 640px;
            margin: 0 auto;
            text-align: center;
        }

        .quote-verse {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1.1rem, 3vw, 1.55rem);
            font-style: italic;
            font-weight: 300;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.9;
            margin-bottom: 1.5rem;
        }

        .quote-source {
            font-family: 'Jost', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0.7;
        }

        /* ─── COUPLE ─── */
        #couple {
            background: var(--cream);
        }

        .couple-layout {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        @media (max-width: 600px) {
            .couple-layout {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 2rem;
            }

            .couple-card:last-child {
                order: 3;
            }

            .couple-sep {
                order: 2;
            }
        }

        .couple-card {
            text-align: center;
        }

        .couple-photo-frame {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 0 auto 1.5rem;
        }

        @media (max-width: 600px) {
            .couple-photo-frame {
                width: 160px;
                height: 160px;
            }
        }

        .couple-photo-frame::before {
            content: '';
            position: absolute;
            inset: -8px;
            border: 1px solid rgba(201, 149, 106, 0.25);
            border-radius: 50%;
            animation: frameRotate 12s linear infinite;
        }

        .couple-photo-frame::after {
            content: '';
            position: absolute;
            inset: -16px;
            border: 1px solid rgba(201, 149, 106, 0.1);
            border-radius: 50%;
            animation: frameRotate 18s linear infinite reverse;
        }

        @keyframes frameRotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .couple-photo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            position: relative;
            z-index: 1;
            border: 3px solid var(--cream);
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12);
        }

        .couple-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 400;
            color: var(--text);
            margin-bottom: 0.3rem;
        }

        .couple-role {
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }

        .couple-parents {
            font-family: 'Jost', sans-serif;
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.7;
            font-weight: 300;
        }

        .couple-parents strong {
            color: var(--text);
            font-weight: 400;
        }

        .couple-sep {
            text-align: center;
            padding: 1rem;
        }

        .couple-sep-symbol {
            font-family: 'Alex Brush', cursive;
            font-size: 3.5rem;
            color: var(--gold);
            opacity: 0.7;
            line-height: 1;
            display: block;
        }

        .couple-sep-line {
            width: 1px;
            height: 50px;
            background: linear-gradient(to bottom, transparent, var(--gold), transparent);
            margin: 0.75rem auto;
            opacity: 0.3;
        }

        @media (max-width: 600px) {
            .couple-sep-line {
                width: 60px;
                height: 1px;
                background: linear-gradient(to right, transparent, var(--gold), transparent);
            }
        }

        /* ─── EVENTS ─── */
        #events {
            background: #f7f0e8;
        }

        .events-list {
            display: grid;
            gap: 1.5rem;
            max-width: 640px;
            margin: 0 auto;
        }

        .event-card {
            position: relative;
            background: var(--cream);
            border: 1px solid rgba(201, 149, 106, 0.2);
            overflow: hidden;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .event-card::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--gold), var(--gold-light));
        }

        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
        }

        .event-card-inner {
            padding: 2rem 2rem 2rem 2.5rem;
        }

        .event-badge {
            display: inline-block;
            font-family: 'Jost', sans-serif;
            font-size: 0.55rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold);
            border: 1px solid rgba(201, 149, 106, 0.3);
            padding: 0.25rem 0.8rem;
            margin-bottom: 1rem;
        }

        .event-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.7rem;
            font-weight: 400;
            color: var(--text);
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .event-meta {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            margin-bottom: 1.25rem;
        }

        .event-meta-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .event-meta-icon {
            width: 14px;
            height: 14px;
            color: var(--gold);
            opacity: 0.7;
            flex-shrink: 0;
        }

        .event-meta-text {
            font-family: 'Jost', sans-serif;
            font-size: 0.82rem;
            color: var(--text-muted);
            font-weight: 300;
        }

        .event-meta-text strong {
            color: var(--text);
            font-weight: 400;
        }

        .event-venue {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-style: italic;
            color: var(--brown);
            margin-bottom: 0.2rem;
        }

        .map-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'Jost', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            text-decoration: none;
            border-bottom: 1px solid rgba(201, 149, 106, 0.3);
            padding-bottom: 2px;
            transition: all 0.3s;
        }

        .map-btn:hover {
            color: var(--brown);
            border-color: var(--brown);
        }

        .map-btn svg {
            width: 12px;
            height: 12px;
        }

        /* ─── LOVE STORY ─── */
        #story {
            background: var(--dark-mid);
        }

        .story-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            font-weight: 300;
            font-style: italic;
            color: rgba(255, 255, 255, 0.75);
            line-height: 2;
            text-align: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .story-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin: 2rem 0;
        }

        .story-divider-line {
            flex: 1;
            max-width: 80px;
            height: 1px;
            background: rgba(201, 149, 106, 0.2);
        }

        .story-divider-dot {
            width: 5px;
            height: 5px;
            background: var(--gold);
            border-radius: 50%;
            opacity: 0.5;
        }

        /* ─── GALLERY ─── */
        #gallery {
            background: var(--cream);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        @media (max-width: 540px) {
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .gallery-item {
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            cursor: pointer;
        }

        .gallery-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(14, 10, 8, 0.5) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .gallery-item:hover::after {
            opacity: 1;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            opacity: 0;
        }

        .gallery-item img.loaded {
            opacity: 1;
        }

        .gallery-item:hover img {
            transform: scale(1.08);
        }

        .gallery-zoom-icon {
            position: absolute;
            bottom: 0.75rem;
            right: 0.75rem;
            color: white;
            opacity: 0;
            z-index: 2;
            transition: opacity 0.3s;
        }

        .gallery-zoom-icon svg {
            width: 18px;
            height: 18px;
        }

        .gallery-item:hover .gallery-zoom-icon {
            opacity: 1;
        }

        /* ─── LIGHTBOX ─── */
        .lightbox {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: rgba(0, 0, 0, 0.95);
            align-items: center;
            justify-content: center;
            padding: 2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .lightbox.active {
            display: flex;
        }

        .lightbox.visible {
            opacity: 1;
        }

        .lightbox img {
            max-width: 100%;
            max-height: 90vh;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
            transform: scale(0.95);
            transition: transform 0.4s ease;
        }

        .lightbox.visible img {
            transform: scale(1);
        }

        .lightbox-close {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            color: white;
            cursor: pointer;
            font-size: 1.1rem;
            transition: all 0.3s;
        }

        .lightbox-close:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--dark);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            transition: all 0.3s;
        }

        .lightbox-nav:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--dark);
        }

        .lightbox-prev {
            left: 1rem;
        }

        .lightbox-next {
            right: 1rem;
        }

        /* ─── BANK / GIFT ─── */
        #bank {
            background: #f7f0e8;
        }

        .bank-outer {
            max-width: 420px;
            margin: 0 auto;
            perspective: 1000px;
        }

        .bank-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            padding: 2.5rem;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
            transform-style: preserve-3d;
            transition: transform 0.6s ease;
        }

        .bank-outer:hover .bank-card {
            transform: rotateY(-4deg) rotateX(2deg);
        }

        .bank-card-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #1a0f0a 0%, #2d1f14 50%, #1a0f0a 100%);
        }

        .bank-card-noise {
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.03'/%3E%3C/svg%3E");
            opacity: 0.4;
        }

        .bank-card-shimmer {
            position: absolute;
            top: -100%;
            left: -100%;
            width: 80%;
            height: 300%;
            background: linear-gradient(120deg, transparent 30%, rgba(255, 255, 255, 0.03) 50%, transparent 70%);
            animation: shimmerCard 4s ease-in-out infinite;
        }

        @keyframes shimmerCard {

            0%,
            100% {
                transform: translateX(-30%) skewX(-15deg);
            }

            50% {
                transform: translateX(200%) skewX(-15deg);
            }
        }

        .bank-card-content {
            position: relative;
            z-index: 2;
        }

        .bank-logo {
            font-family: 'Jost', sans-serif;
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold-light);
            margin-bottom: 1.5rem;
        }

        .bank-chip {
            width: 38px;
            height: 28px;
            background: linear-gradient(135deg, #d4af70, #b8962e, #d4af70);
            border-radius: 4px;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .bank-chip::after {
            content: '';
            position: absolute;
            top: 30%;
            left: 25%;
            right: 25%;
            height: 40%;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 2px;
        }

        .bank-acct-label {
            font-family: 'Jost', sans-serif;
            font-size: 0.55rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.35);
            margin-bottom: 0.4rem;
        }

        .bank-acct-number {
            font-family: 'Courier New', monospace;
            font-size: 1.4rem;
            letter-spacing: 4px;
            color: white;
            margin-bottom: 1.2rem;
        }

        .bank-acct-name {
            font-family: 'Jost', sans-serif;
            font-size: 0.75rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 1.5rem;
        }

        .copy-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: transparent;
            border: 1px solid rgba(201, 149, 106, 0.4);
            color: var(--gold-light);
            padding: 0.5rem 1.2rem;
            font-family: 'Jost', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 2px;
        }

        .copy-btn:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--dark);
        }

        .copy-btn svg {
            width: 13px;
            height: 13px;
        }

        /* ─── RSVP ─── */
        #rsvp {
            background: var(--cream);
        }

        .rsvp-container {
            max-width: 520px;
            margin: 0 auto;
        }

        .rsvp-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .form-card {
            background: white;
            border: 1px solid rgba(201, 149, 106, 0.15);
            padding: 2.5rem;
            position: relative;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.05);
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 0.6rem;
            font-weight: 400;
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid rgba(201, 149, 106, 0.2);
            background: #fdf9f5;
            font-family: 'Jost', sans-serif;
            font-size: 0.9rem;
            font-weight: 300;
            color: var(--text);
            transition: border-color 0.3s, box-shadow 0.3s;
            outline: none;
            border-radius: 0;
            appearance: none;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 149, 106, 0.08);
            background: white;
        }

        .form-input[readonly] {
            color: var(--text-muted);
            background: #f5f0ea;
        }

        .form-select-wrap {
            position: relative;
        }

        .form-select-wrap::after {
            content: '';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid var(--gold);
            pointer-events: none;
            opacity: 0.6;
        }

        .form-textarea {
            resize: vertical;
            min-height: 110px;
        }

        .btn-submit {
            width: 100%;
            background: var(--dark);
            border: 1px solid var(--dark);
            color: white;
            padding: 1rem;
            font-family: 'Jost', sans-serif;
            font-size: 0.7rem;
            font-weight: 400;
            letter-spacing: 4px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.4s;
            margin-top: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gold);
            transform: translateX(-101%);
            transition: transform 0.4s ease;
            z-index: 0;
        }

        .btn-submit:hover {
            color: var(--dark);
            border-color: var(--gold);
        }

        .btn-submit:hover::before {
            transform: translateX(0);
        }

        .btn-submit span {
            position: relative;
            z-index: 1;
        }

        .btn-submit:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .btn-submit.loading {
            color: transparent;
        }

        .btn-submit.loading::after {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            z-index: 2;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ─── WISHES ─── */
        #wishes {
            background: #f7f0e8;
        }

        .wish-list {
            margin-top: 3rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .wish-item {
            background: var(--cream);
            border: 1px solid rgba(201, 149, 106, 0.15);
            padding: 1.5rem 1.75rem;
            position: relative;
            transition: transform 0.3s;
        }

        .wish-item::before {
            content: '\201C';
            font-family: 'Cormorant Garamond', serif;
            font-size: 4rem;
            color: var(--gold);
            opacity: 0.12;
            position: absolute;
            top: 0.5rem;
            left: 1rem;
            line-height: 1;
        }

        .wish-item:hover {
            transform: translateX(4px);
        }

        .wish-sender {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.4rem;
        }

        .wish-msg {
            font-family: 'Jost', sans-serif;
            font-size: 0.88rem;
            font-weight: 300;
            color: var(--text-muted);
            line-height: 1.75;
            margin-bottom: 0.5rem;
        }

        .wish-date {
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0.6;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* ─── ALERT ─── */
        .alert-success {
            background: #f0faf5;
            border: 1px solid rgba(0, 150, 80, 0.2);
            border-left: 3px solid #00a060;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-family: 'Jost', sans-serif;
            font-size: 0.85rem;
            color: #1a6040;
        }

        /* ─── FOOTER ─── */
        footer {
            background: var(--dark);
            padding: 4rem 2rem 3rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 10%;
            right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            opacity: 0.25;
        }

        .footer-names {
            font-family: 'Alex Brush', cursive;
            font-size: 2.5rem;
            color: white;
            margin-bottom: 0.25rem;
        }

        .footer-date {
            font-family: 'Jost', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold);
            opacity: 0.6;
            margin-bottom: 2rem;
        }

        .footer-credit {
            font-family: 'Jost', sans-serif;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.2);
            letter-spacing: 2px;
        }

        .footer-credit a {
            color: rgba(201, 149, 106, 0.5);
            text-decoration: none;
        }

        /* ─── ANIMATE ON SCROLL ─── */
        .reveal {
            opacity: 0;
            transform: translateY(32px);
            transition: opacity 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                transform 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-delay-1 {
            transition-delay: 0.1s;
        }

        .reveal-delay-2 {
            transition-delay: 0.2s;
        }

        .reveal-delay-3 {
            transition-delay: 0.3s;
        }

        /* ─── MISC ─── */
        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        @media (max-width: 480px) {
            section {
                padding: 4rem 0;
            }

            .form-card {
                padding: 1.75rem;
            }

            .event-card-inner {
                padding: 1.5rem 1.5rem 1.5rem 2rem;
            }
        }
        .floating-share {
            position: fixed; bottom: 2rem; left: 2rem; z-index: 9998;
            width: 48px; height: 48px; border-radius: 50%;
            background: var(--dark); border: 1px solid var(--gold); color: var(--gold);
            font-size: 1.3rem; cursor: pointer;
            box-shadow: 0 4px 30px rgba(0,0,0,0.4);
            transition: all 0.3s;
            display: none; align-items: center; justify-content: center;
            backdrop-filter: blur(10px);
        }
        .floating-share:hover { background: var(--gold); color: var(--dark); transform: scale(1.08); }
    @if ($invitation->custom_css)
    {{ $invitation->custom_css }}
    @endif
    </style>
</head>

<body>

    <!-- Custom Cursor -->
    <div class="cursor" id="cursor"></div>
    <div class="cursor-ring" id="cursorRing"></div>

    <!-- Preloader -->
    <div id="preloader">
        <div class="preloader-ring"></div>
        <div class="preloader-text">Memuat Undangan</div>
    </div>

    <!-- Particle Canvas -->
    <canvas id="particleCanvas"></canvas>

    <!-- ════════════════════════════════════
     COVER
════════════════════════════════════ -->
    <div id="cover">
        <div class="cover-bg"></div>

        <!-- Ornate corners -->
        <svg class="cover-corner tl" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 8 L8 70 M8 8 L70 8" stroke="#c9956a" stroke-width="0.8" opacity="0.6" />
            <path d="M8 8 L40 40" stroke="#c9956a" stroke-width="0.5" opacity="0.3" />
            <circle cx="8" cy="8" r="3" fill="none" stroke="#c9956a" stroke-width="0.8"
                opacity="0.6" />
            <circle cx="8" cy="8" r="8" fill="none" stroke="#c9956a" stroke-width="0.4"
                opacity="0.3" />
            <path d="M30 8 C30 20 20 30 8 30" stroke="#c9956a" stroke-width="0.5" fill="none" opacity="0.35" />
            <path d="M50 8 C50 35 35 50 8 50" stroke="#c9956a" stroke-width="0.4" fill="none" opacity="0.2" />
            <path d="M8 30 L14 24 L20 30 L14 36Z" fill="#c9956a" opacity="0.15" />
            <path d="M30 8 L36 14 L30 20 L24 14Z" fill="#c9956a" opacity="0.15" />
        </svg>
        <svg class="cover-corner tr" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 8 L8 70 M8 8 L70 8" stroke="#c9956a" stroke-width="0.8" opacity="0.6" />
            <path d="M8 8 L40 40" stroke="#c9956a" stroke-width="0.5" opacity="0.3" />
            <circle cx="8" cy="8" r="3" fill="none" stroke="#c9956a" stroke-width="0.8"
                opacity="0.6" />
            <circle cx="8" cy="8" r="8" fill="none" stroke="#c9956a" stroke-width="0.4"
                opacity="0.3" />
            <path d="M30 8 C30 20 20 30 8 30" stroke="#c9956a" stroke-width="0.5" fill="none" opacity="0.35" />
            <path d="M50 8 C50 35 35 50 8 50" stroke="#c9956a" stroke-width="0.4" fill="none" opacity="0.2" />
        </svg>
        <svg class="cover-corner bl" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 8 L8 70 M8 8 L70 8" stroke="#c9956a" stroke-width="0.8" opacity="0.6" />
            <circle cx="8" cy="8" r="3" fill="none" stroke="#c9956a" stroke-width="0.8"
                opacity="0.6" />
            <path d="M30 8 C30 20 20 30 8 30" stroke="#c9956a" stroke-width="0.5" fill="none" opacity="0.35" />
            <path d="M50 8 C50 35 35 50 8 50" stroke="#c9956a" stroke-width="0.4" fill="none" opacity="0.2" />
        </svg>
        <svg class="cover-corner br" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 8 L8 70 M8 8 L70 8" stroke="#c9956a" stroke-width="0.8" opacity="0.6" />
            <circle cx="8" cy="8" r="3" fill="none" stroke="#c9956a" stroke-width="0.8"
                opacity="0.6" />
            <path d="M30 8 C30 20 20 30 8 30" stroke="#c9956a" stroke-width="0.5" fill="none" opacity="0.35" />
            <path d="M50 8 C50 35 35 50 8 50" stroke="#c9956a" stroke-width="0.4" fill="none" opacity="0.2" />
        </svg>

        <div class="cover-line-top"></div>
        <div class="cover-line-bottom"></div>

        <div class="cover-content">
            <div class="cover-eyebrow">Undangan Pernikahan</div>

            <div class="cover-ornament">
                <span class="cover-ornament-icon">✦ ✦ ✦</span>
            </div>

            <div class="cover-guest-label">Kepada Yang Terhormat</div>
            <div class="cover-guest-name">{{ $guestName }}</div>

            <div class="cover-names-wrap">
                <div class="cover-name-groom"><em>{{ $invitation->groom_nickname ?? $invitation->groom_name }}</em>
                </div>
                <span class="cover-and-symbol">&amp;</span>
                <div class="cover-name-bride"><em>{{ $invitation->bride_nickname ?? $invitation->bride_name }}</em>
                </div>
            </div>

            @php $firstEvent = $invitation->events->first(); @endphp
            @if ($firstEvent)
                <div class="cover-date-strip">
                    <span class="dot"></span>
                    <span>{{ \Carbon\Carbon::parse($firstEvent->date)->isoFormat('D MMMM YYYY') }}</span>
                    <span class="dot"></span>
                </div>
                <div class="countdown" id="countdown"
                    data-date="{{ \Carbon\Carbon::parse($firstEvent->date)->format('Y-m-d') }}">
                    <div class="countdown-item"><span class="num" id="cd-days">0</span><span
                            class="label">Hari</span></div>
                    <div class="countdown-item"><span class="num" id="cd-hours">0</span><span
                            class="label">Jam</span></div>
                    <div class="countdown-item"><span class="num" id="cd-minutes">0</span><span
                            class="label">Menit</span></div>
                    <div class="countdown-item"><span class="num" id="cd-seconds">0</span><span
                            class="label">Detik</span></div>
                </div>
            @endif

            <button class="envelope-btn" id="openBtn" onclick="openInvitation(this)">
                <span>✦ &nbsp;Buka Undangan &nbsp;✦</span>
            </button>
        </div>
    </div>

    <!-- Music Button -->
    @php $ytId = $invitation->music_url ? (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $invitation->music_url, $m) ? $m[1] : null) : null; @endphp
    @if ($ytId)
        <button class="floating-music" id="musicToggle" onclick="toggleMusic()">&#9835;</button>
        <div id="youtube-player" data-video="{{ $ytId }}"></div>
    @endif

    <!-- Share Button -->
    <button class="floating-share" id="shareBtn" onclick="shareInvitation()" style="display:none;" title="Bagikan Undangan">&#8599;</button>

    <!-- ════════════════════════════════════
     INVITATION BODY
════════════════════════════════════ -->
    <div class="invitation-body" id="invitationBody">

        @if (session('success'))
            <div style="max-width:840px;margin:1.5rem auto 0;padding:0 1.75rem;">
                <div class="alert-success">{{ session('success') }}</div>
            </div>
        @endif

        <!-- QUOTE -->
        @if ($invitation->opening_quote)
            <section id="quote">
                <div class="container">
                    <div class="quote-inner reveal">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none"
                            style="margin:0 auto 1.5rem;opacity:0.4;">
                            <path d="M4 20 C4 12 9 6 16 4 L14 8 C10 10 8 14 8 18 L12 18 L12 26 L4 26 Z"
                                fill="#c9956a" />
                            <path d="M20 20 C20 12 25 6 32 4 L30 8 C26 10 24 14 24 18 L28 18 L28 26 L20 26 Z"
                                fill="#c9956a" />
                        </svg>
                        <p class="quote-verse">{{ $invitation->opening_quote }}</p>
                        <div
                            style="margin-top:1.5rem;display:flex;align-items:center;justify-content:center;gap:0.5rem;">
                            <div style="width:30px;height:1px;background:rgba(201,149,106,0.3);"></div>
                            <div style="width:5px;height:5px;background:var(--gold);border-radius:50%;opacity:0.5;">
                            </div>
                            <div style="width:30px;height:1px;background:rgba(201,149,106,0.3);"></div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- COUPLE -->
        <section id="couple">
            <div class="container">
                <div class="section-kicker reveal">The Happy Couple</div>
                <h2 class="section-title reveal reveal-delay-1">Mempelai <em>Kami</em></h2>
                <div class="divider-ornate reveal reveal-delay-2">
                    <svg class="divider-ornate-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z" />
                    </svg>
                </div>
                <div class="couple-layout reveal">
                    <div class="couple-card">
                        <div class="couple-photo-frame">
                            <img src="{{ $invitation->groom_photo ? asset('storage/' . $invitation->groom_photo) : 'data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22><rect fill=%22%23f5eae6%22 width=%22200%22 height=%22200%22 rx=%22100%22/><text fill=%22%23c9956a%22 font-size=%2260%22 text-anchor=%22middle%22 x=%22100%22 y=%22120%22>&#9794;</text></svg>' }}"
                                alt="{{ $invitation->groom_name }}" class="couple-photo">
                        </div>
                        <div class="couple-role">Mempelai Pria</div>
                        <div class="couple-name">{{ $invitation->groom_name }}</div>
                        <div class="couple-parents">
                            Putra dari<br>
                            <strong>{{ $invitation->groom_father ?? '—' }}</strong> &amp;
                            <strong>{{ $invitation->groom_mother ?? '—' }}</strong>
                        </div>
                    </div>

                    <div class="couple-sep">
                        <div class="couple-sep-line"></div>
                        <span class="couple-sep-symbol">&amp;</span>
                        <div class="couple-sep-line"></div>
                    </div>

                    <div class="couple-card">
                        <div class="couple-photo-frame">
                            <img src="{{ $invitation->bride_photo ? asset('storage/' . $invitation->bride_photo) : 'data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22><rect fill=%22%23f5eae6%22 width=%22200%22 height=%22200%22 rx=%22100%22/><text fill=%22%23c9956a%22 font-size=%2260%22 text-anchor=%22middle%22 x=%22100%22 y=%22120%22>&#9792;</text></svg>' }}"
                                alt="{{ $invitation->bride_name }}" class="couple-photo">
                        </div>
                        <div class="couple-role">Mempelai Wanita</div>
                        <div class="couple-name">{{ $invitation->bride_name }}</div>
                        <div class="couple-parents">
                            Putri dari<br>
                            <strong>{{ $invitation->bride_father ?? '—' }}</strong> &amp;
                            <strong>{{ $invitation->bride_mother ?? '—' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- EVENTS -->
        @if ($invitation->events->count() > 0)
            <section id="events">
                <div class="container">
                    <div class="section-kicker reveal">Save The Date</div>
                    <h2 class="section-title reveal reveal-delay-1">Rangkaian <em>Acara</em></h2>
                    <div class="divider-ornate reveal reveal-delay-2">
                        <svg class="divider-ornate-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z" />
                        </svg>
                    </div>
                    <div class="events-list">
                        @foreach ($invitation->events as $event)
                            <div class="event-card reveal" style="transition-delay: {{ $loop->index * 0.12 }}s;">
                                <div class="event-card-inner">
                                    <div class="event-badge">{{ $event->type }}</div>
                                    <div class="event-title">{{ $event->title }}</div>
                                    <div class="event-meta">
                                        <div class="event-meta-row">
                                            <svg class="event-meta-icon" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.5">
                                                <rect x="3" y="4" width="18" height="18" rx="2" />
                                                <line x1="16" y1="2" x2="16" y2="6" />
                                                <line x1="8" y1="2" x2="8" y2="6" />
                                                <line x1="3" y1="10" x2="21" y2="10" />
                                            </svg>
                                            <span
                                                class="event-meta-text"><strong>{{ \Carbon\Carbon::parse($event->date)->isoFormat('dddd, D MMMM YYYY') }}</strong></span>
                                        </div>
                                        <div class="event-meta-row">
                                            <svg class="event-meta-icon" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.5">
                                                <circle cx="12" cy="12" r="9" />
                                                <polyline points="12 7 12 12 15 15" />
                                            </svg>
                                            <span class="event-meta-text">
                                                Pukul {{ \Carbon\Carbon::parse($event->time_start)->format('H:i') }}
                                                @if ($event->time_end)
                                                    – {{ \Carbon\Carbon::parse($event->time_end)->format('H:i') }} WITA
                                                @else
                                                    WITA
                                                @endif
                                            </span>
                                        </div>
                                        @if ($event->venue_name)
                                            <div class="event-meta-row">
                                                <svg class="event-meta-icon" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="1.5">
                                                    <path
                                                        d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                                                    <circle cx="12" cy="9" r="2.5" />
                                                </svg>
                                                <span class="event-meta-text">
                                                    <div class="event-venue">{{ $event->venue_name }}</div>
                                                    @if ($event->address)
                                                        <span
                                                            style="font-size:0.78rem;color:var(--text-muted);">{{ $event->address }}</span>
                                                    @endif
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    @if ($event->maps_url)
                                        <a href="{{ $event->maps_url }}" target="_blank" class="map-btn">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2">
                                                <path
                                                    d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                                                <circle cx="12" cy="9" r="2.5" />
                                            </svg>
                                            Lihat Peta
                                        </a>
                                    @endif
                                    <a href="{{ url('/calendar/' . $invitation->slug . '/' . $event->id) }}" target="_blank" class="map-btn" style="margin-left:0.5rem;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="12" height="12">
                                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        Simpan
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- LOVE STORY -->
        @if ($invitation->love_story)
            <section id="story">
                <div class="container">
                    <div class="section-kicker" style="color:var(--gold-light);opacity:0.7;">Our Story</div>
                    <h2 class="section-title section-title-light reveal reveal-delay-1">Kisah <em>Cinta Kami</em></h2>
                    <div class="divider-ornate reveal reveal-delay-2" style="opacity:0.4;">
                        <svg class="divider-ornate-icon" viewBox="0 0 24 24" fill="currentColor"
                            style="color:var(--gold-light);">
                            <path
                                d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402z" />
                        </svg>
                    </div>
                    <div class="story-divider">
                        <div class="story-divider-line"></div>
                        <div class="story-divider-dot"></div>
                        <div class="story-divider-dot"></div>
                        <div class="story-divider-dot"></div>
                        <div class="story-divider-line"></div>
                    </div>
                    <p class="story-text reveal">{{ $invitation->love_story }}</p>
                </div>
            </section>
        @endif

        <!-- GALLERY -->
        @if ($invitation->photos->count() > 0)
            <section id="gallery">
                <div class="container">
                    <div class="section-kicker reveal">Precious Moments</div>
                    <h2 class="section-title reveal reveal-delay-1">Galeri <em>Foto</em></h2>
                    <div class="divider-ornate reveal reveal-delay-2">
                        <svg class="divider-ornate-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z" />
                        </svg>
                    </div>
                    <div class="gallery-grid">
                        @foreach ($invitation->photos as $photo)
                            <div class="gallery-item reveal" data-src="{{ asset('storage/' . $photo->filename) }}"
                                style="transition-delay:{{ $loop->index * 0.07 }}s;">
                                <img src="{{ asset('storage/' . $photo->filename) }}"
                                    alt="{{ $photo->original_name ?? 'Foto' }}" loading="lazy"
                                    onload="this.classList.add('loaded')">
                                <div class="gallery-zoom-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8" />
                                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                        <line x1="11" y1="8" x2="11" y2="14" />
                                        <line x1="8" y1="11" x2="14" y2="11" />
                                    </svg>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- GIFT / BANK -->
        @if ($invitation->bank_name && $invitation->bank_account)
            <section id="bank">
                <div class="container">
                    <div class="section-kicker reveal">Wedding Gift</div>
                    <h2 class="section-title reveal reveal-delay-1">Kirim <em>Hadiah</em></h2>
                    <div class="divider-ornate reveal reveal-delay-2">
                        <svg class="divider-ornate-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z" />
                        </svg>
                    </div>
                    <div class="bank-outer reveal">
                        <div class="bank-card">
                            <div class="bank-card-bg"></div>
                            <div class="bank-card-noise"></div>
                            <div class="bank-card-shimmer"></div>
                            <div class="bank-card-content">
                                <div class="bank-logo">{{ $invitation->bank_name }}</div>
                                <div class="bank-chip"></div>
                                <div class="bank-acct-label">Nomor Rekening</div>
                                <div class="bank-acct-number" id="bankAccount">{{ $invitation->bank_account }}</div>
                                @if ($invitation->bank_account_name)
                                    <div class="bank-acct-name">{{ $invitation->bank_account_name }}</div>
                                @endif
                                <button class="copy-btn" onclick="copyBankAccount()">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="9" y="9" width="13" height="13" rx="2" />
                                        <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" />
                                    </svg>
                                    <span id="copyBtnText">Salin No. Rekening</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- RSVP -->
        <section id="rsvp">
            <div class="container">
                <div class="rsvp-container">
                    <div class="rsvp-header">
                        <div class="section-kicker reveal">RSVP</div>
                        <h2 class="section-title reveal reveal-delay-1">Konfirmasi <em>Kehadiran</em></h2>
                        <div class="divider-ornate reveal reveal-delay-2">
                            <svg class="divider-ornate-icon" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z" />
                            </svg>
                        </div>
                    </div>

                    @if ($guest)
                        <div class="form-card reveal">
                            <form method="POST" action="{{ url('/rsvp/' . $guest->id) }}"
                                onsubmit="return submitForm(this)">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Nama</label>
                                    <input class="form-input" type="text" value="{{ $guest->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Konfirmasi Kehadiran</label>
                                    <div class="form-select-wrap">
                                        <select class="form-select" name="rsvp_status" required>
                                            <option value="">— Pilih Kehadiran —</option>
                                            <option value="hadir" @if ($guest->rsvp_status === 'hadir') selected @endif>✓
                                                &nbsp;Dengan Senang Hati Hadir</option>
                                            <option value="tidak_hadir"
                                                @if ($guest->rsvp_status === 'tidak_hadir') selected @endif>✗ &nbsp;Mohon Maaf
                                                Tidak Dapat Hadir</option>
                                            <option value="mungkin" @if ($guest->rsvp_status === 'mungkin') selected @endif>
                                                ? &nbsp;Masih Belum Pasti</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Jumlah Tamu</label>
                                    <div class="form-select-wrap">
                                        <select class="form-select" name="guest_count" required>
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}"
                                                    @if ($guest->guest_count == $i) selected @endif>
                                                    {{ $i }} orang</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn-submit"><span>Kirim Konfirmasi</span></button>
                            </form>
                        </div>
                    @else
                        <div class="form-card reveal"
                            style="text-align:center;padding:3rem;font-family:'Cormorant Garamond',serif;font-style:italic;color:var(--text-muted);font-size:1.1rem;">
                            Hubungi mempelai untuk konfirmasi kehadiran Anda.
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- WISHES -->
        <section id="wishes">
            <div class="container">
                <div class="section-kicker reveal">Wishes & Prayers</div>
                <h2 class="section-title reveal reveal-delay-1">Ucapan <em>&amp; Doa</em></h2>
                <div class="divider-ornate reveal reveal-delay-2">
                    <svg class="divider-ornate-icon" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l2.4 7.4H22l-6.2 4.5 2.4 7.4L12 17l-6.2 4.3 2.4-7.4L2 9.4h7.6z" />
                    </svg>
                </div>

                <div style="max-width:520px;margin:0 auto;">
                    <div class="form-card reveal">
                        <form method="POST" action="{{ url('/wishes/' . $invitation->id) }}"
                            onsubmit="return submitForm(this)">
                            @csrf
                            <div class="form-group">
                                <label class="form-label">Nama</label>
                                <input class="form-input" type="text" name="sender_name"
                                    value="{{ $guest?->name ?? old('sender_name') }}" required maxlength="150"
                                    placeholder="Nama Anda">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Ucapan &amp; Doa</label>
                                <textarea class="form-textarea" name="message" required placeholder="Tulis ucapan dan doa tulus untuk mempelai…">{{ old('message') }}</textarea>
                            </div>
                            <button type="submit" class="btn-submit"><span>Kirim Ucapan</span></button>
                        </form>
                    </div>
                </div>

                @if ($invitation->wishes->count() > 0)
                    <div class="wish-list">
                        @foreach ($invitation->wishes as $wish)
                            <div class="wish-item reveal">
                                <div class="wish-sender">{{ $wish->sender_name }}</div>
                                <div class="wish-msg">{{ $wish->message }}</div>
                                <div class="wish-date">{{ $wish->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">Jadilah yang pertama memberikan ucapan dan doa…</div>
                @endif
            </div>
        </section>

        <!-- FOOTER -->
        <footer>
            <div class="container">
                <div class="footer-names">
                    {{ $invitation->groom_nickname ?? $invitation->groom_name }} &amp;
                    {{ $invitation->bride_nickname ?? $invitation->bride_name }}
                </div>
                @if ($firstEvent)
                    <div class="footer-date">{{ \Carbon\Carbon::parse($firstEvent->date)->isoFormat('D MMMM YYYY') }}
                    </div>
                @endif
                <div class="footer-credit">Dibuat dengan ❤ oleh <a href="{{ config('app.url') }}">AturAtur</a></div>
            </div>
        </footer>

    </div><!-- /invitation-body -->

    <!-- LIGHTBOX -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
        <button class="lightbox-nav lightbox-prev" onclick="lightboxNav(-1)">&#8592;</button>
        <img id="lightbox-img" src="" alt="">
        <button class="lightbox-nav lightbox-next" onclick="lightboxNav(1)">&#8594;</button>
    </div>

    <script>
        /* ─── PRELOADER ─── */
        window.addEventListener('load', function() {
            setTimeout(function() {
                document.getElementById('preloader').classList.add('hide');
            }, 800);
        });

        /* ─── CUSTOM CURSOR ─── */
        var cursor = document.getElementById('cursor');
        var cursorRing = document.getElementById('cursorRing');
        var mouseX = 0,
            mouseY = 0,
            ringX = 0,
            ringY = 0;
        document.addEventListener('mousemove', function(e) {
            mouseX = e.clientX;
            mouseY = e.clientY;
            cursor.style.left = mouseX + 'px';
            cursor.style.top = mouseY + 'px';
        });
        (function animRing() {
            ringX += (mouseX - ringX) * 0.12;
            ringY += (mouseY - ringY) * 0.12;
            cursorRing.style.left = ringX + 'px';
            cursorRing.style.top = ringY + 'px';
            requestAnimationFrame(animRing);
        })();
        document.querySelectorAll('a,button,input,select,textarea,.gallery-item').forEach(function(el) {
            el.addEventListener('mouseenter', function() {
                cursorRing.style.transform = 'translate(-50%,-50%) scale(2)';
                cursorRing.style.borderColor = 'rgba(201,149,106,0.8)';
            });
            el.addEventListener('mouseleave', function() {
                cursorRing.style.transform = 'translate(-50%,-50%) scale(1)';
                cursorRing.style.borderColor = 'rgba(201,149,106,0.5)';
            });
        });

        /* ─── PARTICLE CANVAS ─── */
        (function() {
            var canvas = document.getElementById('particleCanvas');
            if (!canvas) return;
            var ctx = canvas.getContext('2d');
            var particles = [];

            function resize() {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
            resize();
            window.addEventListener('resize', resize);
            for (var i = 0; i < 60; i++) {
                particles.push({
                    x: Math.random() * window.innerWidth,
                    y: Math.random() * window.innerHeight,
                    r: 0.5 + Math.random() * 1.5,
                    vx: (Math.random() - 0.5) * 0.3,
                    vy: (Math.random() - 0.5) * 0.3,
                    a: 0.1 + Math.random() * 0.4,
                    gold: Math.random() > 0.5
                });
            }

            function drawParticles() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                particles.forEach(function(p) {
                    p.x += p.vx;
                    p.y += p.vy;
                    if (p.x < 0) p.x = canvas.width;
                    if (p.x > canvas.width) p.x = 0;
                    if (p.y < 0) p.y = canvas.height;
                    if (p.y > canvas.height) p.y = 0;
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                    ctx.fillStyle = p.gold ? 'rgba(201,149,106,' + p.a + ')' : 'rgba(255,255,255,' + (p.a *
                        0.3) + ')';
                    ctx.fill();
                });
                requestAnimationFrame(drawParticles);
            }
            drawParticles();
        })();

        /* ─── COUNTDOWN ─── */
        var countdownEl = document.getElementById('countdown');
        if (countdownEl) {
            var targetDate = new Date(countdownEl.getAttribute('data-date') + 'T00:00:00').getTime();

            function updateCountdown() {
                var now = Date.now();
                var diff = targetDate - now;
                var els = {
                    days: document.getElementById('cd-days'),
                    hours: document.getElementById('cd-hours'),
                    minutes: document.getElementById('cd-minutes'),
                    seconds: document.getElementById('cd-seconds')
                };
                if (diff <= 0) {
                    ['days', 'hours', 'minutes', 'seconds'].forEach(function(k) {
                        if (els[k]) els[k].textContent = '0';
                    });
                    return;
                }
                var vals = {
                    days: Math.floor(diff / 86400000),
                    hours: Math.floor((diff % 86400000) / 3600000),
                    minutes: Math.floor((diff % 3600000) / 60000),
                    seconds: Math.floor((diff % 60000) / 1000)
                };
                for (var k in vals) {
                    if (!els[k]) continue;
                    var v = String(vals[k]);
                    if (els[k].textContent !== v) {
                        els[k].textContent = v;
                        els[k].classList.remove('pop');
                        void els[k].offsetWidth;
                        els[k].classList.add('pop');
                    }
                }
            }
            updateCountdown();
            setInterval(updateCountdown, 1000);
        }

        /* ─── OPEN INVITATION ─── */
        function openInvitation(btn) {
            btn.classList.add('opened');
            btn.querySelector('span').textContent = '✓   Undangan Terbuka';
            var body = document.getElementById('invitationBody');
            body.classList.add('visible');
            setTimeout(function() {
                var musicBtn = document.getElementById('musicToggle');
                if (musicBtn) musicBtn.style.display = 'flex';
                tryPlayMusic();
                var target = document.getElementById('quote') || document.getElementById('couple');
                if (target) target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 400);
        }

        /* ─── SCROLL REVEAL ─── */
        var revealObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.08,
            rootMargin: '0px 0px -40px 0px'
        });

        function initReveal() {
            document.querySelectorAll('.reveal').forEach(function(el) {
                revealObserver.observe(el);
            });
        }

        /* ─── GALLERY LIGHTBOX ─── */
        var galleryImages = [];
        var currentLightboxIndex = 0;

        function initGallery() {
            var items = document.querySelectorAll('.gallery-item');
            galleryImages = [];
            items.forEach(function(el, i) {
                var src = el.getAttribute('data-src');
                if (src) galleryImages.push(src);
                el.addEventListener('click', function() {
                    openLightbox(i);
                });
            });
        }

        function openLightbox(index) {
            currentLightboxIndex = index;
            var lb = document.getElementById('lightbox');
            var img = document.getElementById('lightbox-img');
            img.src = galleryImages[index];
            lb.classList.add('active');
            document.body.style.overflow = 'hidden';
            setTimeout(function() {
                lb.classList.add('visible');
            }, 10);
        }

        function closeLightbox() {
            var lb = document.getElementById('lightbox');
            lb.classList.remove('visible');
            setTimeout(function() {
                lb.classList.remove('active');
                document.body.style.overflow = '';
            }, 300);
        }

        function lightboxNav(dir) {
            currentLightboxIndex = (currentLightboxIndex + dir + galleryImages.length) % galleryImages.length;
            var img = document.getElementById('lightbox-img');
            img.style.opacity = '0';
            setTimeout(function() {
                img.src = galleryImages[currentLightboxIndex];
                img.style.opacity = '1';
            }, 200);
        }
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') lightboxNav(1);
            if (e.key === 'ArrowLeft') lightboxNav(-1);
        });

        /* ─── FORM SUBMIT ─── */
        function submitForm(form) {
            var btn = form.querySelector('.btn-submit');
            btn.classList.add('loading');
            btn.disabled = true;
            return true;
        }

        /* ─── COPY BANK ─── */
        function copyBankAccount() {
            var acc = document.getElementById('bankAccount');
            var btnText = document.getElementById('copyBtnText');
            if (!acc) return;
            var text = acc.textContent.trim();
            var orig = btnText ? btnText.textContent : 'Salin No. Rekening';

            function showCopied() {
                if (btnText) btnText.textContent = '✓  Tersalin!';
                setTimeout(function() {
                    if (btnText) btnText.textContent = orig;
                }, 2500);
            }
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(showCopied).catch(function() {
                    var ta = document.createElement('textarea');
                    ta.value = text;
                    ta.style.position = 'fixed';
                    ta.style.opacity = '0';
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                    showCopied();
                });
            } else {
                var ta = document.createElement('textarea');
                ta.value = text;
                ta.style.position = 'fixed';
                ta.style.opacity = '0';
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
                showCopied();
            }
        }

        /* ─── YOUTUBE MUSIC ─── */
        var musicBtn = document.getElementById('musicToggle');
        var playerDiv = document.getElementById('youtube-player');
        var ytPlayer = null,
            isPlaying = false,
            apiReady = false;

        function loadYouTubeAPI() {
            if (typeof YT !== 'undefined' && YT.Player) {
                onYouTubeIframeAPIReady();
                return;
            }
            if (document.getElementById('yt-api')) return;
            var tag = document.createElement('script');
            tag.id = 'yt-api';
            tag.src = 'https://www.youtube.com/iframe_api';
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
                            e.target.setVolume(35);
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
            } catch (err) {
                console.warn('YT init failed', err);
            }
        };

        function tryPlayMusic() {
            if (!ytPlayer || !apiReady) return;
            try {
                ytPlayer.mute();
                ytPlayer.playVideo();
                setTimeout(function() {
                    try {
                        ytPlayer.unMute();
                    } catch (e) {}
                }, 500);
                isPlaying = true;
                if (musicBtn) {
                    musicBtn.style.display = 'flex';
                    musicBtn.classList.add('playing');
                }
            } catch (e) {}
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
            } catch (e) {}
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

        /* ─── INIT ─── */
        window.addEventListener('DOMContentLoaded', function() {
            initReveal();
            initGallery();
        });
    </script>
</body>

</html>
