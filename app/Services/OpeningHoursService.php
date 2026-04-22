<?php

namespace App\Services;

use App\Models\OpeningHour;
use App\Models\SpecialClosing;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class OpeningHoursService
{
    public function isOpenNow(): bool
    {
        if ($this->activeClosing()) {
            return false;
        }

        $now = Carbon::now('Europe/Rome');
        $day = $now->dayOfWeekIso - 1;

        $hours = OpeningHour::forDay($day)->get();

        foreach ($hours as $h) {
            $open = Carbon::parse($h->opens_at)->setDateFrom($now);
            $close = Carbon::parse($h->closes_at)->setDateFrom($now);
            if ($now->between($open, $close)) {
                return true;
            }
        }

        return false;
    }

    public function activeClosing(): ?SpecialClosing
    {
        return SpecialClosing::active()->first();
    }

    public function upcomingClosings(int $days = 30): Collection
    {
        return SpecialClosing::upcoming($days)->get();
    }

    public function currentStatus(): array
    {
        $closing = $this->activeClosing();
        if ($closing) {
            $reopenDate = $closing->getEffectiveEndDate()->copy()->addDay();
            return [
                'state' => 'closing',
                'label' => 'Chiuso oggi: ' . $closing->reason,
                'sublabel' => 'Riapriamo il ' . $reopenDate->locale('it')->isoFormat('D MMMM'),
            ];
        }

        if ($this->isOpenNow()) {
            return [
                'state' => 'open',
                'label' => 'Aperto ora',
                'sublabel' => null,
            ];
        }

        $next = $this->nextOpening();
        if ($next) {
            $now = Carbon::now('Europe/Rome');
            if ($next->isSameDay($now) && $now->diffInMinutes($next) <= 60) {
                return [
                    'state' => 'opening-soon',
                    'label' => 'Apre alle ' . $next->format('H:i'),
                    'sublabel' => null,
                ];
            }
        }

        return [
            'state' => 'closed',
            'label' => 'Chiuso ora',
            'sublabel' => $next ? 'Prossima apertura: ' . $this->formatNextOpening($next) : null,
        ];
    }

    public function nextOpening(): ?Carbon
    {
        $now = Carbon::now('Europe/Rome');

        for ($offset = 0; $offset < 7; $offset++) {
            $checkDate = $now->copy()->addDays($offset)->startOfDay();
            $day = $checkDate->dayOfWeekIso - 1;

            $hours = OpeningHour::forDay($day)->get();

            foreach ($hours as $h) {
                $open = Carbon::parse($h->opens_at)->setDateFrom($checkDate);
                if ($open->isFuture()) {
                    return $open;
                }
            }
        }

        return null;
    }

    protected function formatNextOpening(Carbon $next): string
    {
        $now = Carbon::now('Europe/Rome');
        if ($next->isSameDay($now)) {
            return 'oggi alle ' . $next->format('H:i');
        }
        if ($next->isSameDay($now->copy()->addDay())) {
            return 'domani alle ' . $next->format('H:i');
        }
        return $next->locale('it')->isoFormat('dddd [alle] HH:mm');
    }

    public function weeklyHours(): array
    {
        $hours = OpeningHour::orderBy('day_of_week')->orderBy('sort_order')->get();
        $grouped = [];

        foreach (OpeningHour::DAY_LABELS as $day => $label) {
            $slots = $hours->where('day_of_week', $day);
            $grouped[$day] = [
                'label' => $label,
                'slots' => $slots->map(fn($h) => [
                    'opens' => Carbon::parse($h->opens_at)->format('H:i'),
                    'closes' => Carbon::parse($h->closes_at)->format('H:i'),
                ])->values()->all(),
            ];
        }

        return $grouped;
    }

    public function forSchemaOrg(): array
    {
        $dayMap = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $specs = [];

        foreach (OpeningHour::all() as $h) {
            $specs[] = [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => 'https://schema.org/' . $dayMap[$h->day_of_week],
                'opens' => Carbon::parse($h->opens_at)->format('H:i'),
                'closes' => Carbon::parse($h->closes_at)->format('H:i'),
            ];
        }

        return $specs;
    }
}
