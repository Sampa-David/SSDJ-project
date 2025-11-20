@extends('layouts.app')

@section('title', 'Speakers - Eventix')
@section('body-class', 'speakers-page')

@section('content')

<!-- Speakers Section -->
<section id="speakers" class="speakers section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Speakers</h2>
    <p>Meet our exceptional lineup of industry experts and thought leaders</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row g-4">
      <!-- Speaker cards will be displayed here -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="speaker-card">
          <div class="speaker-image">
            <img src="{{ asset('assets/img/events/speaker-8.webp') }}" alt="Speaker" class="img-fluid">
          </div>
          <div class="speaker-content">
            <h4>Sarah Chen</h4>
            <p class="speaker-title">Chief Technology Officer</p>
            <p class="speaker-company">TechFlow Solutions</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
