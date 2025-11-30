<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'verification_code',
        'temporary_password',
        'attempts',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected $hidden = [
        'temporary_password',
    ];

    /**
     * Generate a random 6-digit verification code
     */
    public static function generateCode(): string
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a temporary password
     */
    public static function generateTemporaryPassword(): string
    {
        return bin2hex(random_bytes(8)); // 16 character hex string
    }

    /**
     * Check if verification code is valid
     */
    public function isCodeValid(string $code): bool
    {
        // Check if code matches
        if ($this->verification_code !== $code) {
            $this->increment('attempts');
            return false;
        }

        // Check if not expired
        if ($this->expires_at < now()) {
            return false;
        }

        // Check if not too many attempts
        if ($this->attempts >= 5) {
            return false;
        }

        return true;
    }

    /**
     * Check if verification has expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at < now();
    }

    /**
     * Check if too many failed attempts
     */
    public function hasTooManyAttempts(): bool
    {
        return $this->attempts >= 5;
    }

    /**
     * Get remaining attempts
     */
    public function getRemainingAttempts(): int
    {
        return max(0, 5 - $this->attempts);
    }
}
