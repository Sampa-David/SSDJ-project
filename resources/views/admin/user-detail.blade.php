@extends('layouts.admin')

@section('title', 'User Details')
@section('page-title', 'User Details: ' . $user->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Users
    </a>
</div>

    <div class="row">
        <!-- User Info -->
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user"></i> {{ $user->name }}</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3"><i class="fas fa-envelope"></i> {{ $user->email }}</p>
                    <hr>
                    <p><strong><i class="fas fa-phone"></i> Phone:</strong> {{ $user->phone ?? '-' }}</p>
                    <p><strong><i class="fas fa-building"></i> Company:</strong> {{ $user->company ?? '-' }}</p>
                    <p><strong><i class="fas fa-calendar"></i> Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Total Spent</small>
                        <h4 class="text-success">${{ number_format($userStats['totalSpent'], 2) }}</h4>
                    </div>
                    <div class="mb-3 pb-2 border-bottom">
                        <small class="text-muted">Total Tickets</small>
                        <h4>{{ $userStats['totalTickets'] }}</h4>
                    </div>
                    <div class="mb-3 pb-2 border-bottom">
                        <small class="text-muted">Active Tickets</small>
                        <h4 class="text-info">{{ $userStats['activeTickets'] }}</h4>
                    </div>
                    <div>
                        <small class="text-muted">Last Purchase</small>
                        <h6 class="mb-0">
                            {{ $userStats['lastPurchase'] ? $userStats['lastPurchase']->format('M d, Y') : '-' }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Tickets -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-ticket-alt"></i> User Tickets</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Ticket #</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->tickets as $ticket)
                                <tr>
                                    <td><code>{{ $ticket->ticket_number }}</code></td>
                                    <td>{{ $ticket->type_label }}</td>
                                    <td class="fw-bold">${{ $ticket->price_display }}</td>
                                    <td>{{ $ticket->purchased_at->format('M d, Y') }}</td>
                                    <td>
                                        <span class="badge @if($ticket->status === 'active') bg-success @elseif($ticket->status === 'used') bg-info @else bg-danger @endif">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.ticket', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox"></i> No tickets yet
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
