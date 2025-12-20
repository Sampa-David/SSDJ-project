@extends('layouts.admin')

@section('title', 'Activity Logs')
@section('page-title', 'Activity Logs')

@section('content')
<div class="page-header mb-4">
    <div>
        <h2>Activity Logs</h2>
        <p class="text-muted">Monitor all system and user activities</p>
    </div>
    <div class="btn-group-header">
        <a href="{{ route('admin.activity-logs.export') }}" class="btn btn-outline-secondary">
            <i class="fas fa-download me-1"></i> Export CSV
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Total Logs</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($totalLogs) }}</h2>
                    </div>
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-list"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Today's Activities</p>
                        <h2 class="mb-0 fw-bold">{{ number_format($todayLogs) }}</h2>
                    </div>
                    <div class="stat-icon bg-success">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-bar text-info"></i> Top Activities</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($actionStats as $stat)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-4 py-2">
                        <span class="text-capitalize">{{ str_replace('_', ' ', $stat->action) }}</span>
                        <span class="badge bg-primary">{{ $stat->count }}</span>
                    </div>
                    @empty
                    <p class="text-muted text-center py-4 mb-0"><i class="fas fa-inbox"></i> No activities yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-filter"></i> Filters</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.activity-logs') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Action</label>
                <select name="action" class="form-select form-select-sm">
                    <option value="">All Actions</option>
                    @foreach($actions as $action)
                    <option value="{{ $action }}" @selected(request('action') === $action)>
                        {{ ucfirst(str_replace('_', ' ', $action)) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">User</label>
                <select name="user_id" class="form-select form-select-sm">
                    <option value="">All Users</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(request('user_id') === (string)$user->id)>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
            </div>

            <div class="col-md-2">
                <label class="form-label">Search</label>
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ request('search') }}">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.activity-logs') }}" class="btn btn-outline-secondary btn-sm ms-2">
                    <i class="fas fa-redo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Activity Logs Table -->
<div class="card">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-history text-info"></i> Activity Logs</h5>
        <small class="text-muted">Showing {{ $logs->count() }} of {{ $logs->total() }} total</small>
    </div>
    <div class="card-body p-0">
        @if($logs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date & Time</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>Model</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td class="fw-5">
                                {{ $log->created_at->format('M d, Y') }}<br>
                                <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                            </td>
                            <td>
                                @if($log->user)
                                    <a href="{{ route('admin.user', $log->user) }}" class="text-decoration-none">
                                        {{ $log->user->name }}
                                    </a>
                                @else
                                    <span class="badge bg-secondary">System</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @if(str_contains($log->action, 'login')) bg-primary
                                    @elseif(str_contains($log->action, 'deleted')) bg-danger
                                    @elseif(str_contains($log->action, 'created')) bg-success
                                    @elseif(str_contains($log->action, 'purchased')) bg-warning
                                    @else bg-info @endif">
                                    {{ $log->action_label }}
                                </span>
                            </td>
                            <td>
                                {{ $log->description ?? '-' }}
                            </td>
                            <td>
                                @if($log->model_type)
                                    <small class="text-muted">
                                        {{ class_basename($log->model_type) }} #{{ $log->model_id }}
                                    </small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted" title="{{ $log->user_agent }}">
                                    {{ $log->ip_address ?? '-' }}
                                </small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer bg-light">
                {{ $logs->links() }}
            </div>
        @else
            <p class="text-muted text-center py-5 mb-0">
                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                No activity logs found
            </p>
        @endif
    </div>
</div>

<!-- Clear Old Logs Section -->
<div class="card mt-4">
    <div class="card-header bg-light bg-danger-light">
        <h5 class="mb-0 text-danger"><i class="fas fa-trash"></i> Maintenance</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-warning mb-3">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Warning:</strong> Clearing old logs cannot be undone. Only keep logs you need.
        </div>
        <form method="POST" action="{{ route('admin.activity-logs.clear') }}" class="d-flex gap-3 align-items-end">
            @csrf
            <div class="flex-grow-1" style="max-width: 300px;">
                <label class="form-label">Keep logs from last (days):</label>
                <input type="number" name="days" class="form-control" value="30" min="7" max="365" required>
                <small class="text-muted">Minimum 7 days, maximum 365 days</small>
            </div>
            <button type="submit" class="btn btn-danger" onclick="return confirm('Delete old logs? This cannot be undone!')">
                <i class="fas fa-trash me-1"></i> Clear Old Logs
            </button>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
.bg-danger-light {
    background-color: rgba(220, 53, 69, 0.1);
}
</style>
@endpush
