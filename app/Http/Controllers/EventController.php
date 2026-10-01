<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('venue')
            ->where('status', 'published');

        $showUpcoming = $request->boolean('upcoming', true);

        if ($showUpcoming) {
            $query->where('start_date', '>=', now()->startOfDay());
        }

        $events = $query->orderBy('start_date')->paginate(12)->withQueryString();

        $cancelled = Event::where('status', 'cancelled')->exists();

        return view('agenda.index', compact('events', 'showUpcoming', 'cancelled'));
    }

    public function show(Event $event)
    {
        $event->load('venue');

        abort_if(in_array($event->status, ['draft', 'cancelled'], true), 404);

        return view('agenda.show', compact('event'));
    }
}
