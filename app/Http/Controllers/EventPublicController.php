<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventPublicController extends Controller
{
    /**
     * Display a listing of public events
     */
    public function list()
    {
        $events = Event::where('status', 'published')
            ->where('visibility', 'public')
            ->orderBy('date_event', 'desc')
            ->paginate(12);

        return view('events.public-list', compact('events'));
    }

    /**
     * Display a specific public event
     */
    public function show(Event $event)
    {
        // Check if event is public and published
        if ($event->status !== 'published' || $event->visibility !== 'public') {
            abort(404);
        }

        return view('events.public-show', compact('event'));
    }
}
