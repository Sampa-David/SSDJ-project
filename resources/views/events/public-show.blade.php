@extends('layouts.app')

@section('title', $event->name . ' - Eventix')

@section('content')

<div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">{{ $event->name }}</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('events.public.list') }}">Events</a></li>
                <li class="current">{{ $event->name }}</li>
            </ol>
        </nav>
    </div>
</div><!-- End Page Title -->

<section id="event-details" class="event-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Event Header Card -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 10px; overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px;">
                        <h2 class="mb-3">{{ $event->name }}</h2>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="bi bi-calendar3"></i>
                                    <strong>Date:</strong> {{ $event->date_event->format('l, F d, Y') }}
                                </p>
                                <p class="mb-2">
                                    <i class="bi bi-clock"></i>
                                    <strong>Time:</strong> TBD
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <i class="bi bi-geo-alt"></i>
                                    <strong>Location:</strong> {{ $event->location }}
                                </p>
                                <p class="mb-2">
                                    <i class="bi bi-globe"></i>
                                    <strong>Visibility:</strong> Public
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">About This Event</h5>
                    </div>
                    <div class="card-body">
                        <p class="lead">{{ $event->description }}</p>
                        
                        @if($event->package_type)
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Event Package</h6>
                                    <p><strong>{{ ucfirst($event->package_type) }}</strong></p>
                                </div>
                                @if($event->price)
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Entry Price</h6>
                                        <p><strong>${{ number_format($event->price, 2) }}</strong></p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Organizer Info -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Organizer</h5>
                    </div>
                    <div class="card-body text-center">
                        <div style="font-size: 3rem; color: #667eea; margin-bottom: 10px;">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h6 class="mb-2">{{ $event->user->name ?? 'Unknown' }}</h6>
                        <p class="text-muted small">{{ $event->user->email ?? '' }}</p>
                        <p class="text-muted small">
                            <i class="bi bi-building"></i>
                            {{ $event->user->company ?? 'Event Organizer' }}
                        </p>
                    </div>
                </div>

                <!-- Event Info Card -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 10px;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Event Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted">Status</small>
                                <p class="mb-0">
                                    <span class="badge bg-success">Published</span>
                                </p>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Created</small>
                                <p class="mb-0">{{ $event->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        @if($event->expires_at)
                            <div class="row">
                                <div class="col-12">
                                    <small class="text-muted">Expires</small>
                                    <p class="mb-0">{{ $event->expires_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow-sm border-0" style="border-radius: 10px;">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('buy-tickets') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-ticket-perforated"></i> Get Tickets
                            </a>
                            <a href="{{ route('events.public.list') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Events
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .page-title {
        --color-primary: #667eea;
        --color-primary-rgb: 102, 126, 234;
        padding: 60px 0 30px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }

    .page-title h1 {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .breadcrumbs {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 14px;
    }

    .breadcrumbs ol {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .breadcrumbs ol li {
        display: flex;
        align-items: center;
    }

    .breadcrumbs ol li + li:before {
        display: inline-block;
        padding-right: 10px;
        color: #6c757d;
        content: "/";
    }

    .breadcrumbs ol li + li {
        padding-left: 10px;
    }

    .breadcrumbs ol li a {
        color: #667eea;
        transition: 0.3s;
    }

    .breadcrumbs ol li a:hover {
        color: #764ba2;
    }

    .breadcrumbs ol li.current {
        color: #6c757d;
    }
</style>

@endsection
