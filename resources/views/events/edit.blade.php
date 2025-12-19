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
                        <h3 class="mb-0">Edit Event</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('events.update', $event->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Event Name</label>
                                <input 
                                    type="text" 
                                    class="form-control @error('name') is-invalid @enderror" 
                                    id="name" 
                                    name="name" 
                                    placeholder="Enter event name"
                                    value="{{ old('name', $event->name) }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea 
                                    class="form-control @error('description') is-invalid @enderror" 
                                    id="description" 
                                    name="description" 
                                    rows="4"
                                    placeholder="Describe your event in detail..."
                                    required>{{ old('description', $event->description) }}</textarea>
                                <small class="text-muted">Minimum 10 characters required</small>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_event" class="form-label fw-bold">Event Date</label>
                                    <input 
                                        type="date" 
                                        class="form-control @error('date_event') is-invalid @enderror" 
                                        id="date_event" 
                                        name="date_event" 
                                        value="{{ old('date_event', $event->date_event->format('Y-m-d')) }}"
                                        required>
                                    @error('date_event')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="location" class="form-label fw-bold">Location</label>
                                    <input 
                                        type="text" 
                                        class="form-control @error('location') is-invalid @enderror" 
                                        id="location" 
                                        name="location" 
                                        placeholder="Event location"
                                        value="{{ old('location', $event->location) }}"
                                        required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="visibility" class="form-label fw-bold">Visibility</label>
                                <select class="form-control @error('visibility') is-invalid @enderror" id="visibility" name="visibility" required>
                                    <option value="">-- Select Visibility --</option>
                                    <option value="public" {{ old('visibility', $event->visibility) === 'public' ? 'selected' : '' }}>Public (Everyone can see)</option>
                                    <option value="private" {{ old('visibility', $event->visibility) === 'private' ? 'selected' : '' }}>Private (Only you)</option>
                                    <option value="friends" {{ old('visibility', $event->visibility) === 'friends' ? 'selected' : '' }}>Friends Only</option>
                                </select>
                                @error('visibility')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <a href="{{ route('events.index') }}" class="btn btn-outline-secondary w-100">Cancel</a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Event Info -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Current Event Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <small class="text-muted">Package</small>
                                <p><strong>{{ ucfirst($event->package_type ?? 'N/A') }}</strong></p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Price Paid</small>
                                <p><strong>${{ number_format($event->price ?? 0, 2) }}</strong></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <small class="text-muted">Published</small>
                                <p>{{ $event->published_at?->format('M d, Y H:i') ?? 'Not published' }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Expires</small>
                                <p>{{ $event->expires_at?->format('M d, Y') ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
