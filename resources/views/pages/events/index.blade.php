@extends('layouts.app')

@section('title', 'Eventi — La Bottega del Gusto')
@section('description', 'Tutti gli eventi, sagre e manifestazioni a cui partecipa La Bottega del Gusto di Montopoli in Val d\'Arno.')

@section('content')
<section class="section events-page">
    <div class="container">
        <p class="events__back">
            <a href="{{ route('home') }}">← Torna alla home</a>
        </p>

        <header class="events__header">
            <h1 class="events__title">Eventi</h1>
            <p class="events__subtitle">Appuntamenti, sagre e manifestazioni in cui partecipiamo</p>
        </header>

        <nav class="events__tabs" aria-label="Filtro eventi">
            <a href="{{ route('events.index') }}"
               class="events__tab @if(!$showPast) events__tab--active @endif"
               @if(!$showPast) aria-current="page" @endif>
                Prossimi eventi
            </a>
            <a href="{{ route('events.index', ['past' => 1]) }}"
               class="events__tab @if($showPast) events__tab--active @endif"
               @if($showPast) aria-current="page" @endif>
                Eventi passati
            </a>
        </nav>

        @if($events->isEmpty())
            <p style="text-align:center; padding:60px 0;">
                @if($showPast)
                    Nessun evento passato da mostrare.
                @else
                    Nessun evento in programma al momento.
                @endif
            </p>
        @else
            <div class="events__grid">
                @foreach($events as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>

            <div class="events__pagination">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
