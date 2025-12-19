@extends('layouts.admin')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-edit"></i>
                Edit Event
            </h1>
            <p class="page-subtitle">{{ $event->name }}</p>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        <strong>Validation Errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Event Details</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.events.update', $event) }}" method="POST" class="event-form">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">
                            Event Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $event->name) }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="user_id">
                            Organizer
                        </label>
                        <input type="text" class="form-control" value="{{ $event->user->name }} ({{ $event->user->email }})" disabled>
                        <small class="form-text text-muted">Cannot change event organizer</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">
                        Description <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $event->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="date_event">
                            Event Date <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control @error('date_event') is-invalid @enderror" id="date_event" name="date_event" value="{{ old('date_event', $event->date_event ? $event->date_event->format('Y-m-d\TH:i') : '') }}" required>
                        @error('date_event')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="location">
                            Location <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $event->location) }}" required>
                        @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="visibility">
                            Visibility <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('visibility') is-invalid @enderror" id="visibility" name="visibility" required>
                            <option value="public" {{ old('visibility', $event->visibility) === 'public' ? 'selected' : '' }}>
                                Public
                            </option>
                            <option value="friends" {{ old('visibility', $event->visibility) === 'friends' ? 'selected' : '' }}>
                                Friends Only
                            </option>
                            <option value="private" {{ old('visibility', $event->visibility) === 'private' ? 'selected' : '' }}>
                                Private
                            </option>
                        </select>
                        @error('visibility')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="status">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="published" {{ old('status', $event->status) === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="expired" {{ old('status', $event->status) === 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="package_type">
                        Event Package <span class="text-muted">(Optional)</span>
                    </label>
                    <select class="form-control @error('package_type') is-invalid @enderror" id="package_type" name="package_type">
                        <option value="">None</option>
                        <option value="standard" {{ old('package_type', $event->package_type) === 'standard' ? 'selected' : '' }}>Standard</option>
                        <option value="premium" {{ old('package_type', $event->package_type) === 'premium' ? 'selected' : '' }}>Premium</option>
                        <option value="vip" {{ old('package_type', $event->package_type) === 'vip' ? 'selected' : '' }}>VIP</option>
                    </select>
                    @error('package_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="alert alert-info">
                    <strong>Event Information:</strong>
                    <ul class="mb-0 mt-2">
                        <li><strong>Created:</strong> {{ $event->created_at->format('M d, Y H:i') }}</li>
                        <li><strong>Published:</strong> {{ $event->published_at ? $event->published_at->format('M d, Y H:i') : 'Not published' }}</li>
                        @if($event->expires_at)
                        <li><strong>Expires:</strong> {{ $event->expires_at->format('M d, Y H:i') }}</li>
                        @endif
                    </ul>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i>
                        Update Event
                    </button>
                    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-arrow-left"></i>
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.event-form {
    max-width: 100%;
}

.event-form .form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
}

.event-form .text-danger {
    color: #dc3545;
}

.event-form .text-muted {
    color: #6c757d;
}

.alert-info {
    border-left: 4px solid #17a2b8;
}
</style>
@endsection
