<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Show the ticket purchase page
     */
    public function showPurchase()
    {
        $ticketTypes = [
            'early_bird' => [
                'name' => 'Early Bird',
                'price' => 75,
                'description' => 'Get early access to the summit',
                'features' => [
                    'Access to all sessions',
                    'Networking events',
                    'Lunch & Coffee included',
                ]
            ],
            'regular' => [
                'name' => 'Regular',
                'price' => 125,
                'description' => 'Standard summit access',
                'features' => [
                    'Access to all sessions',
                    'Networking events',
                    'Lunch included',
                ]
            ],
            'premium' => [
                'name' => 'Premium',
                'price' => 195,
                'description' => 'Premium experience',
                'features' => [
                    'Access to all sessions',
                    'VIP networking events',
                    'Premium lunch & dinner',
                    'Meet speakers',
                    'Certificate of participation',
                ]
            ],
        ];

        return view('tickets.purchase', compact('ticketTypes'));
    }

    /**
     * Store purchased ticket
     */
    public function purchase(Request $request)
    {
        $request->validate([
            'ticket_type' => 'required|in:early_bird,regular,premium',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        // Ticket prices
        $prices = [
            'early_bird' => 75,
            'regular' => 125,
            'premium' => 195,
        ];

        $ticketType = $request->ticket_type;
        $quantity = $request->quantity;
        $price = $prices[$ticketType];

        $createdTickets = [];

        try {
            for ($i = 0; $i < $quantity; $i++) {
                $ticket = Ticket::create([
                    'user_id' => Auth::id() ?? null,
                    'ticket_type' => $ticketType,
                    'price' => $price,
                    'ticket_number' => Ticket::generateTicketNumber(),
                    'status' => 'active',
                    'purchased_at' => now(),
                    'valid_from' => now(),
                    'valid_until' => now()->addDays(180),
                    'qr_code' => $this->generateQRCode(),
                ]);

                $createdTickets[] = $ticket;
            }

            return redirect()->route('tickets.confirmation')
                ->with('success', "Successfully purchased {$quantity} " . ($quantity > 1 ? 'tickets' : 'ticket'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error purchasing tickets: ' . $e->getMessage());
        }
    }

    /**
     * Show user dashboard
     */
    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $tickets = Auth::user()->tickets()->latest()->paginate(10);
        $stats = [
            'total' => Auth::user()->tickets()->count(),
            'active' => Auth::user()->activeTickets()->count(),
            'cancelled' => Auth::user()->tickets()->where('status', 'cancelled')->count(),
            'total_spent' => Auth::user()->getTotalSpentAttribute(),
        ];

        return view('dashboard', compact('tickets', 'stats'));
    }

    /**
     * Show user's tickets
     */
    public function myTickets()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $tickets = Auth::user()->tickets()->latest()->paginate(10);
        $stats = [
            'total' => Auth::user()->tickets()->count(),
            'active' => Auth::user()->activeTickets()->count(),
            'cancelled' => Auth::user()->tickets()->where('status', 'cancelled')->count(),
            'total_spent' => Auth::user()->getTotalSpentAttribute(),
        ];

        return view('tickets.my-tickets', compact('tickets', 'stats'));
    }

    /**
     * Show ticket details
     */
    public function show(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Cancel ticket
     */
    public function cancel(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($ticket->status === 'cancelled') {
            return back()->with('info', 'Ticket is already cancelled');
        }

        $ticket->update(['status' => 'cancelled']);

        return back()->with('success', 'Ticket cancelled successfully');
    }

    /**
     * Download ticket
     */
    public function download(Ticket $ticket)
    {
        if ($ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        // Generate PDF or ticket file
        // For now, just return the ticket data
        return response()->json($ticket);
    }

    /**
     * Generate QR code for ticket
     */
    private function generateQRCode(): string
    {
        // Simple QR code generation (in production use a library like endroid/qr-code)
        return base64_encode(uniqid('ticket_', true));
    }

    /**
     * Show purchase confirmation
     */
    public function confirmation()
    {
        // Get the last purchased ticket for the user
        $lastTicket = Auth::user()->tickets()->latest()->first();

        if (!$lastTicket) {
            return redirect()->route('buy-tickets');
        }

        return view('tickets.confirmation', ['lastTicket' => $lastTicket]);
    }
}

