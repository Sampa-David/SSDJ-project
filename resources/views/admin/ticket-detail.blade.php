@extends('layouts.admin')

@section('title', 'Ticket Details')
@section('page-title', 'Ticket Details: ' . $ticket->ticket_number)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.tickets') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Tickets
    </a>
</div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-ticket-alt"></i> Ticket Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Ticket Number:</strong></td>
                            <td><code class="bg-light p-2 rounded">{{ $ticket->ticket_number }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>Type:</strong></td>
                            <td><span class="badge bg-light text-dark">{{ $ticket->type_label }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Price:</strong></td>
                            <td class="fw-bold">${{ $ticket->price_display }}</td>
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
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-user"></i> Buyer Information</h6>
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
                                    <i class="fas fa-user"></i> View Profile
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
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-qrcode"></i> QR Code</h6>
                </div>
                <div class="card-body text-center py-4">
                    <img src="{{ $ticket->qr_code }}" alt="QR Code" style="max-width: 200px; border-radius: 8px;">
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
