@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container">
        <!-- Welcome Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="card-title mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                                <p class="card-text mb-0">Manage your event tickets and account settings</p>
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

        <!-- Stats Section -->
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div style="font-size: 2rem; color: #667eea; margin-bottom: 10px;">🎫</div>
                        <h6 class="card-title text-muted">Total Tickets</h6>
                        <h2 class="card-text text-primary">{{ $stats['total'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div style="font-size: 2rem; color: #28a745; margin-bottom: 10px;">✓</div>
                        <h6 class="card-title text-muted">Active Tickets</h6>
                        <h2 class="card-text text-success">{{ $stats['active'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div style="font-size: 2rem; color: #dc3545; margin-bottom: 10px;">✕</div>
                        <h6 class="card-title text-muted">Cancelled</h6>
                        <h2 class="card-text text-danger">{{ $stats['cancelled'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div style="font-size: 2rem; color: #ffc107; margin-bottom: 10px;">💰</div>
                        <h6 class="card-title text-muted">Total Spent</h6>
                        <h2 class="card-text text-warning">${{ number_format($stats['total_spent'], 2) }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>My Tickets</h3>
                    <a href="{{ route('buy-tickets') }}" class="btn btn-primary">Buy More Tickets</a>
                </div>

                @if ($tickets->count() > 0)
                    <div class="row">
                        @foreach ($tickets as $ticket)
                            <div class="col-md-6 mb-3">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">{{ $ticket->type_label }}</h6>
                                            <span class="badge" style="background-color: {{ $ticket->status === 'active' ? '#28a745' : '#dc3545' }};">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2"><strong>Ticket #:</strong> {{ $ticket->ticket_number }}</p>
                                        <p class="mb-2"><strong>Price:</strong> {{ $ticket->price_display }}</p>
                                        <p class="mb-2"><strong>Purchased:</strong> {{ $ticket->purchased_at->format('M d, Y') }}</p>
                                        <p class="mb-3"><strong>Valid Until:</strong> {{ $ticket->valid_until?->format('M d, Y') ?? 'N/A' }}</p>

                                        @if ($ticket->status === 'active')
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('ticket.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                                <form action="{{ route('ticket.cancel', $ticket->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Cancel</button>
                                                </form>
                                            </div>
                                        @else
                                            <p class="text-muted small">This ticket is no longer active</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tickets->links() }}
                    </div>
                @else
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center py-5">
                            <div style="font-size: 3rem; margin-bottom: 20px;">📭</div>
                            <h5 class="card-title">No Tickets Yet</h5>
                            <p class="card-text text-muted mb-4">You haven't purchased any tickets yet.</p>
                            <a href="{{ route('buy-tickets') }}" class="btn btn-primary btn-lg">Get Your Tickets Now</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Profile Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Phone:</strong> {{ Auth::user()->phone ?? 'Not provided' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Company:</strong> {{ Auth::user()->company ?? 'Not provided' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="#" class="btn btn-outline-primary">Edit Profile</a>
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Sign Out</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
