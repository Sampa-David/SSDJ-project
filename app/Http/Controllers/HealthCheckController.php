<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    /**
     * Check application and database health
     */
    public function check()
    {
        try {
            // Test database connection
            DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Exception $e) {
            $dbConnected = false;
            $dbError = $e->getMessage();
        }

        $tables = [
            'users' => Schema::hasTable('users'),
            'events' => Schema::hasTable('events'),
            'activity_logs' => Schema::hasTable('activity_logs'),
            'messages' => Schema::hasTable('messages'),
            'tickets' => Schema::hasTable('tickets'),
            'email_verifications' => Schema::hasTable('email_verifications'),
        ];

        $allTablesExist = collect($tables)->every(fn($exists) => $exists);

        return response()->json([
            'status' => $allTablesExist ? 'healthy' : 'degraded',
            'database' => [
                'connected' => $dbConnected,
                'error' => $dbError ?? null,
            ],
            'tables' => $tables,
            'environment' => app()->environment(),
            'timestamp' => now()->toIso8601String(),
        ], $allTablesExist ? 200 : 500);
    }

    /**
     * Simple health check for Railway
     */
    public function status()
    {
        try {
            DB::connection()->getPdo();
            return response()->json(['status' => 'ok'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
