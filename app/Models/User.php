<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'company',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all roles for the user
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Check if user has a specific role
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->roles()->where('slug', $roleSlug)->exists();
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Assign role to user
     */
    public function assignRole(Role|string $role): void
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }
        $this->roles()->attach($role);
    }

    /**
     * Remove role from user
     */
    public function removeRole(Role|string $role): void
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }
        $this->roles()->syncWithoutDetaching($role);
    }

    /**
     * Get all tickets for the user
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get all event publishing rights for the user
     */
    public function publishingRights(): HasMany
    {
        return $this->hasMany(EventPublishingRight::class);
    }

    /**
     * Check if user has active publishing rights
     */
    public function hasActivePublishingRights(): bool
    {
        return $this->publishingRights()
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->exists();
    }

    /**
     * Get active publishing right
     */
    public function getActivePublishingRight()
    {
        return $this->publishingRights()
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->latest('expires_at')
            ->first();
    }

    /**
     * Get all events for the user
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Get active tickets for the user
     */
    public function activeTickets()
    {
        return $this->tickets()->where('status', 'active');
    }

    /**
     * Get total amount spent on tickets
     */
    public function getTotalSpentAttribute(): float
    {
        return $this->tickets()->where('status', '!=', 'cancelled')->sum('price');
    }

    /**
     * Get ticket count by type
     */
    public function getTicketCountByType(string $type): int
    {
        return $this->tickets()->where('ticket_type', $type)->count();
    }

    /**
     * Get all conversations where user is client
     */
    public function conversations()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    /**
     * Get all conversations assigned to this admin
     */
    public function assignedConversations()
    {
        return $this->hasMany(Conversation::class, 'admin_id');
    }

    /**
     * Get all messages sent by user
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get unread conversations count for client
     */
    public function unreadConversationsCount(): int
    {
        return $this->conversations()
            ->whereHas('messages', function ($query) {
                $query->whereNull('read_at')
                    ->where('sender_id', '!=', $this->id);
            })
            ->count();
    }

    /**
     * Get unread messages for admin assigned conversations
     */
    public function unreadAdminMessagesCount(): int
    {
        return Message::whereHas('conversation', function ($query) {
            $query->where('admin_id', $this->id);
        })
            ->whereNull('read_at')
            ->where('sender_id', '!=', $this->id)
            ->count();
    }
}

