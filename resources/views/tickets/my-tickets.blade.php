@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2>My Tickets</h2>
            <a href="{{ route('buy-tickets') }}" class="btn btn-primary btn-lg">Buy More Tickets</a>
        </div>

        @if ($tickets->count() > 0)
            <div class="row">
                @foreach ($tickets as $ticket)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm" style="border-top: 4px solid #667eea;">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">{{ $ticket->type_label }}</h6>
                                    <span class="badge" style="background-color: {{ $ticket->status === 'active' ? '#28a745' : '#dc3545' }};">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="mb-2"><strong>Ticket #:</strong> <code>{{ $ticket->ticket_number }}</code></p>
                                <p class="mb-2"><strong>Price:</strong> {{ $ticket->price_display }}</p>
                                <p class="mb-2"><strong>Purchased:</strong> {{ $ticket->purchased_at->format('M d, Y') }}</p>
                                <p class="mb-3"><strong>Valid Until:</strong> {{ $ticket->valid_until?->format('M d, Y') ?? 'N/A' }}</p>

                                @if ($ticket->isValid())
                                    <div class="alert alert-success py-2 text-center small">
                                        ✓ Valid & Active
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer bg-light">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('ticket.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary flex-grow-1">Details</a>
                                    @if ($ticket->status === 'active')
                                        <form action="{{ route('ticket.cancel', $ticket->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Cancel this ticket?')">Cancel</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div style="font-size: 4rem; margin-bottom: 20px;">📭</div>
                    <h4 class="card-title">No Tickets Yet</h4>
                    <p class="card-text text-muted mb-4">You haven't purchased any tickets for the Global Tech Summit 2026.</p>
                    <a href="{{ route('buy-tickets') }}" class="btn btn-primary btn-lg">Get Your Tickets Now</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
