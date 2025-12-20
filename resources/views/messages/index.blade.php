@extends('layouts.app')

@section('title', 'Messages - Eventix')

@section('content')

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2>
                        <i class="fas fa-envelope"></i> My Conversations
                    </h2>
                    <a href="{{ route('messages.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> New Message
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($conversations->count() > 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">{{ $conversations->total() }} Conversation(s)</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($conversations as $conversation)
                        <a href="{{ route('messages.show', $conversation) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        {{ $conversation->subject }}
                                        @if($conversation->unreadCount() > 0)
                                        <span class="badge bg-primary">{{ $conversation->unreadCount() }}</span>
                                        @endif
                                    </h6>
                                    <p class="mb-1 text-muted small">
                                        {{ Str::limit($conversation->lastMessage()?->body ?? 'No messages', 100) }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $conversation->admin?->name ?? 'Unassigned' }} •
                                        <i class="fas fa-clock"></i> {{ $conversation->updated_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $conversation->status === 'open' ? 'success' : ($conversation->status === 'pending' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($conversation->status) }}
                                    </span>
                                    <span class="badge bg-{{ $conversation->priority === 'high' ? 'danger' : ($conversation->priority === 'medium' ? 'warning' : 'info') }}">
                                        {{ ucfirst($conversation->priority) }}
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                @if($conversations->hasPages())
                <div class="mt-4">
                    {{ $conversations->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card text-center shadow-sm border-0 py-5">
                    <div class="card-body">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                        <h5 class="mt-3 text-muted">No conversations yet</h5>
                        <p class="text-muted">Start a new conversation to get in touch with our support team.</p>
                        <a href="{{ route('messages.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Conversation
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
