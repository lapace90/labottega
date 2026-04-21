<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
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
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

    {{-- Link al sitemap per i robot --}}
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="La Bottega del Gusto">
    <meta property="og:title" content="@yield('og_title', 'La Bottega del Gusto — Montopoli in Val d\'Arno')">
    <meta property="og:description" content="@yield('og_description', 'Bottega alimentare con i migliori sapori toscani.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:locale" content="it_IT">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'La Bottega del Gusto')">
    <meta name="twitter:description" content="@yield('og_description', 'Bottega alimentare con i migliori sapori toscani.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

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

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} La Bottega del Gusto — Piazza Michele, 4, Montopoli in Val d'Arno (PI)</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
