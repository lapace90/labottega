<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'description',
        'location_name',
        'organizer_name',
        'external_url',
        'starts_at',
        'ends_at',
        'cover_image',
        'is_published',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    /**
     * Scope: solo eventi pubblicati e non ancora conclusi.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->where('ends_at', '>=', now())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('ends_at')
                         ->where('starts_at', '>=', now());
                  });
            })
            ->orderBy('starts_at');
    }

    public function scopePast($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->where('ends_at', '<', now())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('ends_at')
                         ->where('starts_at', '<', now());
                  });
            })
            ->orderBy('starts_at', 'desc');
    }
}
