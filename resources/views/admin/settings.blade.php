@extends('layouts.admin')

@section('title', 'Settings')
@section('page-title', 'System Settings')

@section('content')
<div class="page-header mb-4">
    <div>
        <h2>System Settings</h2>
        <p class="text-muted">Manage application configuration and preferences</p>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Errors:</strong>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Settings Form -->
<form method="POST" action="{{ route('admin.settings.update') }}" class="needs-validation">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- General Settings -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-cog text-info"></i> General Settings</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="app_name" class="form-label">Application Name *</label>
                        <input type="text" class="form-control @error('app_name') is-invalid @enderror" 
                               id="app_name" name="app_name" value="{{ old('app_name', 'S²DJ Event Manager') }}" required>
                        @error('app_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="app_description" class="form-label">Application Description</label>
                        <textarea class="form-control @error('app_description') is-invalid @enderror" 
                                  id="app_description" name="app_description" rows="3">{{ old('app_description', 'Event management and ticketing platform') }}</textarea>
                        @error('app_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Settings -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-envelope text-primary"></i> Contact Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Contact Email *</label>
                        <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                               id="contact_email" name="contact_email" value="{{ old('contact_email', 'contact@ssdj.com') }}" required>
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="support_phone" class="form-label">Support Phone</label>
                        <input type="text" class="form-control @error('support_phone') is-invalid @enderror" 
                               id="support_phone" name="support_phone" value="{{ old('support_phone', '+1 (555) 123-4567') }}" placeholder="+1 (555) 123-4567">
                        @error('support_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Business Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="2">{{ old('address', '123 Event Street, City, Country') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="working_hours" class="form-label">Working Hours</label>
                        <input type="text" class="form-control @error('working_hours') is-invalid @enderror" 
                               id="working_hours" name="working_hours" value="{{ old('working_hours', 'Mon - Fri: 9:00 AM - 6:00 PM') }}" placeholder="e.g., Mon - Fri: 9:00 AM - 6:00 PM">
                        @error('working_hours')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- System Limits -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-sliders-h text-warning"></i> System Limits</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="max_users" class="form-label">Max Users (0 = Unlimited)</label>
                            <input type="number" class="form-control @error('max_users') is-invalid @enderror" 
                                   id="max_users" name="max_users" value="{{ old('max_users', 0) }}" min="0">
                            @error('max_users')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="max_events" class="form-label">Max Events (0 = Unlimited)</label>
                            <input type="number" class="form-control @error('max_events') is-invalid @enderror" 
                                   id="max_events" name="max_events" value="{{ old('max_events', 0) }}" min="0">
                            @error('max_events')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="ticket_validity_days" class="form-label">Ticket Validity (Days)</label>
                        <input type="number" class="form-control @error('ticket_validity_days') is-invalid @enderror" 
                               id="ticket_validity_days" name="ticket_validity_days" value="{{ old('ticket_validity_days', 365) }}" min="1" max="365">
                        @error('ticket_validity_days')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-toggle-on text-success"></i> Features</h5>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="enable_registration" name="enable_registration" value="1" @checked(old('enable_registration', true))>
                        <label class="form-check-label" for="enable_registration">
                            <strong>Enable User Registration</strong>
                            <div class="text-muted small">Allow new users to create accounts</div>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="enable_tickets" name="enable_tickets" value="1" @checked(old('enable_tickets', true))>
                        <label class="form-check-label" for="enable_tickets">
                            <strong>Enable Ticket Booking</strong>
                            <div class="text-muted small">Allow users to purchase and use tickets</div>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="enable_events" name="enable_events" value="1" @checked(old('enable_events', true))>
                        <label class="form-check-label" for="enable_events">
                            <strong>Enable Event Management</strong>
                            <div class="text-muted small">Allow creation and management of events</div>
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="allow_guest_booking" name="allow_guest_booking" value="1" @checked(old('allow_guest_booking', false))>
                        <label class="form-check-label" for="allow_guest_booking">
                            <strong>Allow Guest Booking</strong>
                            <div class="text-muted small">Allow non-registered users to book tickets</div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <!-- Save Button -->
            <div class="card mb-4 sticky-top" style="top: 20px;">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
            </div>

            <!-- Maintenance -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-tools text-danger"></i> Maintenance</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form method="POST" action="{{ route('admin.settings.clear-cache') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm w-100" 
                                    onclick="return confirm('Clear cache? This may temporarily slow the app.')">
                                <i class="fas fa-broom me-1"></i> Clear Cache
                            </button>
                        </form>
                    </div>
                    <p class="text-muted small mt-2 mb-0">Clear application cache and reset routes</p>
                </div>
            </div>

            <!-- System Status -->
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-heartbeat text-success"></i> System Status</h5>
                </div>
                <div class="card-body small">
                    <div class="mb-2">
                        <strong>PHP Version:</strong><br>
                        <code>{{ phpversion() }}</code>
                    </div>
                    <div class="mb-2">
                        <strong>Laravel Version:</strong><br>
                        <code>{{ app()->version() }}</code>
                    </div>
                    <div class="mb-2">
                        <strong>Database:</strong><br>
                        <code>{{ config('database.default') }}</code>
                    </div>
                    <div>
                        <strong>Environment:</strong><br>
                        <span class="badge 
                            @if(app()->environment('production')) bg-danger
                            @elseif(app()->environment('staging')) bg-warning
                            @else bg-info @endif">
                            {{ strtoupper(app()->environment()) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Maintenance Mode Section -->
    <div class="card mt-4">
        <div class="card-header bg-light bg-danger-light">
            <h5 class="mb-0 text-danger"><i class="fas fa-exclamation-circle me-2"></i> Maintenance Mode</h5>
        </div>
        <div class="card-body">
            <div class="alert alert-warning mb-3">
                <strong>Note:</strong> When maintenance mode is enabled, only admins can access the application.
                All other users will see a maintenance page.
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1">
                <label class="form-check-label" for="maintenance_mode">
                    <strong>Enable Maintenance Mode</strong>
                </label>
            </div>
        </div>
    </div>
</form>

<!-- Reset Settings -->
<div class="card mt-4">
    <div class="card-header bg-light bg-info-light">
        <h5 class="mb-0 text-info"><i class="fas fa-redo"></i> Reset Settings</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info mb-3">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Caution:</strong> This will reset all settings to their default values. This action cannot be undone.
        </div>
        <form method="POST" action="{{ route('admin.settings.reset') }}">
            @csrf
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="confirm" name="confirm" value="1" required>
                <label class="form-check-label" for="confirm">
                    I understand this action cannot be undone
                </label>
            </div>
            <button type="submit" class="btn btn-info" onclick="return confirm('Reset all settings to defaults? This cannot be undone!')">
                <i class="fas fa-redo me-1"></i> Reset to Defaults
            </button>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
.bg-danger-light {
    background-color: rgba(220, 53, 69, 0.1);
}

.bg-info-light {
    background-color: rgba(23, 162, 184, 0.1);
}

.sticky-top {
    z-index: 100;
}
</style>
@endpush
