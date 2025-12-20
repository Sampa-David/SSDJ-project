@extends('layouts.admin')

@section('content')

<div class="admin-page">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-comments"></i>
                Messages & Conversations
            </h1>
            <p class="page-subtitle">Manage customer support conversations</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">Total Conversations</h6>
                    <h3 class="stat-value">{{ \App\Models\Conversation::count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-lock-open"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">Open</h6>
                    <h3 class="stat-value">{{ \App\Models\Conversation::where('status', 'open')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">Pending</h6>
                    <h3 class="stat-value">{{ \App\Models\Conversation::where('status', 'pending')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon bg-danger">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">High Priority</h6>
                    <h3 class="stat-value">{{ \App\Models\Conversation::where('priority', 'high')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Conversations</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Subject</th>
                        <th>Assigned Admin</th>
                        <th>Messages</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($conversations as $conversation)
                    <tr>
                        <td>
                            <strong>{{ $conversation->user->name }}</strong><br>
                            <small class="text-muted">{{ $conversation->user->email }}</small>
                        </td>
                        <td>
                            <a href="{{ route('messages.show', $conversation) }}" class="text-decoration-none">
                                {{ Str::limit($conversation->subject, 40) }}
                            </a>
                        </td>
                        <td>
                            <span class="badge badge-secondary">
                                {{ $conversation->admin?->name ?? 'Unassigned' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-info">
                                {{ $conversation->messages()->count() }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $conversation->priority === 'high' ? 'danger' : ($conversation->priority === 'medium' ? 'warning' : 'info') }}">
                                {{ ucfirst($conversation->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $conversation->status === 'open' ? 'success' : ($conversation->status === 'pending' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($conversation->status) }}
                            </span>
                        </td>
                        <td>
                            {{ $conversation->updated_at->diffForHumans() }}
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('messages.show', $conversation) }}" class="btn btn-sm btn-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('messages.destroy', $conversation) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <p class="text-muted mb-0">No conversations found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($conversations->hasPages())
        <div class="card-footer">
            {{ $conversations->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

<style>
.stat-card {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    margin-right: 1.5rem;
}

.stat-icon.bg-primary {
    background-color: #007bff;
}

.stat-icon.bg-success {
    background-color: #28a745;
}

.stat-icon.bg-warning {
    background-color: #ffc107;
}

.stat-icon.bg-danger {
    background-color: #dc3545;
}

.stat-content h6 {
    margin: 0;
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 600;
}

.stat-content .stat-value {
    margin: 0.5rem 0 0 0;
    font-size: 1.75rem;
    font-weight: 700;
    color: #333;
}

.action-buttons {
    display: flex;
    gap: 5px;
}

.action-buttons form {
    display: inline;
}
</style>

@endsection
