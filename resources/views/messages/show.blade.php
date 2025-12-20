@extends('layouts.app')

@section('title', $conversation->subject . ' - Messages')

@section('content')

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Messages
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <!-- Conversation Header -->
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">{{ $conversation->subject }}</h5>
                                <small class="text-muted">
                                    Started {{ $conversation->created_at->diffForHumans() }} by {{ $conversation->user->name }}
                                </small>
                            </div>
                            <div>
                                <span class="badge bg-{{ $conversation->status === 'open' ? 'success' : ($conversation->status === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($conversation->status) }}
                                </span>
                                <span class="badge bg-{{ $conversation->priority === 'high' ? 'danger' : ($conversation->priority === 'medium' ? 'warning' : 'info') }}">
                                    {{ ucfirst($conversation->priority) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages List -->
                <div class="card shadow-sm border-0 mb-3" style="min-height: 400px; max-height: 500px; overflow-y: auto;">
                    <div class="card-body">
                        @foreach($messages as $message)
                        <div class="mb-4">
                            <div class="d-flex gap-2">
                                <div class="flex-shrink-0">
                                    <div class="avatar-circle" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                        {{ substr($message->sender->name, 0, 1) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $message->sender->name }}</h6>
                                            <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                        </div>
                                        @if($message->isUnread() && $message->sender_id !== Auth::id())
                                        <span class="badge bg-primary">New</span>
                                        @endif
                                    </div>
                                    <div class="bg-light p-3 rounded mt-2">
                                        <p class="mb-0">{{ $message->body }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Reply Form -->
                @if($conversation->status === 'open')
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Reply</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('messages.reply', $conversation) }}">
                            @csrf
                            <div class="mb-3">
                                <textarea class="form-control @error('body') is-invalid @enderror" 
                                          name="body" rows="4" placeholder="Type your reply here..."
                                          required>{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-send"></i> Send Reply
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i> This conversation is closed. You can reopen it if you need further assistance.
                </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-3">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Status</small>
                            <p class="mb-0">
                                <span class="badge bg-{{ $conversation->status === 'open' ? 'success' : ($conversation->status === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($conversation->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Priority</small>
                            <p class="mb-0">
                                <span class="badge bg-{{ $conversation->priority === 'high' ? 'danger' : ($conversation->priority === 'medium' ? 'warning' : 'info') }}">
                                    {{ ucfirst($conversation->priority) }}
                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Assigned Admin</small>
                            <p class="mb-0">
                                <strong>{{ $conversation->admin?->name ?? 'Unassigned' }}</strong>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Messages Count</small>
                            <p class="mb-0">
                                <strong>{{ $conversation->messages()->count() }}</strong>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Created</small>
                            <p class="mb-0">{{ $conversation->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Actions</h6>
                    </div>
                    <div class="card-body">
                        @if($conversation->status === 'open')
                        <form method="POST" action="{{ route('messages.close', $conversation) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100 mb-2" onclick="return confirm('Close this conversation?')">
                                <i class="fas fa-times"></i> Close
                            </button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('messages.reopen', $conversation) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-undo"></i> Reopen
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    font-size: 0.875rem;
}

/* Auto-scroll to bottom */
.card-body {
    display: flex;
    flex-direction: column;
}
</style>

@endsection
