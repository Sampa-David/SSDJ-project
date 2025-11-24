<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function index(): View
    {
        // Overall Statistics
        $totalUsers = User::count();
        $totalTickets = Ticket::count();
        $totalRevenue = Ticket::where('status', '!=', 'cancelled')->sum('price');
        $activeTickets = Ticket::where('status', 'active')->count();

        // Revenue by ticket type
        $revenueByType = Ticket::where('status', '!=', 'cancelled')
            ->selectRaw('ticket_type, COUNT(*) as count, SUM(price) as revenue')
            ->groupBy('ticket_type')
            ->get();

        // Top selling ticket types
        $topTickets = Ticket::selectRaw('ticket_type, COUNT(*) as sold_count, SUM(price) as total_revenue')
            ->where('status', '!=', 'cancelled')
            ->groupBy('ticket_type')
            ->orderByDesc('sold_count')
            ->get();

        // Recent transactions
        $recentTransactions = Ticket::with('user')
            ->orderByDesc('purchased_at')
            ->limit(10)
            ->get();

        // Ticket status distribution
        $ticketStatus = Ticket::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // User activity - top buyers
        $topBuyers = User::withCount(['tickets'])
            ->orderByDesc('tickets_count')
            ->limit(10)
            ->get();

        // Monthly revenue
        $monthlyRevenue = Ticket::selectRaw('MONTH(purchased_at) as month, SUM(price) as revenue')
            ->where('status', '!=', 'cancelled')
            ->whereYear('purchased_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Expiring tickets (next 30 days)
        $expiringTickets = Ticket::where('status', 'active')
            ->whereRaw('valid_until BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)')
            ->with('user')
            ->orderBy('valid_until')
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalTickets' => $totalTickets,
            'totalRevenue' => $totalRevenue,
            'activeTickets' => $activeTickets,
            'revenueByType' => $revenueByType,
            'topTickets' => $topTickets,
            'recentTransactions' => $recentTransactions,
            'ticketStatus' => $ticketStatus,
            'topBuyers' => $topBuyers,
            'monthlyRevenue' => $monthlyRevenue,
            'expiringTickets' => $expiringTickets,
        ]);
    }

    /**
     * Display users management page
     */
    public function users(): View
    {
        $users = User::withCount(['tickets'])
            ->with(['tickets' => function ($query) {
                $query->orderByDesc('purchased_at')->limit(3);
            }])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.users', ['users' => $users]);
    }

    /**
     * Display tickets management page
     */
    public function tickets(): View
    {
        $tickets = Ticket::with('user')
            ->orderByDesc('purchased_at')
            ->paginate(20);

        $stats = [
            'total' => Ticket::count(),
            'active' => Ticket::where('status', 'active')->count(),
            'used' => Ticket::where('status', 'used')->count(),
            'cancelled' => Ticket::where('status', 'cancelled')->count(),
            'expired' => Ticket::where('status', 'expired')->count(),
        ];

        return view('admin.tickets', ['tickets' => $tickets, 'stats' => $stats]);
    }

    /**
     * Display user details
     */
    public function showUser(User $user): View
    {
        $user->load(['tickets' => function ($query) {
            $query->orderByDesc('purchased_at');
        }]);

        $userStats = [
            'totalSpent' => $user->tickets->where('status', '!=', 'cancelled')->sum('price'),
            'totalTickets' => $user->tickets->count(),
            'activeTickets' => $user->tickets->where('status', 'active')->count(),
            'lastPurchase' => $user->tickets->max('purchased_at'),
            'ticketsByType' => $user->tickets->groupBy('ticket_type')->map->count(),
        ];

        return view('admin.user-detail', ['user' => $user, 'userStats' => $userStats]);
    }

    /**
     * Display ticket details
     */
    public function showTicket(Ticket $ticket): View
    {
        $ticket->load('user');

        return view('admin.ticket-detail', ['ticket' => $ticket]);
    }

    /**
     * Get statistics as JSON (for AJAX)
     */
    public function getStats()
    {
        return response()->json([
            'totalUsers' => User::count(),
            'totalTickets' => Ticket::count(),
            'totalRevenue' => Ticket::where('status', '!=', 'cancelled')->sum('price'),
            'activeTickets' => Ticket::where('status', 'active')->count(),
            'ticketStatus' => Ticket::selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status'),
        ]);
    }

    /**
     * Export statistics to CSV
     */
    public function exportStats()
    {
        $tickets = Ticket::with('user')->get();

        $csv = "Date,User,Email,Ticket Type,Price,Status\n";
        foreach ($tickets as $ticket) {
            $csv .= $ticket->purchased_at . ",";
            $csv .= $ticket->user->name . ",";
            $csv .= $ticket->user->email . ",";
            $csv .= $ticket->type_label . ",";
            $csv .= $ticket->price . ",";
            $csv .= $ticket->status . "\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="tickets-export.csv"');
    }
}
