@extends('layouts.app')

@section('title', 'La Bottega del Gusto — Bottega alimentare a Montopoli in Val d\'Arno')
@section('description', 'Bottega alimentare a Montopoli in Val d\'Arno (PI). Il meglio dei sapori toscani: salumi, formaggi, olio, vini e specialità locali. Piazza San Michele, 4.')

@section('content')
    @include('partials.home.hero')
    @include('partials.home.about')
    @include('partials.home.events')
    @include('partials.home.contact')
@endsection

@push('scripts')
    <script src="{{ asset('js/hero-slider.js') }}" defer></script>
@endpush
