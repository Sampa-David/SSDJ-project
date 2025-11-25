@extends('layouts.admin')

@section('title', 'Tickets Management')
@section('page-title', 'Tickets Management')

@section('content')
<div class="page-header mb-4">
    <h2>Manage Event Tickets</h2>
</div>

<!-- Stats Row -->
<div class="row mb-4">
    <div class="col-md-2">
        <div class="card stat-card">
            <div class="text-center">
                <h3 class="mb-1">{{ $stats['total'] }}</h3>
                <p class="text-muted mb-0">Total Tickets</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card success">
            <div class="text-center">
                <h3 class="mb-1 text-success">{{ $stats['active'] }}</h3>
                <p class="text-muted mb-0">Active</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card info">
            <div class="text-center">
                <h3 class="mb-1 text-info">{{ $stats['used'] }}</h3>
                <p class="text-muted mb-0">Used</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card warning">
            <div class="text-center">
                <h3 class="mb-1 text-warning">{{ $stats['expired'] }}</h3>
                <p class="text-muted mb-0">Expired</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card stat-card danger">
            <div class="text-center">
                <h3 class="mb-1 text-danger">{{ $stats['cancelled'] }}</h3>
                <p class="text-muted mb-0">Cancelled</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-ticket-alt"></i> All Tickets</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ticket #</th>
                        <th>User</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Valid Until</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td><code>{{ $ticket->ticket_number }}</code></td>
                        <td>{{ $ticket->user->name }}</td>
                        <td>{{ $ticket->type_label }}</td>
                        <td>{{ $ticket->price_display }}</td>
                        <td>{{ $ticket->purchased_at->format('M d, Y') }}</td>
                        <td>{{ $ticket->valid_until ? $ticket->valid_until->format('M d, Y') : '-' }}</td>
                        <td>
                            <span class="badge @if($ticket->status === 'active') bg-success @elseif($ticket->status === 'used') bg-info @elseif($ticket->status === 'expired') bg-warning @else bg-danger @endif">
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
        {{ $tickets->links() }}
    </div>
</div>
@endsection
