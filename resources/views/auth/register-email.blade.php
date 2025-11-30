@extends('layouts.app')

@section('title', 'Register - Email Verification')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <!-- Header -->
                    <div class="text-center mb-5">
                        <h2 class="card-title mb-3">Create Account</h2>
                        <p class="text-muted">Step 1 of 3: Enter Your Email</p>
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

                    <!-- Email Form -->
                    <form action="{{ route('register.send-code') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    placeholder="Enter your email address"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                >
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted d-block mt-2">
                                We'll send a verification code to this email address
                            </small>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-send"></i> Send Verification Code
                        </button>

                        <!-- Link to Login -->
                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a>
                            </p>
                        </div>
                    </form>

                    <!-- Information Box -->
                    <div class="mt-5 p-4 bg-light rounded">
                        <h6 class="mb-3">
                            <i class="bi bi-info-circle text-info"></i> What happens next?
                        </h6>
                        <ul class="small mb-0">
                            <li>We'll send a 6-digit verification code to your email</li>
                            <li>The code will be valid for 15 minutes</li>
                            <li>Use the code to complete your registration</li>
                            <li>Create your account with a secure password</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Link -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    By registering, you agree to our 
                    <a href="{{ route('terms') }}" class="text-decoration-none">Terms of Service</a> and 
                    <a href="{{ route('privacy') }}" class="text-decoration-none">Privacy Policy</a>
                </small>
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
    
    .btn-primary {
        background-color: #007bff;
        border: none;
        font-weight: 500;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
</style>
@endsection
