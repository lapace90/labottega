@props(['event'])

<article class="event-card" role="listitem">
    <a href="{{ route('events.show', ['slug' => $event->getTranslation('slug', app()->getLocale())]) }}">
        <div class="event-card__image"
            @if($event->cover_image)
            style="background-image: url('{{ asset('storage/' . $event->cover_image) }}');"
            @endif>
        </div>
        <div class="event-card__body">
            <time class="event-card__date" datetime="{{ $event->starts_at->toIso8601String() }}">
                {{ $event->starts_at->locale(app()->getLocale())->isoFormat('ddd D MMM YYYY') }}
            </time>
            <h3 class="event-card__title">{{ $event->title }}</h3>
            @if($event->location_name)
            <p class="event-card__location">{{ $event->location_name }}</p>
            @endif
        </div>
    </a>
</article>
