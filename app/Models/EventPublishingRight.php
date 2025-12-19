<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventPublishingRight extends Model
{
    protected $fillable = [
        'user_id',
        'package_type',
        'price',
        'status',
        'purchased_at',
        'expires_at',
        'payment_id',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns this publishing right
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the publishing right is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' &&
               (!$this->expires_at || now()->lte($this->expires_at));
    }

    /**
     * Get package details
     */
    public static function getPackages()
    {
        return [
            'monthly' => [
                'name' => 'Monthly Pass',
                'price' => 29,
                'duration' => 30,
                'description' => 'Publish events for 1 month',
                'features' => [
                    'Valid for 30 days',
                    'Unlimited events',
                    'Edit events anytime',
                    'Basic analytics',
                ]
            ],
            'quarterly' => [
                'name' => 'Quarterly Pass',
                'price' => 79,
                'duration' => 90,
                'description' => 'Publish events for 3 months',
                'features' => [
                    'Valid for 90 days',
                    'Unlimited events',
                    'Edit events anytime',
                    'Advanced analytics',
                    'Priority support',
                ]
            ],
            'yearly' => [
                'name' => 'Yearly Pass',
                'price' => 199,
                'duration' => 365,
                'description' => 'Publish events for 1 year',
                'features' => [
                    'Valid for 365 days',
                    'Unlimited events',
                    'Edit events anytime',
                    'Advanced analytics',
                    'Priority support',
                    'Special badge',
                ]
            ],
        ];
    }
}
