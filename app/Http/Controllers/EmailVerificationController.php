<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\EmailVerificationService;
use Illuminate\Validation\ValidationException;

class EmailVerificationController extends Controller
{
    protected EmailVerificationService $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * Show email verification page
     */
    public function showRegisterForm()
    {
        return view('auth.register-email');
    }

    /**
     * Send verification code to email
     */
    public function sendCode(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        $result = $this->emailVerificationService->sendVerificationCode($validated['email']);

        if (!$result['success']) {
            return back()
                ->withInput()
                ->with('error', $result['message']);
        }

        return redirect()->route('verify.code')
            ->with('success', $result['message'])
            ->with('email', $validated['email'])
            ->with('verification_id', $result['verification_id']);
    }

    /**
     * Show code verification form
     */
    public function showCodeForm()
    {
        $email = session('email');
        
        if (!$email) {
            return redirect()->route('register.email')
                ->with('error', 'Please enter your email first.');
        }

        return view('auth.verify-code', ['email' => $email]);
    }

    /**
     * Verify code and create account
     */
    public function verifyCode(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'string', 'size:6'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'company' => ['nullable', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $result = $this->emailVerificationService->verifyCodeAndCreateAccount(
            email: $validated['email'],
            code: $validated['code'],
            name: $validated['name'],
            phone: $validated['phone'],
            company: $validated['company']
        );

        if (!$result['success']) {
            return back()
                ->withInput()
                ->with('error', $result['message']);
        }

        // Log the user in
        Auth::login($result['user']);

        // Return temporary password
        return redirect()->route('dashboard')
            ->with('success', $result['message'])
            ->with('temporary_password', $result['temporary_password'])
            ->with('needs_password_change', true);
    }

    /**
     * Resend verification code
     */
    public function resendCode(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $result = $this->emailVerificationService->resendVerificationCode($validated['email']);

        if (!$result['success']) {
            return back()
                ->withInput()
                ->with('error', $result['message']);
        }

        return back()->with('success', $result['message']);
    }
}
