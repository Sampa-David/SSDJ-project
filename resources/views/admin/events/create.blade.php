@extends('layouts.admin')

@section('content')
<div class="admin-page">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-plus-circle"></i>
                Create New Event
            </h1>
            <p class="page-subtitle">Add a new event to the system</p>
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
            <form action="{{ route('admin.events.store') }}" method="POST" class="event-form">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">
                            Event Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="user_id">
                            Assign to User <span class="text-danger">*</span>
                        </label>
                        <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">Select a user...</option>
                            @forelse($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                            @empty
                            <option disabled>No users available</option>
                            @endforelse
                        </select>
                        @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">
                        Description <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="date_event">
                            Event Date <span class="text-danger">*</span>
                        </label>
                        <input type="datetime-local" class="form-control @error('date_event') is-invalid @enderror" id="date_event" name="date_event" value="{{ old('date_event') }}" required>
                        @error('date_event')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="location">
                            Location <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" required>
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
                            <option value="">Select visibility...</option>
                            <option value="public" {{ old('visibility') === 'public' ? 'selected' : '' }}>
                                <i class="fas fa-globe"></i> Public
                            </option>
                            <option value="friends" {{ old('visibility') === 'friends' ? 'selected' : '' }}>
                                <i class="fas fa-users"></i> Friends Only
                            </option>
                            <option value="private" {{ old('visibility') === 'private' ? 'selected' : '' }}>
                                <i class="fas fa-lock"></i> Private
                            </option>
                        </select>
                        @error('visibility')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="package_type">
                            Event Package <span class="text-muted">(Optional)</span>
                        </label>
                        <select class="form-control @error('package_type') is-invalid @enderror" id="package_type" name="package_type">
                            <option value="">None</option>
                            <option value="standard" {{ old('package_type') === 'standard' ? 'selected' : '' }}>Standard</option>
                            <option value="premium" {{ old('package_type') === 'premium' ? 'selected' : '' }}>Premium</option>
                            <option value="vip" {{ old('package_type') === 'vip' ? 'selected' : '' }}>VIP</option>
                        </select>
                        @error('package_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="auto_publish" name="auto_publish" value="1" checked>
                        <label class="custom-control-label" for="auto_publish">
                            Publish immediately
                        </label>
                    </div>
                    <small class="form-text text-muted">
                        Check this to make the event visible immediately (always true for admin)
                    </small>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i>
                        Create Event
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
</style>
@endsection
