@extends('layouts.app')

@section('title', 'Create Event - Eventix')

@section('content')

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Redirect to payment page with message -->
        <script>
            window.location.href = "{{ route('events.payment') }}";
        </script>
    </div>
</div>

@endsection
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_event" class="form-label">Date de l'événement</label>
                            <input type="date" class="form-control @error('date_event') is-invalid @enderror" 
                                   id="date_event" name="date_event" value="{{ old('date_event') }}" required>
                            @error('date_event')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer
                            </button>
                            <a href="{{ route('events.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
