<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Display settings page
     */
    public function index(): View
    {
        return view('admin.settings', [
            'settings' => config('app'),
        ]);
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_description' => 'nullable|string|max:1000',
            'contact_email' => 'required|email',
            'support_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'working_hours' => 'nullable|string',
            'max_users' => 'nullable|integer|min:1',
            'max_events' => 'nullable|integer|min:1',
            'ticket_validity_days' => 'nullable|integer|min:1|max:365',
            'enable_registration' => 'boolean',
            'enable_tickets' => 'boolean',
            'enable_events' => 'boolean',
            'maintenance_mode' => 'boolean',
            'allow_guest_booking' => 'boolean',
        ]);

        // Here you would typically save settings to database or config
        // For now, we'll just log the changes
        ActivityLog::log(
            'settings_updated',
            'System settings updated',
            'Settings',
            null,
            $validated
        );

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully!');
    }

    /**
     * Reset settings to defaults
     */
    public function resetDefaults(Request $request)
    {
        $request->validate(['confirm' => 'required|accepted']);

        ActivityLog::log(
            'settings_reset',
            'Settings reset to default values',
            'Settings',
        );

        return redirect()->route('admin.settings')
            ->with('success', 'Settings have been reset to defaults!');
    }

    /**
     * Clear cache
     */
    public function clearCache()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');

        ActivityLog::log(
            'cache_cleared',
            'Application cache cleared',
            'System',
        );

        return redirect()->route('admin.settings')
            ->with('success', 'Cache cleared successfully!');
    }

    /**
     * Enable/Disable maintenance mode
     */
    public function toggleMaintenance(Request $request)
    {
        $enabled = $request->boolean('enabled');

        if ($enabled) {
            \Artisan::call('down');
            $message = 'Maintenance mode enabled';
        } else {
            \Artisan::call('up');
            $message = 'Maintenance mode disabled';
        }

        ActivityLog::log(
            'maintenance_mode_' . ($enabled ? 'enabled' : 'disabled'),
            $message,
            'System',
        );

        return redirect()->route('admin.settings')
            ->with('success', $message . ' successfully!');
    }
}
