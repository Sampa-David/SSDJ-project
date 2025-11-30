<?php

namespace App\Services;

use App\Models\User;
use App\Models\EmailVerification;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailVerificationService
{
    /**
     * Send verification code to email
     * 
     * @param string $email
     * @return array ['success' => bool, 'message' => string, 'verification_id' => int|null]
     */
    public function sendVerificationCode(string $email): array
    {
        try {
            // Check if email already exists in users table
            if (User::where('email', $email)->exists()) {
                return [
                    'success' => false,
                    'message' => 'Email already registered.',
                ];
            }

            // Generate verification code and temporary password
            $code = EmailVerification::generateCode();
            $tempPassword = EmailVerification::generateTemporaryPassword();

            // Create or update verification record
            $verification = EmailVerification::updateOrCreate(
                ['email' => $email],
                [
                    'verification_code' => $code,
                    'temporary_password' => $tempPassword,
                    'attempts' => 0,
                    'expires_at' => now()->addMinutes(15), // Code valid for 15 minutes
                ]
            );

            // Send verification email
            Mail::to($email)->send(new VerificationCodeMail($code, $verification->id));

            return [
                'success' => true,
                'message' => 'Verification code sent to your email.',
                'verification_id' => $verification->id,
            ];
        } catch (\Exception $e) {
            Log::error('Email verification error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to send verification code. Please try again.',
            ];
        }
    }

    /**
     * Verify code and create account
     * 
     * @param string $email
     * @param string $code
     * @param string $name
     * @param string $phone
     * @param string $company
     * @return array ['success' => bool, 'message' => string, 'user' => User|null]
     */
    public function verifyCodeAndCreateAccount(
        string $email,
        string $code,
        string $name,
        string $phone = null,
        string $company = null
    ): array {
        try {
            // Find verification record
            $verification = EmailVerification::where('email', $email)->first();

            if (!$verification) {
                return [
                    'success' => false,
                    'message' => 'Verification code not found. Please request a new one.',
                ];
            }

            // Check if code is expired
            if ($verification->isExpired()) {
                $verification->delete();
                return [
                    'success' => false,
                    'message' => 'Verification code has expired. Please request a new one.',
                ];
            }

            // Check if too many failed attempts
            if ($verification->hasTooManyAttempts()) {
                return [
                    'success' => false,
                    'message' => 'Too many failed attempts. Please request a new verification code.',
                ];
            }

            // Verify code
            if (!$verification->isCodeValid($code)) {
                $remaining = $verification->getRemainingAttempts();
                return [
                    'success' => false,
                    'message' => "Invalid verification code. Attempts remaining: {$remaining}",
                ];
            }

            // Create user account
            $user = DB::transaction(function () use ($verification, $email, $name, $phone, $company) {
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt($verification->temporary_password),
                    'phone' => $phone,
                    'company' => $company,
                    'email_verified_at' => now(), // Mark email as verified
                ]);

                // Delete verification record after successful account creation
                $verification->delete();

                return $user;
            });

            return [
                'success' => true,
                'message' => 'Account created successfully.',
                'user' => $user,
                'temporary_password' => $verification->temporary_password,
            ];
        } catch (\Exception $e) {
            Log::error('Account creation error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to create account. Please try again.',
            ];
        }
    }

    /**
     * Resend verification code
     * 
     * @param string $email
     * @return array ['success' => bool, 'message' => string]
     */
    public function resendVerificationCode(string $email): array
    {
        try {
            // Delete old verification if exists
            EmailVerification::where('email', $email)->delete();

            // Send new code
            return $this->sendVerificationCode($email);
        } catch (\Exception $e) {
            Log::error('Resend verification error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to resend verification code. Please try again.',
            ];
        }
    }

    /**
     * Cleanup expired verification codes
     */
    public function cleanupExpiredCodes(): int
    {
        return EmailVerification::where('expires_at', '<', now())->delete();
    }

    /**
     * Get verification details (for debugging/admin purposes)
     */
    public function getVerificationDetails(string $email): ?EmailVerification
    {
        return EmailVerification::where('email', $email)->first();
    }
}
