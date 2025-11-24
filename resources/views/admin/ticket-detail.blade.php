@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.tickets') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Ticket Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Ticket Number:</strong></td>
                            <td><code>{{ $ticket->ticket_number }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Type:</strong></td>
                            <td><span class="badge bg-light text-dark">{{ $ticket->type_label }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Price:</strong></td>
                            <td>{{ $ticket->price_display }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge @if($ticket->status === 'active') bg-success @elseif($ticket->status === 'used') bg-info @elseif($ticket->status === 'expired') bg-warning @else bg-danger @endif">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Purchased:</strong></td>
                            <td>{{ $ticket->purchased_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Valid From:</strong></td>
                            <td>{{ $ticket->valid_from ? $ticket->valid_from->format('M d, Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Valid Until:</strong></td>
                            <td>{{ $ticket->valid_until ? $ticket->valid_until->format('M d, Y') : '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">Buyer Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $ticket->user->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td><a href="mailto:{{ $ticket->user->email }}">{{ $ticket->user->email }}</a></td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $ticket->user->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Company:</strong></td>
                            <td>{{ $ticket->user->company ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Member Since:</strong></td>
                            <td>{{ $ticket->user->created_at->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>View Profile:</strong></td>
                            <td>
                                <a href="{{ route('admin.user', $ticket->user) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-user"></i> View
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($ticket->qr_code)
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">QR Code</h6>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $ticket->qr_code }}" alt="QR Code" style="max-width: 200px;">
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
