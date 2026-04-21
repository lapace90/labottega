@extends('layouts.app')

@section('title', $event->title . ' — La Bottega del Gusto')
@section('description', $event->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($event->description), 160))

@if($event->cover_image)
    @section('og_image', asset('storage/' . $event->cover_image))
@endif

@push('head')
    @php
        $eventSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event->title,
            'startDate' => $event->starts_at->toIso8601String(),
            'eventStatus' => 'https://schema.org/EventScheduled',
            'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
            'location' => [
                '@type' => 'Place',
                'name' => $event->location_name ?? 'Montopoli in Val d\'Arno',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Montopoli in Val d\'Arno',
                    'addressRegion' => 'PI',
                    'addressCountry' => 'IT',
                ],
            ],
            'description' => $event->excerpt ?? strip_tags($event->description),
        ];

        if ($event->ends_at) {
            $eventSchema['endDate'] = $event->ends_at->toIso8601String();
        }

        if ($event->cover_image) {
            $eventSchema['image'] = asset('storage/' . $event->cover_image);
        }

        if ($event->organizer_name) {
            $organizer = ['@type' => 'Organization', 'name' => $event->organizer_name];
            if ($event->external_url) {
                $organizer['url'] = $event->external_url;
            }
            $eventSchema['organizer'] = $organizer;
        }
    @endphp

    <script type="application/ld+json">
        {!! json_encode($eventSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
    </script>
@endpush

@section('content')
<article class="event-detail section">
    <div class="container">
        @if($event->cover_image)
            @php($coverUrl = asset('storage/' . $event->cover_image))
            <div class="event-detail__cover" style="background-image: url('{{ $coverUrl }}');"></div>
        @endif

        <header class="event-detail__header">
            <time class="event-card__date" datetime="{{ $event->starts_at->toIso8601String() }}">
                {{ $event->starts_at->locale(app()->getLocale())->isoFormat('dddd D MMMM YYYY [·] HH:mm') }}
                @if($event->ends_at)
                    &mdash; {{ $event->ends_at->locale(app()->getLocale())->isoFormat('HH:mm') }}
                @endif
            </time>

            <h1 class="event-detail__title">{{ $event->title }}</h1>

            @if($event->location_name)
                <p class="event-detail__location">📍 {{ $event->location_name }}</p>
            @endif

            @if($event->organizer_name)
                <p class="event-detail__organizer">Organizzato da {{ $event->organizer_name }}</p>
            @endif
        </header>

        <div class="event-detail__body">
            {!! $event->description !!}
        </div>

        @if($event->external_url)
            <p class="event-detail__link">
                <a href="{{ $event->external_url }}" target="_blank" rel="noopener">
                    Programma ufficiale e informazioni complete →
                </a>
            </p>
        @endif

        <p class="event-detail__back">
            <a href="{{ route('events.index') }}">← Tutti gli eventi</a>
        </p>
    </div>
</article>
@endsection
