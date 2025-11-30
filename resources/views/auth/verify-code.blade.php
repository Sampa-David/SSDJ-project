@extends('layouts.app')

@section('title', 'Verify Email - Complete Registration')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-5">
                        <h2 class="card-title mb-3">Complete Your Registration</h2>
                        <p class="text-muted">Steps 2-3 of 3: Verify Email & Create Account</p>
                        <p class="text-primary fw-bold">Verification code sent to <strong>{{ session('email') }}</strong></p>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Main Form -->
                    <form action="{{ route('register.verify-code') }}" method="POST">
                        @csrf

                        <!-- Hidden Email Field -->
                        <input type="hidden" name="email" value="{{ session('email') }}">

                        <!-- Section 1: Verification Code -->
                        <div class="mb-5 p-4 bg-light rounded">
                            <h5 class="mb-4">
                                <i class="bi bi-shield-check text-success"></i> Step 1: Verify Email
                            </h5>

                            <div class="mb-4">
                                <label for="code" class="form-label">Verification Code <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    class="form-control form-control-lg @error('code') is-invalid @enderror text-center"
                                    id="code" 
                                    name="code" 
                                    placeholder="000000"
                                    maxlength="6"
                                    pattern="[0-9]{6}"
                                    value="{{ old('code') }}"
                                    required
                                    autofocus
                                    style="letter-spacing: 8px; font-size: 24px; font-weight: bold;"
                                >
                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted d-block mt-2">
                                    Enter the 6-digit code sent to your email
                                </small>
                            </div>

                            <!-- Resend Code Link -->
                            <div class="text-center">
                                <small class="text-muted">
                                    Didn't receive the code? 
                                    <form action="{{ route('register.resend-code') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="email" value="{{ session('email') }}">
                                        <button type="submit" class="btn btn-link btn-sm p-0">Resend it</button>
                                    </form>
                                </small>
                            </div>
                        </div>

                        <!-- Section 2: Account Details -->
                        <div class="mb-5 p-4 bg-light rounded">
                            <h5 class="mb-4">
                                <i class="bi bi-person-fill text-info"></i> Step 2: Account Information
                            </h5>

                            <!-- Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        class="form-control @error('name') is-invalid @enderror" 
                                        id="name" 
                                        name="name" 
                                        placeholder="Enter your full name"
                                        value="{{ old('name') }}"
                                        required
                                    >
                                </div>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="form-label">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-telephone"></i>
                                    </span>
                                    <input 
                                        type="tel" 
                                        class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" 
                                        name="phone" 
                                        placeholder="(Optional)"
                                        value="{{ old('phone') }}"
                                    >
                                </div>
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company -->
                            <div class="mb-4">
                                <label for="company" class="form-label">Company/Organization</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-briefcase"></i>
                                    </span>
                                    <input 
                                        type="text" 
                                        class="form-control @error('company') is-invalid @enderror" 
                                        id="company" 
                                        name="company" 
                                        placeholder="(Optional)"
                                        value="{{ old('company') }}"
                                    >
                                </div>
                                @error('company')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 3: Password -->
                        <div class="mb-5 p-4 bg-light rounded">
                            <h5 class="mb-4">
                                <i class="bi bi-lock-fill text-warning"></i> Step 3: Create Password
                            </h5>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input 
                                        type="password" 
                                        class="form-control @error('password') is-invalid @enderror" 
                                        id="password" 
                                        name="password" 
                                        placeholder="Minimum 8 characters"
                                        required
                                    >
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted d-block mt-2">
                                    Must be at least 8 characters long. Use uppercase, numbers, and symbols for security.
                                </small>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input 
                                        type="password" 
                                        class="form-control @error('password_confirmation') is-invalid @enderror" 
                                        id="password_confirmation" 
                                        name="password_confirmation" 
                                        placeholder="Repeat your password"
                                        required
                                    >
                                </div>
                                @error('password_confirmation')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="mb-4 form-check">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="terms" 
                                name="terms"
                                required
                            >
                            <label class="form-check-label" for="terms">
                                I agree to the 
                                <a href="{{ route('terms') }}" target="_blank">Terms of Service</a> and 
                                <a href="{{ route('privacy') }}" target="_blank">Privacy Policy</a>
                                <span class="text-danger">*</span>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="bi bi-check-circle"></i> Complete Registration
                        </button>

                        <!-- Back Link -->
                        <div class="text-center">
                            <p class="text-muted mb-0">
                                <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border: none;
        border-radius: 12px;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .form-control-lg {
        height: auto;
        padding: 15px;
    }
    
    .btn-primary {
        background-color: #007bff;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    h5 i {
        margin-right: 8px;
    }
</style>

<script>
    // Auto-format verification code input
    document.getElementById('code').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
    });

    // Password strength indicator (optional)
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strength = calculatePasswordStrength(this.value);
            // You can add visual feedback here if desired
        });
    }

    function calculatePasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;
        return strength;
    }
</script>
@endsection
