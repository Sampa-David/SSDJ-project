@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body text-center p-5">
                    <div style="font-size: 4rem; margin-bottom: 20px;">✓</div>
                    <h2 class="card-title mb-3">Purchase Confirmed!</h2>
                    <p class="lead mb-4">Thank you for your purchase. Your ticket has been created successfully.</p>

                    <div class="alert alert-light text-dark mb-4">
                        <p class="mb-2"><strong>Ticket #:</strong> {{ $lastTicket->ticket_number }}</p>
                        <p class="mb-2"><strong>Type:</strong> {{ $lastTicket->type_label }}</p>
                        <p class="mb-0"><strong>Amount:</strong> {{ $lastTicket->price_display }}</p>
                    </div>

                    <p class="mb-4 small">A confirmation email has been sent to {{ Auth::user()->email }}</p>

                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('my-tickets') }}" class="btn btn-light btn-lg">View My Tickets</a>
                        <a href="{{ route('home') }}" class="btn btn-outline-light btn-lg">Back Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
