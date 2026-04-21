<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::upcoming()->paginate(12);

        return view('pages.events.index', compact('events'));
    }

    public function show(string $slug)
    {
        // Cerca per slug nella locale corrente (IT di default)
        $event = Event::where('is_published', true)
            ->whereJsonContains('slug->' . app()->getLocale(), $slug)
            ->firstOrFail();

        return view('pages.events.show', compact('event'));
    }
}
