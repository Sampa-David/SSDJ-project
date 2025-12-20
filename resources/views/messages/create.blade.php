@extends('layouts.app')

@section('title', 'Create Message - Eventix')

@section('content')

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8 mx-auto">
                <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left"></i> Back to Messages
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-lg border-0">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <h3 class="mb-0">
                            <i class="fas fa-pen-square"></i> Start New Conversation
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

                        <form method="POST" action="{{ route('messages.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="subject" class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                       id="subject" name="subject" placeholder="What is your message about?" 
                                       value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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

                            <div class="mb-3">
                                <label for="message" class="form-label fw-bold">Message <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" name="message" rows="6" 
                                          placeholder="Describe your issue or question in detail..."
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimum 10 characters required</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-send"></i> Send Message
                                </button>
                                <a href="{{ route('messages.index') }}" class="btn btn-secondary btn-lg">
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
