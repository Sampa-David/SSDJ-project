@extends('layouts.app')

@section('title', 'Edit Event - Eventix')

@section('content')

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto">
                <a href="{{ route('events.index') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Edit Form -->
                <div class="card shadow-lg border-0">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h3 class="mb-0">Edit Event: {{ $event->name }}</h3>
                    </div>
                    <div class="card-body p-4">
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <strong>Validation Errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('events.update', $event->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Event Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $event->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="5" required>{{ old('description', $event->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="date_event" class="form-label fw-bold">Event Date</label>
                                        <input type="datetime-local" class="form-control @error('date_event') is-invalid @enderror" 
                                               id="date_event" name="date_event" 
                                               value="{{ old('date_event', $event->date_event?->format('Y-m-d\TH:i')) }}" required>
                                        @error('date_event')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="location" class="form-label fw-bold">Location</label>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                               id="location" name="location" value="{{ old('location', $event->location) }}" required>
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="visibility" class="form-label fw-bold">Visibility</label>
                                        <select class="form-control @error('visibility') is-invalid @enderror" 
                                                id="visibility" name="visibility" required>
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
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="package_type" class="form-label fw-bold">Package Type</label>
                                        <select class="form-control @error('package_type') is-invalid @enderror" 
                                                id="package_type" name="package_type">
                                            <option value="">None</option>
                                            <option value="standard" {{ old('package_type', $event->package_type) === 'standard' ? 'selected' : '' }}>
                                                Standard
                                            </option>
                                            <option value="premium" {{ old('package_type', $event->package_type) === 'premium' ? 'selected' : '' }}>
                                                Premium
                                            </option>
                                            <option value="vip" {{ old('package_type', $event->package_type) === 'vip' ? 'selected' : '' }}>
                                                VIP
                                            </option>
                                        </select>
                                        @error('package_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <strong>Event Information:</strong>
                                <ul class="mb-0 mt-2">
                                    <li><strong>Created:</strong> {{ $event->created_at->format('M d, Y H:i') }}</li>
                                    <li><strong>Published:</strong> {{ $event->published_at?->format('M d, Y H:i') ?? 'Not published' }}</li>
                                    @if($event->expires_at)
                                    <li><strong>Expires:</strong> {{ $event->expires_at->format('M d, Y H:i') }}</li>
                                    @endif
                                </ul>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-save"></i> Update Event
                                </button>
                                <a href="{{ route('events.show', $event->id) }}" class="btn btn-secondary btn-lg">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

                           