@extends('layouts.app')

@section('title', 'Contact - Eventix')

@section('content')

<section class="contact section" style="min-height: 100vh; display: flex; align-items: center;">
  <div class="container">
    <div class="section-title text-center mb-5">
      <h2>Contact Us</h2>
      <p>Get in touch with our team</p>
    </div>

    <div class="row">
      <div class="col-lg-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-geo-alt"></i> Address
            </h5>
            <p class="card-text">A108 Adam Street<br>New York, NY 535022</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-telephone"></i> Phone
            </h5>
            <p class="card-text">+1 5589 55488 55</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">
              <i class="bi bi-envelope"></i> Email
            </h5>
            <p class="card-text">info@example.com</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-8 mx-auto">
        <form>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

@endsection
