@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">Tickets Management</h1>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="card text-center">
                <div class="card-body">
                    <h3>{{ $stats['total'] }}</h3>
                    <p class="text-muted">Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h3 class="text-success">{{ $stats['active'] }}</h3>
                    <p class="text-muted">Active</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-info">
                <div class="card-body">
                    <h3 class="text-info">{{ $stats['used'] }}</h3>
                    <p class="text-muted">Used</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-warning">
                <div class="card-body">
                    <h3 class="text-warning">{{ $stats['expired'] }}</h3>
                    <p class="text-muted">Expired</p>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <h3 class="text-danger">{{ $stats['cancelled'] }}</h3>
                    <p class="text-muted">Cancelled</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
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
</div>
@endsection
