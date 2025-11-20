@extends('layouts.app')

@section('title', 'Venue - Eventix')

@section('content')

<section class="venue section" style="min-height: 100vh; display: flex; align-items: center;">
  <div class="container">
    <div class="section-title text-center mb-5">
      <h2>Event Venue</h2>
      <p>San Francisco Convention Center</p>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <h3>Location Details</h3>
        <p>A108 Adam Street, New York, NY 535022</p>
        <p><strong>Phone:</strong> +1 5589 55488 55</p>
        <p><strong>Email:</strong> info@example.com</p>
      </div>
      <div class="col-lg-6">
        <div style="width: 100%; height: 400px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
          <p>Map placeholder</p>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
