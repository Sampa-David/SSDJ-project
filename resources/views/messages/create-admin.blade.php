@extends('layouts.admin')

@section('title', 'Create Message - Admin')
@section('page-title', 'Start New Conversation')

@section('content')

<div class="row">
    <div class="col-lg-8 mx-auto">
        <a href="{{ route('admin.messages.admin-conversations') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Conversations
        </a>

        <div class="card shadow-lg border-0">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h3 class="mb-0">
                    <i class="fas fa-pen-square"></i> Start New Conversation with Client
                </h3>
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
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.messages.store') }}">
                    @csrf

                    <!-- Select Client -->
                    <div class="mb-3">
                        <label for="client_id" class="form-label fw-bold">Client <span class="text-danger">*</span></label>
                        <select class="form-control @error('client_id') is-invalid @enderror" 
                                id="client_id" name="client_id" required>
                            <option value="">Select a client...</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }} ({{ $client->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div class="mb-3">
                        <label for="subject" class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                               id="subject" name="subject" placeholder="What is this conversation about?" 
                               value="{{ old('subject') }}" required>
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div class="mb-3">
                        <label for="priority" class="form-label fw-bold">Priority (Optional)</label>
                        <select class="form-control @error('priority') is-invalid @enderror" id="priority" name="priority">
                            <option value="">Select priority...</option>
                            <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>
                                <i class="fas fa-arrow-down"></i> Low
                            </option>
                            <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>
                                <i class="fas fa-arrow-right"></i> Medium (Default)
                            </option>
                            <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>
                                <i class="fas fa-arrow-up"></i> High
                            </option>
                        </select>
                        @error('priority')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div class="mb-3">
                        <label for="message" class="form-label fw-bold">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message" name="message" rows="6" 
                                  placeholder="Write your message to the client..."
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Minimum 10 characters required</small>
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-send"></i> Send Message
                        </button>
                        <a href="{{ route('admin.messages.admin-conversations') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
</style>

@endsection
