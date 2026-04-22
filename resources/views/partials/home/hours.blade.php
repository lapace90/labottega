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
            <li class="hours__day">
                <span class="hours__day-label">{{ $day['label'] }}</span>
                <span class="hours__day-value">
                    @if(empty($day['slots']))
                        <span class="hours__closed">Chiuso</span>
                    @else
                        @foreach($day['slots'] as $i => $slot)
                            {{ $slot['opens'] }}–{{ $slot['closes'] }}@if($i < count($day['slots']) - 1) · @endif
                        @endforeach
                    @endif
                </span>
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
