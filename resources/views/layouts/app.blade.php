<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">

    <title>@yield('title', 'La Bottega del Gusto — Montopoli in Val d\'Arno')</title>
    <meta name="description" content="@yield('description', 'Bottega alimentare a Montopoli in Val d\'Arno (PI). Il meglio dei sapori toscani: salumi, formaggi, olio, vini e specialità locali.')">

    {{-- Canonical --}}
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Hreflang --}}
    <link rel="alternate" hreflang="it" href="{{ url()->current() }}">

    {{-- Link al sitemap per i robot --}}
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="La Bottega del Gusto">
    <meta property="og:title" content="@yield('og_title', 'La Bottega del Gusto — Montopoli in Val d\'Arno')">
    <meta property="og:description" content="@yield('og_description', 'Bottega alimentare con i migliori sapori toscani.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/tagliere-vino.jpeg'))">
    <meta property="og:locale" content="it_IT">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'La Bottega del Gusto')">
    <meta name="twitter:description" content="@yield('og_description', 'Bottega alimentare con i migliori sapori toscani.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/tagliere-vino.jpeg'))">

    {{-- Geo meta --}}
    <meta name="geo.region" content="IT-PI">
    <meta name="geo.placename" content="Montopoli in Val d'Arno">
    <meta name="geo.position" content="43.6739;10.7486">
    <meta name="ICBM" content="43.6739, 10.7486">

    {{-- Author / generator --}}
    <meta name="author" content="Ilaria Pace — https://ipace.dev">
    <meta name="generator" content="Laravel 12 + Filament 3">

    {{-- Favicon (placeholder per ora) --}}
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    {{-- Preload font critico --}}
    <link rel="preload" href="/fonts/cinzel-v26-latin-regular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/lato-v25-latin-300.woff2" as="font" type="font/woff2" crossorigin>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

    {{-- Schema.org LocalBusiness (JSON-LD) --}}
    @include('partials.schema-localbusiness')

    @stack('head')
</head>
<body>
    @include('partials.socials')

    <div class="brand-mark" role="img" aria-label="La Bottega del Gusto — cuore di pane">
        <img src="/images/cuore-di-pane-logo.png" alt="">
    </div>

    <main>
        @yield('content')
        @include('components.cookie-banner')
    </main>
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} La Bottega del Gusto — Piazza San Michele, 4, Montopoli in Val d'Arno (PI)</p>
            <p class="footer__links">
                <a href="{{ route('cookie-policy') }}">Cookie policy</a>
                <span aria-hidden="true">·</span>
                <button type="button" class="footer__linklike" onclick="window.openCookieBanner && window.openCookieBanner()">Gestisci cookie</button>
            </p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
