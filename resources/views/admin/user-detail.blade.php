@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Info -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <hr>
                    <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
                    <p><strong>Company:</strong> {{ $user->company ?? '-' }}</p>
                    <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Total Spent</small>
                        <h4>${{ number_format($userStats['totalSpent'], 2) }}</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Total Tickets</small>
                        <h4>{{ $userStats['totalTickets'] }}</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Active Tickets</small>
                        <h4>{{ $userStats['activeTickets'] }}</h4>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Tickets</h6>
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
                                @foreach($user->tickets as $ticket)
                                <tr>
                                    <td><code>{{ $ticket->ticket_number }}</code></td>
                                    <td>{{ $ticket->type_label }}</td>
                                    <td>{{ $ticket->price_display }}</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
