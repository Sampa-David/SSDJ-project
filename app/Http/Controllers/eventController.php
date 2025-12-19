<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class eventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Auth::user()->events()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource (redirects to payment)
     */
    public function create()
    {
        return redirect()->route('events.payment');
    }

    /**
     * Store a newly created resource in storage (handled by EventPaymentController)
     */
    public function store(Request $request)
    {
        // This is now handled by EventPaymentController::processPayment
        return redirect()->route('events.payment');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        // Ensure user can only edit their own events
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Ensure user can only update their own events
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'date_event' => 'required|date',
            'location' => 'required|string|max:255',
            'visibility' => 'required|in:public,private,friends',
        ]);

        $event->update($request->only([
            'name',
            'description',
            'date_event',
            'location',
            'visibility'
        ]));

        return redirect()
            ->route('events.show', $event->id)
            ->with('success', 'Événement mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Ensure user can only delete their own events
        if ($event->user_id !== Auth::id()) {
            abort(403);
        }

        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Événement supprimé avec succès!');
    }
}
