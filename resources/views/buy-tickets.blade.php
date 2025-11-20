@extends('layouts.app')

@section('title', 'Buy Tickets - Eventix')

@section('content')

<section class="tickets section" style="min-height: 100vh; display: flex; align-items: center;">
  <div class="container">
    <div class="section-title text-center mb-5">
      <h2>Get Your Tickets</h2>
      <p>Choose the perfect package for your event experience</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="ticket-card">
          <div class="ticket-header">
            <h4>Early Bird</h4>
            <div class="price-section">
              <span class="currency">$</span>
              <span class="amount">75</span>
            </div>
          </div>
          <div class="ticket-body">
            <a href="#" class="btn btn-primary w-100">Purchase Now</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="ticket-card">
          <div class="ticket-header">
            <h4>Regular</h4>
            <div class="price-section">
              <span class="currency">$</span>
              <span class="amount">125</span>
            </div>
          </div>
          <div class="ticket-body">
            <a href="#" class="btn btn-primary w-100">Purchase Now</a>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-md-6 mb-4">
        <div class="ticket-card">
          <div class="ticket-header">
            <h4>Premium</h4>
            <div class="price-section">
              <span class="currency">$</span>
              <span class="amount">195</span>
            </div>
          </div>
          <div class="ticket-body">
            <a href="#" class="btn btn-primary w-100">Purchase Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
