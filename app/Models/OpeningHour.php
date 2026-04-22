<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpeningHour extends Model
{
    protected $fillable = ['day_of_week', 'opens_at', 'closes_at', 'sort_order'];

    protected $casts = [
        'opens_at' => 'datetime:H:i',
        'closes_at' => 'datetime:H:i',
        'day_of_week' => 'integer',
        'sort_order' => 'integer',
    ];

    public const DAY_LABELS = [
        0 => 'Lunedì',
        1 => 'Martedì',
        2 => 'Mercoledì',
        3 => 'Giovedì',
        4 => 'Venerdì',
        5 => 'Sabato',
        6 => 'Domenica',
    ];

    public function scopeForDay($query, int $day)
    {
        return $query->where('day_of_week', $day)->orderBy('sort_order');
    }
}
