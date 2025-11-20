@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <a href="{{ route('my-tickets') }}" class="btn btn-outline-secondary mb-4">← Back to My Tickets</a>

            <div class="card shadow-lg border-0">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <h4 class="mb-0">Ticket Details</h4>
                </div>
                <div class="card-body p-5">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong>Ticket Number:</strong><br>
                                <span class="h5">{{ $ticket->ticket_number }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong>Status:</strong><br>
                                <span class="badge" style="background-color: {{ $ticket->status === 'active' ? '#28a745' : '#dc3545' }}; font-size: 0.9rem; padding: 0.5rem 0.75rem;">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p><strong>Ticket Type:</strong> {{ $ticket->type_label }}</p>
                            <p><strong>Price:</strong> {{ $ticket->price_display }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Purchased:</strong> {{ $ticket->purchased_at->format('M d, Y H:i') }}</p>
                            <p><strong>Valid Until:</strong> {{ $ticket->valid_until?->format('M d, Y') ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <hr>

                    @if ($ticket->qr_code)
                        <div class="mb-4">
                            <p><strong>QR Code:</strong></p>
                            <div style="background: white; padding: 10px; display: inline-block; border: 1px solid #ddd;">
                                <img src="data:image/png;base64,{{ $ticket->qr_code }}" alt="QR Code" style="max-width: 200px;">
                            </div>
                        </div>
                    @endif

                    @if ($ticket->notes)
                        <div class="mb-4">
                            <p><strong>Notes:</strong></p>
                            <p>{{ $ticket->notes }}</p>
                        </div>
                    @endif

                    <hr>

                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                        @if ($ticket->status === 'active')
                            <form action="{{ route('ticket.cancel', $ticket->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to cancel this ticket?')">
                                    <i class="bi bi-x-circle"></i> Cancel Ticket
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
