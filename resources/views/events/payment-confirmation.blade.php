@extends('layouts.app')

@section('title', 'Payment Confirmation - Eventix')

@section('content')

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success Message -->
                <div class="card shadow-lg border-0 mb-4">
                    <div class="card-body text-center py-5" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 10px;">
                        <div style="font-size: 4rem; margin-bottom: 20px;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h1 class="card-title mb-3">Payment Successful! ✅</h1>
                        <p class="card-text" style="font-size: 1.1rem;">You now have publishing rights for events</p>
                    </div>
                </div>

                <!-- Publishing Rights Details -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">📅 Publishing Rights</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Plan:</strong></p>
                                <p>
                                    <span class="badge bg-primary">{{ $package['name'] }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Duration:</strong></p>
                                <p>{{ $package['duration'] }} days</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Purchased:</strong></p>
                                <p>{{ $publishingRight->purchased_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Expires:</strong></p>
                                <p>{{ $publishingRight->expires_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction Details -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">💳 Transaction Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <p><strong>Plan:</strong> {{ $package['name'] }}</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <p>${{ number_format($publishingRight->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-8">
                                <p><strong>Tax (0%):</strong></p>
                            </div>
                            <div class="col-md-4 text-end">
                                <p>$0.00</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                <h5><strong>Total:</strong></h5>
                            </div>
                            <div class="col-md-4 text-end">
                                <h5 style="color: #667eea;"><strong>${{ number_format($publishingRight->price, 2) }}</strong></h5>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <p class="text-muted"><small><strong>Payment ID:</strong> {{ $publishingRight->payment_id }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Features Included -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">🎁 Features Included</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach ($package['features'] as $feature)
                                <li class="mb-2">
                                    <i class="fas fa-check" style="color: #28a745;"></i>
                                    <span class="ms-2">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('events.create') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-plus"></i> Create Your First Event
                                </a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-home"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
