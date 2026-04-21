<?php

namespace App\Http\Controllers;

use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::upcoming()->take(6)->get();

        return view('pages.home', compact('upcomingEvents'));
    }
}
