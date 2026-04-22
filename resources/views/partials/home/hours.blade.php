@php
    $hoursService = app(\App\Services\OpeningHoursService::class);
    $status = $hoursService->currentStatus();
    $weekly = $hoursService->weeklyHours();
    $upcomingClosings = $hoursService->upcomingClosings();
@endphp

<div class="hours">
    <h3 class="hours__title">Orari</h3>

    <div class="hours__status hours__status--{{ $status['state'] }}">
        {{ $status['label'] }}
    </div>

    @if($status['sublabel'])
        <p class="hours__sublabel">{{ $status['sublabel'] }}</p>
    @endif

    <ul class="hours__list">
        @foreach($weekly as $day)
            @php
                $morning = collect($day['slots'])->first(fn($s) => $s['opens'] < '14:00');
                $afternoon = collect($day['slots'])->first(fn($s) => $s['opens'] >= '14:00');
                $isClosed = empty($day['slots']);
            @endphp
            <li class="hours__day">
                <span class="hours__day-label">{{ $day['label'] }}</span>
                @if($isClosed)
                    <span class="hours__day-value hours__day-value--full">
                        <span class="hours__closed">Chiuso</span>
                    </span>
                @else
                    <span class="hours__day-value">
                        @if($morning)
                            {{ $morning['opens'] }}–{{ $morning['closes'] }}
                        @else
                            <span class="hours__closed">Chiuso</span>
                        @endif
                    </span>
                    <span class="hours__day-value">
                        @if($afternoon)
                            {{ $afternoon['opens'] }}–{{ $afternoon['closes'] }}
                        @else
                            <span class="hours__closed">Chiuso</span>
                        @endif
                    </span>
                @endif
            </li>
        @endforeach
    </ul>

    @if($upcomingClosings->isNotEmpty())
        <div class="hours__closings">
            @foreach($upcomingClosings as $c)
                <p class="hours__closing">
                    📅 Chiuso
                    @if($c->isSingleDay())
                        il {{ $c->starts_at->locale('it')->isoFormat('D MMMM') }}
                    @else
                        dal {{ $c->starts_at->locale('it')->isoFormat('D') }} al {{ $c->ends_at->locale('it')->isoFormat('D MMMM') }}
                    @endif
                    ({{ $c->reason }})
                </p>
            @endforeach
        </div>
    @endif
</div>
