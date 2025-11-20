<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'ticket_type',
        'price',
        'ticket_number',
        'status',
        'purchased_at',
        'valid_from',
        'valid_until',
        'qr_code',
        'notes',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    /**
     * Get the user that owns the ticket
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if ticket is valid
     */
    public function isValid(): bool
    {
        return $this->status === 'active' &&
               (!$this->valid_from || now()->gte($this->valid_from)) &&
               (!$this->valid_until || now()->lte($this->valid_until));
    }

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber(): string
    {
        do {
            $number = 'TKT-' . strtoupper(substr(md5(rand()), 0, 10));
        } while (self::where('ticket_number', $number)->exists());

        return $number;
    }

    /**
     * Get ticket type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->ticket_type) {
            'early_bird' => 'Early Bird',
            'regular' => 'Regular',
            'premium' => 'Premium',
            default => 'Unknown',
        };
    }

    /**
     * Get ticket price display
     */
    public function getPriceDisplayAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }
}

