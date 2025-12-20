<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_id',
        'admin_id',
        'subject',
        'status',
        'priority',
    ];

    /**
     * Get the user (client) who created this conversation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the assigned admin
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get all messages in this conversation
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get unread messages count
     */
    public function unreadCount(): int
    {
        return $this->messages()->whereNull('read_at')->count();
    }

    /**
     * Mark all messages as read for a specific user
     */
    public function markAsRead(int $userId): void
    {
        $this->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', $userId)
            ->update(['read_at' => now()]);
    }

    /**
     * Get last message
     */
    public function lastMessage(): ?Message
    {
        return $this->messages()->latest()->first();
    }

    /**
     * Check if user is participant of this conversation
     */
    public function isParticipant(int $userId): bool
    {
        return $this->user_id === $userId || $this->admin_id === $userId;
    }
}
