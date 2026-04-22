<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $showPast = $request->boolean('past');

        $events = ($showPast ? Event::past() : Event::upcoming())
            ->paginate(12)
            ->withQueryString();

        return view('pages.events.index', compact('events', 'showPast'));
    }

    public function show(string $slug)
    {
        $event = Event::where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.events.show', compact('event'));
    }
}
