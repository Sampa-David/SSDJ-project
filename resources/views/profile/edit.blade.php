@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mb-0">
                        <i class="fas fa-user-circle" style="color: #667eea;"></i> Edit Profile
                    </h1>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Profile Card -->
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h5 class="mb-0">
                            <i class="fas fa-user-edit"></i> Personal Information
                        </h5>
                    </div>

                    <div class="card-body p-5">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Full Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold">
                                    <i class="fas fa-user" style="color: #667eea;"></i> Full Name
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    placeholder="Enter your full name"
                                    style="border-left: 4px solid #667eea;"
                                >
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">
                                    <i class="fas fa-envelope" style="color: #667eea;"></i> Email Address
                                </label>
                                <input 
                                    type="email" 
                                    class="form-control @error('email') is-invalid @enderror" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    placeholder="Enter your email"
                                    style="border-left: 4px solid #667eea;"
                                >
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-4">
                                <label for="phone" class="form-label fw-bold">
                                    <i class="fas fa-phone" style="color: #667eea;"></i> Phone Number
                                </label>
                                <input 
                                    type="tel" 
                                    class="form-control @error('phone') is-invalid @enderror" 
                                    id="phone" 
                                    name="phone" 
                                    value="{{ old('phone', $user->phone) }}"
                                    placeholder="Enter your phone number (optional)"
                                    style="border-left: 4px solid #667eea;"
                                >
                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Company -->
                            <div class="mb-4">
                                <label for="company" class="form-label fw-bold">
                                    <i class="fas fa-building" style="color: #667eea;"></i> Company
                                </label>
                                <input 
                                    type="text" 
                                    class="form-control @error('company') is-invalid @enderror" 
                                    id="company" 
                                    name="company" 
                                    value="{{ old('company', $user->company) }}"
                                    placeholder="Enter your company name (optional)"
                                    style="border-left: 4px solid #667eea;"
                                >
                                @error('company')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Change Section -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="card-title mb-3">
                                        <i class="fas fa-lock" style="color: #764ba2;"></i> Change Password (Optional)
                                    </h6>
                                    <p class="text-muted small">Leave blank if you don't want to change your password</p>

                                    <!-- Current Password -->
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Current Password</label>
                                        <input 
                                            type="password" 
                                            class="form-control @error('current_password') is-invalid @enderror" 
                                            id="current_password" 
                                            name="current_password" 
                                            placeholder="Enter your current password"
                                            style="border-left: 4px solid #764ba2;"
                                        >
                                        @error('current_password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- New Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">New Password</label>
                                        <input 
                                            type="password" 
                                            class="form-control @error('password') is-invalid @enderror" 
                                            id="password" 
                                            name="password" 
                                            placeholder="Enter new password (min. 8 characters)"
                                            style="border-left: 4px solid #764ba2;"
                                        >
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-0">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <input 
                                            type="password" 
                                            class="form-control" 
                                            id="password_confirmation" 
                                            name="password_confirmation" 
                                            placeholder="Confirm your new password"
                                            style="border-left: 4px solid #764ba2;"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Save Changes
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Info Card -->
                <div class="card shadow-lg border-0 mt-4">
                    <div class="card-header" style="background: #f8f9fa; border-bottom: 2px solid #667eea;">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle" style="color: #667eea;"></i> Account Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="text-muted small mb-1">Member Since</p>
                                <p class="fw-bold">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="text-muted small mb-1">Last Updated</p>
                                <p class="fw-bold">{{ $user->updated_at->format('F d, Y \a\t H:i') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="text-muted small mb-1">Email Status</p>
                                <p class="fw-bold">
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock"></i> Pending
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-label {
        color: #333;
        margin-bottom: 0.75rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
</style>
@endsection
