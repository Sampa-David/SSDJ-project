@extends('layouts.admin')

@section('title', 'Data Generator - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-database-fill me-2"></i>Data Generator
                    </h3>
                </div>
                <div class="card-body p-5">
                    <p class="text-muted mb-4">
                        Generate sample users and events for testing purposes. Each event will be assigned to a randomly selected user as the creator.
                    </p>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5 class="alert-heading">Validation Error</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.data-generator.generate') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="users_count" class="form-label fw-600">
                                        <i class="bi bi-people me-2"></i>Number of Users to Generate
                                    </label>
                                    <input 
                                        type="number" 
                                        id="users_count" 
                                        name="users_count" 
                                        class="form-control form-control-lg @error('users_count') is-invalid @enderror"
                                        value="{{ old('users_count', 10) }}"
                                        min="1"
                                        max="1000"
                                        required
                                    >
                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Enter a number between 1 and 1000
                                    </small>
                                    @error('users_count')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label for="events_count" class="form-label fw-600">
                                        <i class="bi bi-calendar-event me-2"></i>Number of Events to Generate
                                    </label>
                                    <input 
                                        type="number" 
                                        id="events_count" 
                                        name="events_count" 
                                        class="form-control form-control-lg @error('events_count') is-invalid @enderror"
                                        value="{{ old('events_count', 20) }}"
                                        min="1"
                                        max="1000"
                                        required
                                    >
                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Enter a number between 1 and 1000
                                    </small>
                                    @error('events_count')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mb-4" role="alert">
                            <h6 class="alert-heading mb-2">
                                <i class="bi bi-exclamation-triangle me-2"></i>Important Notice
                            </h6>
                            <ul class="mb-0">
                                <li>This will create random users and events</li>
                                <li>Each event will be assigned to a random user as the creator</li>
                                <li>Data is generated with random names, descriptions, dates, and locations</li>
                                <li>All events will be marked as published</li>
                                <li>This feature is safe to use in production but use responsibly</li>
                            </ul>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="bi bi-play-fill me-2"></i>Generate Data
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>How It Works
                    </h5>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <li><strong>Enter the number of users</strong> you want to generate (1-1000)</li>
                        <li><strong>Enter the number of events</strong> you want to generate (1-1000)</li>
                        <li><strong>Click "Generate Data"</strong> button</li>
                        <li>The system will create users and events <strong>instantly</strong></li>
                        <li>Each event will be randomly assigned to one of the created users</li>
                        <li>You can view them in the <strong>Users</strong> and <strong>Events</strong> sections</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-600 {
        font-weight: 600;
    }
</style>
@endsection
