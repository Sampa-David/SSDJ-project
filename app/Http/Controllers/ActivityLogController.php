<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs with filtering options
     */
    public function index(Request $request): View
    {
        $query = ActivityLog::with('user');

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by search in description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%$search%")
                  ->orWhere('action', 'like', "%$search%");
            });
        }

        // Get unique actions for filter dropdown
        $actions = ActivityLog::select('action')
            ->distinct()
            ->pluck('action')
            ->sort();

        // Get unique users for filter dropdown
        $users = User::select('id', 'name')
            ->orderBy('name')
            ->get();

        // Get paginated results
        $logs = $query->recent()->paginate(50);

        // Get statistics
        $totalLogs = ActivityLog::count();
        $todayLogs = ActivityLog::whereDate('created_at', today())->count();
        $actionStats = ActivityLog::selectRaw('action, COUNT(*) as count')
            ->groupBy('action')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        return view('admin.activity-logs', [
            'logs' => $logs,
            'actions' => $actions,
            'users' => $users,
            'totalLogs' => $totalLogs,
            'todayLogs' => $todayLogs,
            'actionStats' => $actionStats,
        ]);
    }

    /**
     * Log an activity
     */
    public static function log(
        string $action,
        ?string $description = null,
        ?string $modelType = null,
        ?int $modelId = null,
        ?array $changes = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'changes' => $changes,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Clear old logs (keep last 30 days)
     */
    public function clearOldLogs(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:7|max:365',
        ]);

        $deleted = ActivityLog::where('created_at', '<', now()->subDays($request->days))->delete();

        return redirect()->route('admin.activity-logs')
            ->with('success', "Deleted $deleted old activity log entries.");
    }

    /**
     * Export logs as CSV
     */
    public function export(Request $request)
    {
        $logs = ActivityLog::with('user')->recent()->get();

        $csv = "Date,User,Action,Description,IP Address\n";
        
        foreach ($logs as $log) {
            $userName = $log->user ? $log->user->name : 'System';
            $csv .= "\"{$log->created_at->format('Y-m-d H:i:s')}\"";
            $csv .= ",\"{$userName}\"";
            $csv .= ",\"{$log->action_label}\"";
            $csv .= ",\"{$log->description}\"";
            $csv .= ",\"{$log->ip_address}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="activity-logs-' . now()->format('Y-m-d-His') . '.csv"',
        ]);
    }
}
