@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">Admin Dashboard</h1>
            <p class="text-muted">Welcome back! Here's your event overview.</p>
        </div>
    </div>

    <!-- Key Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Total Users</p>
                            <h3 class="mb-0">{{ $totalUsers }}</h3>
                        </div>
                        <span class="badge bg-primary p-2">
                            <i class="fas fa-users"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Total Tickets</p>
                            <h3 class="mb-0">{{ $totalTickets }}</h3>
                        </div>
                        <span class="badge bg-success p-2">
                            <i class="fas fa-ticket-alt"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Total Revenue</p>
                            <h3 class="mb-0">${{ number_format($totalRevenue, 2) }}</h3>
                        </div>
                        <span class="badge bg-warning p-2">
                            <i class="fas fa-dollar-sign"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1">Active Tickets</p>
                            <h3 class="mb-0">{{ $activeTickets }}</h3>
                        </div>
                        <span class="badge bg-info p-2">
                            <i class="fas fa-check-circle"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Revenue by Type -->
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Revenue by Ticket Type</h5>
                </div>
                <div class="card-body">
                    <div id="revenueChart" style="height: 300px;"></div>
                    <table class="table table-sm mt-3">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Count</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenueByType as $item)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $item->ticket_type)) }}</td>
                                <td>{{ $item->count }}</td>
                                <td>${{ number_format($item->revenue, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ticket Status Distribution -->
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Ticket Status</h5>
                </div>
                <div class="card-body">
                    <div id="statusChart" style="height: 300px;"></div>
                    <div class="mt-3">
                        @foreach($ticketStatus as $status => $count)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-capitalize">{{ $status }}</span>
                            <span class="badge bg-secondary">{{ $count }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Transactions</h5>
                    <a href="{{ route('admin.tickets') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->purchased_at->format('M d, Y') }}</td>
                                    <td>{{ $transaction->user->name }}</td>
                                    <td><span class="badge bg-light text-dark">{{ $transaction->type_label }}</span></td>
                                    <td>${{ $transaction->price_display }}</td>
                                    <td>
                                        <span class="badge @if($transaction->status === 'active') bg-success @elseif($transaction->status === 'used') bg-info @else bg-danger @endif">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.ticket', $transaction) }}" class="btn btn-sm btn-outline-primary">
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

    <!-- Top Buyers & Expiring Tickets -->
    <div class="row">
        <!-- Top Buyers -->
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Top Buyers</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($topBuyers as $buyer)
                        <a href="{{ route('admin.user', $buyer) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $buyer->name }}</h6>
                                <small class="text-muted">{{ $buyer->email }}</small>
                            </div>
                            <span class="badge bg-primary">{{ $buyer->tickets_count }} tickets</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Expiring Tickets -->
        <div class="col-md-6 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Expiring Soon (30 days)</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @forelse($expiringTickets as $ticket)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-0">{{ $ticket->user->name }}</h6>
                                    <small class="text-muted">{{ $ticket->type_label }} - Expires: {{ $ticket->valid_until->format('M d, Y') }}</small>
                                </div>
                                <span class="badge bg-warning">{{ $ticket->ticket_number }}</span>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center py-3">No expiring tickets</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue by Type Chart
    const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($revenueByType->pluck('ticket_type')->map(fn($t) => ucfirst(str_replace('_', ' ', $t)))) !!},
                datasets: [{
                    data: {!! json_encode($revenueByType->pluck('revenue')) !!},
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Status Chart
    const statusCtx = document.getElementById('statusChart')?.getContext('2d');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($ticketStatus->keys()) !!},
                datasets: [{
                    data: {!! json_encode($ticketStatus->values()) !!},
                    backgroundColor: ['#28a745', '#007bff', '#ffc107', '#dc3545', '#6c757d']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>
@endpush
