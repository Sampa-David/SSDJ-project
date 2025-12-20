@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mb-0">
                        <i class="fas fa-user-circle" style="color: #667eea;"></i> My Profile
                    </h1>
                    <div class="d-flex gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Card -->
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h5 class="mb-0">
                            <i class="fas fa-user"></i> Personal Information
                        </h5>
                    </div>

                    <div class="card-body p-5">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-user" style="color: #667eea;"></i> Full Name
                                </p>
                                <p class="h5 fw-bold">{{ $user->name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-envelope" style="color: #667eea;"></i> Email Address
                                </p>
                                <p class="h5 fw-bold">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-phone" style="color: #667eea;"></i> Phone Number
                                </p>
                                <p class="h5 fw-bold">
                                    {{ $user->phone ?? 'Not provided' }}
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-building" style="color: #667eea;"></i> Company
                                </p>
                                <p class="h5 fw-bold">
                                    {{ $user->company ?? 'Not provided' }}
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-calendar-alt" style="color: #667eea;"></i> Member Since
                                </p>
                                <p class="h5 fw-bold">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-sync-alt" style="color: #667eea;"></i> Last Updated
                                </p>
                                <p class="h5 fw-bold">{{ $user->updated_at->format('F d, Y \a\t H:i') }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-shield-alt" style="color: #667eea;"></i> Email Status
                                </p>
                                <p class="h5 fw-bold">
                                    @if ($user->email_verified_at)
                                        <span class="badge bg-success" style="font-size: 0.95rem;">
                                            <i class="fas fa-check-circle"></i> Verified
                                        </span>
                                    @else
                                        <span class="badge bg-warning" style="font-size: 0.95rem;">
                                            <i class="fas fa-clock"></i> Pending Verification
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body text-center p-4">
                                <div style="font-size: 2rem; color: #667eea; margin-bottom: 10px;">🎫</div>
                                <p class="text-muted small mb-1">Total Tickets Purchased</p>
                                <h3 class="mb-0 text-primary">{{ $user->tickets()->count() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body text-center p-4">
                                <div style="font-size: 2rem; color: #764ba2; margin-bottom: 10px;">📅</div>
                                <p class="text-muted small mb-1">Events Created</p>
                                <h3 class="mb-0 text-primary">{{ $user->events()->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
    }
</style>
@endsection
