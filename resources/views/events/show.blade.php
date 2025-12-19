@extends('layouts.app')

@section('title', $event->name . ' - Eventix')

@section('content')

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Event Content -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="mb-2">{{ $event->name }}</h3>
                                <small>
                                    <i class="fas fa-calendar"></i> {{ $event->date_event->format('F d, Y') }} | 
                                    <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                </small>
                            </div>
                            <div>
                                @if($event->status === 'published')
                                    <span class="badge bg-success" style="font-size: 0.9rem;">Published</span>
                                @elseif($event->status === 'expired')
                                    <span class="badge bg-danger" style="font-size: 0.9rem;">Expired</span>
                                @else
                                    <span class="badge bg-warning" style="font-size: 0.9rem;">{{ ucfirst($event->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="mb-3">Description</h5>
                            <p class="card-text">{{ $event->description }}</p>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Visibility</h6>
                                <p>
                                    @if($event->visibility === 'public')
                                        <i class="fas fa-globe"></i> Public
                                    @elseif($event->visibility === 'friends')
                                        <i class="fas fa-users"></i> Friends Only
                                    @else
                                        <i class="fas fa-lock"></i> Private
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Promotion Expires</h6>
                                <p>{{ $event->expires_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if(Auth::user()->id === $event->user_id && $event->status === 'published')
                    <div class="row gap-2">
                        <div class="col-md-6">
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning w-100">
                                <i class="fas fa-edit"></i> Edit Event
                            </a>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete Event
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Sidebar Info -->
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Package Type</small>
                            <p class="mb-0">
                                <strong>{{ ucfirst($event->package_type ?? 'N/A') }}</strong>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Price Paid</small>
                            <p class="mb-0">
                                <strong>${{ number_format($event->price ?? 0, 2) }}</strong>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Payment ID</small>
                            <p class="mb-0">
                                <code>{{ $event->payment_id ?? 'N/A' }}</code>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Status</small>
                            <p class="mb-0">
                                @if($event->status === 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($event->status === 'expired')
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    <span class="badge bg-warning">{{ ucfirst($event->status) }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Created At</small>
                            <p class="mb-0">{{ $event->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Expires At</small>
                            <p class="mb-0">{{ $event->expires_at?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Related Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('events.payment') }}" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-plus"></i> New Event
                        </a>
                        <a href="{{ route('events.index') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-list"></i> All Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
                            {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                        </p>
                    </div>

                    @if($event->users && $event->users->count() > 0)
                        <div class="mb-4">
                            <h5 class="text-muted">Participants</h5>
                            <div class="list-group">
                                @foreach($event->users as $user)
                                    <div class="list-group-item">
                                        <i class="fas fa-user"></i> {{ $user->name }} ({{ $user->email }})
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement?')">
                            <i class="fas fa-trash"></i> Supprimer l'événement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
