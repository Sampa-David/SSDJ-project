@extends('layouts.app')

@section('title', 'Schedule - Eventix')
@section('body-class', 'schedule-page')

@section('content')

<!-- Schedule Section -->
<section id="schedule" class="schedule section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Schedule</h2>
    <p>Explore our complete event schedule and find sessions that interest you.</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="schedule-header">
      <ul class="nav nav-tabs" id="schedule-tabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="schedule-tab-1" data-bs-toggle="tab" data-bs-target="#schedule-tab-pane-1" type="button" role="tab">Oct 15<br>Monday</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="schedule-tab-2" data-bs-toggle="tab" data-bs-target="#schedule-tab-pane-2" type="button" role="tab">Oct 16<br>Tuesday</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="schedule-tab-3" data-bs-toggle="tab" data-bs-target="#schedule-tab-pane-3" type="button" role="tab">Oct 17<br>Wednesday</button>
        </li>
      </ul>
    </div>

    <div class="tab-content" id="schedule-tabContent">
      <div class="tab-pane fade show active" id="schedule-tab-pane-1" role="tabpanel" aria-labelledby="schedule-tab-1" tabindex="0">
        <div class="schedule-content">
          <div class="session-timeline">
            <!-- Sessions will be displayed here -->
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="schedule-tab-pane-2" role="tabpanel" aria-labelledby="schedule-tab-2" tabindex="0">
        <div class="schedule-content">
          <div class="session-timeline">
            <!-- Sessions will be displayed here -->
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="schedule-tab-pane-3" role="tabpanel" aria-labelledby="schedule-tab-3" tabindex="0">
        <div class="schedule-content">
          <div class="session-timeline">
            <!-- Sessions will be displayed here -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="schedule-actions">
    <button class="btn btn-primary">
      <i class="bi bi-download"></i>
      Download Full Agenda
    </button>
    <button class="btn btn-outline">
      <i class="bi bi-calendar-event"></i>
      Export to Calendar
    </button>
  </div>
</section>

@endsection
