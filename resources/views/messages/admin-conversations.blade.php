@extends('layouts.admin')

@section('title', 'Messages - Admin')
@section('page-title', 'Support Messages')

@section('content')

<!-- Messages Header -->
<div class="page-header">
    <div>
        <h2>Support Messages</h2>
        <p class="text-muted">Manage customer conversations and support tickets.</p>
    </div>
    <div class="header-actions">
        <span class="badge bg-info">
            <i class="fas fa-inbox"></i> {{ $conversations->total() }} Conversation(s)
        </span>
    </div>
</div>

<!-- Success Messages -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Conversations List -->
@if($conversations->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Subject</th>
                                <th>Client</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Unread</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($conversations as $conversation)
                                <tr class="{{ $conversation->unreadCount() > 0 ? 'table-active' : '' }}">
                                    <td>
                                        <strong>{{ $conversation->subject }}</strong>
                                        @if($conversation->unreadCount() > 0)
                                            <br>
                                            <small class="text-danger">
                                                <i class="fas fa-circle"></i> {{ $conversation->unreadCount() }} unread
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm" style="width: 32px; height: 32px; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">
                                                {{ strtoupper(substr($conversation->user->name, 0, 1)) }}
                                            </div>
                                            <span>{{ $conversation->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($conversation->admin)
                                            <span class="badge bg-primary">{{ $conversation->admin->name }}</span>
                                        @else
                                            <span class="badge bg-secondary">Not Assigned</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $conversation->status === 'open' ? 'success' : ($conversation->status === 'pending' ? 'warning' : 'danger') }}">
                                            <i class="fas fa-{{ $conversation->status === 'open' ? 'check-circle' : ($conversation->status === 'pending' ? 'clock' : 'ban') }}"></i>
                                            {{ ucfirst($conversation->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $conversation->priority === 'high' ? 'danger' : ($conversation->priority === 'medium' ? 'warning' : 'info') }}">
                                            <i class="fas fa-{{ $conversation->priority === 'high' ? 'fire' : ($conversation->priority === 'medium' ? 'exclamation' : 'info-circle') }}"></i>
                                            {{ ucfirst($conversation->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($conversation->unreadCount() > 0)
                                            <span class="badge bg-danger" title="Unread messages">
                                                {{ $conversation->unreadCount() }}
                                            </span>
                                        @else
                                            <span class="text-muted text-center">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $conversation->updated_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.messages.show', $conversation) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if($conversations->hasPages())
                <div class="mt-4 d-flex justify-content-center">
                    {{ $conversations->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <h5 class="mt-3 text-muted">No conversations yet</h5>
                    <p class="text-muted">Customers will see their support conversations here.</p>
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    .table-active {
        background-color: #fff3cd !important;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.35rem 0.65rem;
    }

    .avatar-sm {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
</style>

@endsection
