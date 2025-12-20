@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Welcome Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="card-title mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                                <p class="card-text mb-0">Manage your tickets and events</p>
                            </div>
                            <div class="text-end">
                                <p class="small mb-1">Member Since</p>
                                <p class="h5 mb-0">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content with Sidebar -->
        <div class="row">
            <!-- Sidebar -->
            @include('components.dashboard-sidebar')

            <!-- Main Content -->
            <div class="col-lg-9">
                <!-- Stats Section -->
                <div class="row mb-5">
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body text-center">
                                <div style="font-size: 2rem; color: #667eea; margin-bottom: 10px;">🎫</div>
                                <h6 class="card-title text-muted">Total Tickets</h6>
                                <h2 class="card-text text-primary">{{ $stats['total'] }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-body text-center">
                                <div style="font-size: 2rem; color: #ffc107; margin-bottom: 10px;">📅</div>
                                <h6 class="card-title text-muted">My Events</h6>
                                <h2 class="card-text text-warning">{{ Auth::user()->events()->count() }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Create Event CTA -->
                @if(Auth::user()->hasActivePublishingRights())
                    <div class="card shadow-lg border-0 mb-5" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <h4 class="mb-2">📅 Create Your Next Event</h4>
                                    <p class="mb-0">Your publishing rights are active. Start creating and managing your events now.</p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <a href="{{ route('events.create') }}" class="btn btn-light btn-lg">
                                        Create Event
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card shadow-lg border-0 mb-5" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: #333;">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-9">
                                    <h4 class="mb-2">🔓 Get Publishing Rights</h4>
                                    <p class="mb-0">Pay once to get unlimited event creation and management for your chosen period.</p>
                                </div>
                                <div class="col-md-3 text-end">
                                    <a href="{{ route('events.payment') }}" class="btn btn-dark btn-lg">
                                        Get Rights
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Tickets Section -->
                <div class="card shadow-sm border-0 mb-5">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">My Tickets</h5>
                        <a href="{{ route('buy-tickets') }}" class="btn btn-primary btn-sm">Buy More</a>
                    </div>
                    <div class="card-body">
                        @if ($tickets->count() > 0)
                            <div class="row">
                                @foreach ($tickets->take(4) as $ticket)
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-0" style="border-left: 4px solid #667eea;">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <h6 class="mb-0">{{ $ticket->type_label }}</h6>
                                                    <span class="badge" style="background-color: {{ $ticket->status === 'active' ? '#28a745' : '#dc3545' }};">
                                                        {{ ucfirst($ticket->status) }}
                                                    </span>
                                                </div>
                                                <small class="text-muted d-block mb-2">{{ $ticket->ticket_number }}</small>
                                                <p class="mb-2"><strong>${{ number_format($ticket->price, 2) }}</strong></p>
                                                <a href="{{ route('ticket.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center">
                                <a href="{{ route('my-tickets') }}" class="btn btn-outline-primary">View All Tickets</a>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div style="font-size: 2rem; margin-bottom: 10px;">🎫</div>
                                <p class="text-muted mb-3">No tickets yet</p>
                                <a href="{{ route('buy-tickets') }}" class="btn btn-primary">Buy Tickets</a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Events -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">My Recent Events</h5>
                        <a href="{{ route('events.index') }}" class="btn btn-primary btn-sm">View All</a>
                    </div>
                    <div class="card-body">
                        @php
                            $events = Auth::user()->events()->latest()->take(3)->get();
                        @endphp
                        
                        @if ($events->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($events as $event)
                                    <div class="list-group-item px-0 py-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $event->name }}</h6>
                                                <small class="text-muted d-block mb-1">
                                                    <i class="fas fa-calendar"></i> {{ $event->date_event->format('M d, Y') }} | 
                                                    <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                                </small>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-package"></i> {{ ucfirst($event->package_type ?? 'N/A') }} - ${{ number_format($event->price ?? 0, 2) }}
                                                </small>
                                            </div>
                                            <div>
                                                @if($event->status === 'published')
                                                    <span class="badge bg-success">Published</span>
                                                @elseif($event->status === 'expired')
                                                    <span class="badge bg-danger">Expired</span>
                                                @else
                                                    <span class="badge bg-warning">{{ ucfirst($event->status) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div style="font-size: 2rem; margin-bottom: 10px;">📅</div>
                                <p class="text-muted mb-3">No events yet</p>
                                <a href="{{ route('events.payment') }}" class="btn btn-primary">Create Event</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('components.floating-message-btn')

@endsection
