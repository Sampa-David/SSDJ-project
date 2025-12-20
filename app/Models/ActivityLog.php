<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'changes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'changes' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user associated with the activity
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get action label for display
     */
    public function getActionLabelAttribute(): string
    {
        $labels = [
            'user_login' => 'User Login',
            'user_logout' => 'User Logout',
            'ticket_purchased' => 'Ticket Purchased',
            'ticket_used' => 'Ticket Used',
            'user_created' => 'User Created',
            'user_deleted' => 'User Deleted',
            'event_created' => 'Event Created',
            'event_updated' => 'Event Updated',
            'event_deleted' => 'Event Deleted',
            'settings_updated' => 'Settings Updated',
            'data_generated' => 'Data Generated',
        ];
        
        return $labels[$this->action] ?? ucfirst(str_replace('_', ' ', $this->action));
    }

    /**
     * Scope: Recent activities
     */
    public function scopeRecent($query)
    {
        return $query->orderByDesc('created_at');
    }

    /**
     * Scope: By action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope: By user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
