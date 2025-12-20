<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class DataGeneratorController extends Controller
{
    /**
     * Show data generator form
     */
    public function show()
    {
        return view('admin.data-generator');
    }

    /**
     * Generate users and events
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'users_count' => 'required|integer|min:1|max:1000',
            'events_count' => 'required|integer|min:1|max:1000',
        ]);

        try {
            // Create users
            $users = User::factory()
                ->count($validated['users_count'])
                ->create();

            // Ensure we have users to assign to
            if ($users->isEmpty()) {
                return back()->with('error', 'Failed to create users. Please try again.');
            }

            // Create events and assign to random users
            $eventsCreated = 0;
            for ($i = 0; $i < $validated['events_count']; $i++) {
                try {
                    Event::factory()->create([
                        'user_id' => $users->random()->id
                    ]);
                    $eventsCreated++;
                } catch (\Exception $e) {
                    // Continue creating other events if one fails
                    continue;
                }
            }

            return redirect()->route('admin.dashboard')
                ->with('success', "Successfully generated {$validated['users_count']} users and {$eventsCreated} events!");
        } catch (\Exception $e) {
            \Log::error('Data generation error: ' . $e->getMessage());
            return back()
                ->with('error', 'Error generating data: ' . $e->getMessage());
        }
    }
}
