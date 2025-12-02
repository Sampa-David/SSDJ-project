@extends('layouts.app')

@section('title', 'Home - Eventix')
@section('body_class', 'index-page')

@section('content')

<!-- Hero Section -->
<section id="hero" class="hero section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center">
      <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
        <h1 class="hero-title">Global Tech Summit 2026</h1>
        <p class="hero-subtitle">Shaping the Future of Innovation</p>
        <p class="hero-description">Join industry leaders, innovators, and visionaries for three days of groundbreaking discussions, networking opportunities, and transformative insights.</p>

        <div class="event-details mb-4">
          <div class="detail-item" data-aos="fade-up" data-aos-delay="300">
            
            <span></span>
          </div>
          <div class="detail-item" data-aos="fade-up" data-aos-delay="350">
            
            <span></span>
          </div>
          <div class="detail-item" data-aos="fade-up" data-aos-delay="400">
           
            <span></span>
          </div>
        </div>

        <div class="hero-actions" data-aos="fade-up" data-aos-delay="450">
          <a href="{{ route('buy-tickets') }}" class="btn btn-primary btn-lg me-3">Register Now</a>
          <a href="{{ route('schedule') }}" class="btn btn-outline-primary btn-lg">View Schedule</a>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="hero-image-wrapper">
          <img src="{{ asset('assets/img/events/gallery-7.webp') }}" alt="Global Tech Summit" class="img-fluid hero-image">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- About Section -->
<section id="about" class="about section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="content">
          <h2 data-aos="fade-up" data-aos-delay="200">Shaping the Future of Digital Innovation</h2>
         <center> <p data-aos="fade-up" data-aos-delay="300">🎉🎉🎉🎊🥳</p></center>

          <div class="stats-grid" data-aos="fade-up" data-aos-delay="500">
            <div class="stat-item">
              <div class="stat-number">3</div>
              <div class="stat-label">Days</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">8</div>
              <div class="stat-label">Tracks</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">120+</div>
              <div class="stat-label">Speakers</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">2500+</div>
              <div class="stat-label">Attendees</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="image-wrapper" data-aos="zoom-in" data-aos-delay="300">
          <img src="{{ asset('assets/img/events/showcase-8.webp') }}" alt="Event showcase" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
