@extends('layouts.app')

@section('title', 'Eventi — La Bottega del Gusto')
@section('description', 'Tutti gli eventi, sagre e manifestazioni a cui partecipa La Bottega del Gusto di Montopoli in Val d\'Arno.')

@section('content')
<section class="section events-page">
    <div class="container">
        <header class="events__header">
            <h1 class="events__title">Eventi</h1>
            <p class="events__subtitle">Appuntamenti, sagre e manifestazioni in cui partecipiamo</p>
        </header>

        @if($events->isEmpty())
            <p style="text-align:center; padding:60px 0;">Nessun evento in programma al momento.</p>
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
