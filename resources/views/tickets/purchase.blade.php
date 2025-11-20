@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <h2 class="mb-4">Purchase Tickets</h2>

            <p class="lead text-muted mb-5">
                Choose your ticket type and secure your spot at the Global Tech Summit 2026
            </p>

            <div class="row">
                @foreach ($ticketTypes as $type => $details)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm" style="border-top: 4px solid #667eea;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $details['name'] }}</h5>
                                <p class="text-muted small mb-3">{{ $details['description'] }}</p>

                                <div class="mb-4">
                                    <h3 class="text-primary">${{ $details['price'] }}</h3>
                                    <small class="text-muted">per ticket</small>
                                </div>

                                <ul class="list-unstyled mb-4 flex-grow-1">
                                    @foreach ($details['features'] as $feature)
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success"></i>
                                            <small>{{ $feature }}</small>
                                        </li>
                                    @endforeach
                                </ul>

                                <form action="{{ route('ticket.purchase') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="ticket_type" value="{{ $type }}">
                                    <div class="mb-3">
                                        <label for="quantity_{{ $type }}" class="form-label small">Quantity</label>
                                        <select name="quantity" id="quantity_{{ $type }}" class="form-select form-select-sm">
                                            @for ($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Buy Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
