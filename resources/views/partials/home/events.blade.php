@if($upcomingEvents->isNotEmpty())
<section class="section events" id="eventi" aria-labelledby="events-title">
    <div class="container">
        <div class="events__header">
            <h2 class="events__title" id="events-title">Prossimi eventi</h2>
            <p class="events__subtitle">Appuntamenti, sagre e manifestazioni in cui partecipiamo</p>
        </div>

        <div class="events__carousel" role="list">
            @foreach($upcomingEvents as $event)
                <x-event-card :event="$event" />
            @endforeach
        </div>
    </div>
</section>
@endif
