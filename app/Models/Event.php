<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'date_event',
        'location',
        'package_type',
        'price',
        'status',
        'published_at',
        'expires_at',
        'payment_id',
        'visibility',
    ];

    protected $casts = [
        'date_event' => 'datetime',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the event
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if event is published
     */
    public function isPublished(): bool
    {
        return $this->status === 'published' &&
               (!$this->published_at || now()->gte($this->published_at)) &&
               (!$this->expires_at || now()->lte($this->expires_at));
    }

    /**
     * Get package details
     */
    public static function getPackages()
    {
        return [
            'starter' => [
                'name' => 'Starter',
                'price' => 49,
                'duration' => 30,
                'description' => 'Perfect for local events',
                'features' => [
                    'Valid for 30 days',
                    'Basic visibility',
                    'Event details page',
                ]
            ],
            'professional' => [
                'name' => 'Professional',
                'price' => 99,
                'duration' => 60,
                'description' => 'Great for larger events',
                'features' => [
                    'Valid for 60 days',
                    'Enhanced visibility',
                    'Event promotion',
                    'Analytics included',
                ]
            ],
            'premium' => [
                'name' => 'Premium',
                'price' => 199,
                'duration' => 90,
                'description' => 'Maximum exposure for your event',
                'features' => [
                    'Valid for 90 days',
                    'Maximum visibility',
                    'Featured placement',
                    'Advanced analytics',
                    'Priority support',
                ]
            ],
        ];
    }
}
