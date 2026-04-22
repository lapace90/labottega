<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SpecialClosing extends Model
{
    protected $fillable = ['starts_at', 'ends_at', 'reason'];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
    ];

    public function scopeActive($query)
    {
        $today = Carbon::today();
        return $query->where('starts_at', '<=', $today)
            ->where(function ($q) use ($today) {
                $q->whereNull('ends_at')->where('starts_at', '>=', $today)
                  ->orWhere('ends_at', '>=', $today);
            });
    }

    public function scopeUpcoming($query, int $days = 30)
    {
        return $query->where('starts_at', '>', Carbon::today())
            ->where('starts_at', '<=', Carbon::today()->addDays($days))
            ->orderBy('starts_at');
    }

    public function getEffectiveEndDate(): Carbon
    {
        return $this->ends_at ?? $this->starts_at;
    }

    public function isSingleDay(): bool
    {
        return $this->ends_at === null || $this->starts_at->equalTo($this->ends_at);
    }
}
