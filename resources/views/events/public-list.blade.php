@extends('layouts.app')

@section('title', 'Events - Eventix')

@section('content')

<div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Events</h1>
        <nav class="breadcrumbs">
            <ol>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="current">Events</li>
            </ol>
        </nav>
    </div>
</div><!-- End Page Title -->

<section id="events" class="events section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="section-title text-center mb-5">
            <h2>Upcoming Events</h2>
            <p>Discover and join amazing events happening on our platform</p>
        </div>

        @if($events->count() > 0)
            <div class="row gy-4">
                @foreach($events as $event)
                    <div class="col-lg-4 col-md-6">
                        <div class="event-item h-100" style="border: 1px solid #e0e0e0; border-radius: 10px; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1">{{ $event->name }}</h5>
                                        <small>
                                            <i class="bi bi-calendar3"></i>
                                            {{ $event->date_event->format('l, F d, Y') }}
                                        </small>
                                    </div>
                                    <span class="badge bg-success">Published</span>
                                </div>
                            </div>
                            
                            <div style="padding: 20px;">
                                <p class="text-muted mb-3" style="min-height: 60px;">
                                    {{ Str::limit($event->description, 100) }}
                                </p>

                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt"></i>
                                        <strong>Location:</strong> {{ $event->location }}
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="bi bi-person"></i>
                                        <strong>Organizer:</strong> {{ $event->user->name ?? 'Unknown' }}
                                    </small>
                                </div>

                                @if($event->package_type)
                                    <div class="mb-3 pb-3" style="border-bottom: 1px solid #e0e0e0;">
                                        <small class="text-muted">
                                            <i class="bi bi-package"></i>
                                            <strong>Package:</strong> {{ ucfirst($event->package_type) }}
                                        </small>
                                    </div>
                                @endif

                                <div class="d-grid gap-2">
                                    <a href="{{ route('events.public.show', $event->id) }}" class="btn btn-primary">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $events->links() }}
            </div>
        @else
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <div style="font-size: 3rem; margin-bottom: 20px;">📭</div>
                    <h5 class="card-title">No Public Events Yet</h5>
                    <p class="card-text text-muted mb-4">There are currently no public events. Check back soon!</p>
                </div>
            </div>
        @endif
    </div>
</section>

<style>
    .event-item:hover {
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2) !important;
        transform: translateY(-5px);
    }

    .page-title {
        --color-primary: #667eea;
        --color-primary-rgb: 102, 126, 234;
        padding: 60px 0 30px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }

    .page-title h1 {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .breadcrumbs {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 14px;
    }

    .breadcrumbs ol {
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .breadcrumbs ol li {
        display: flex;
        align-items: center;
    }

    .breadcrumbs ol li + li:before {
        display: inline-block;
        padding-right: 10px;
        color: #6c757d;
        content: "/";
    }

    .breadcrumbs ol li + li {
        padding-left: 10px;
    }

    .breadcrumbs ol li a {
        color: #667eea;
        transition: 0.3s;
    }

    .breadcrumbs ol li a:hover {
        color: #764ba2;
    }

    .breadcrumbs ol li.current {
        color: #6c757d;
    }
</style>

@endsection
