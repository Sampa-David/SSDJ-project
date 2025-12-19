@extends('layouts.admin')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-calendar"></i>
                Events Management
            </h1>
            <p class="page-subtitle">Manage all events in your system</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Create Event
        </a>
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

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Events</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Organizer</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Visibility</th>
                        <th>Status</th>
                        <th>Expires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>
                            <strong>{{ $event->name }}</strong>
                        </td>
                        <td>
                            {{ $event->user->name ?? 'Unknown' }}
                        </td>
                        <td>
                            {{ $event->date_event ? $event->date_event->format('M d, Y') : 'N/A' }}
                        </td>
                        <td>
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $event->location ?? 'N/A' }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $event->visibility === 'public' ? 'success' : ($event->visibility === 'friends' ? 'info' : 'secondary') }}">
                                <i class="fas fa-{{ $event->visibility === 'public' ? 'globe' : ($event->visibility === 'friends' ? 'users' : 'lock') }}"></i>
                                {{ ucfirst($event->visibility) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $event->status === 'published' ? 'success' : 'warning' }}">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td>
                            @if($event->expires_at)
                                {{ $event->expires_at->format('M d, Y') }}
                            @else
                                <span class="text-muted">Never</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this event?');">
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
                            <p class="text-muted mb-0">No events found. <a href="{{ route('admin.events.create') }}">Create one now</a></p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($events->hasPages())
        <div class="card-footer">
            {{ $events->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</div>

<style>
.action-buttons {
    display: flex;
    gap: 5px;
}

.action-buttons form {
    display: inline;
}
</style>
@endsection
