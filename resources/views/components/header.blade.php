<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="{{ route('home') }}" class="logo d-flex align-items-center">
      <h1 class="sitename">Eventix</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ route('home') }}" class="@yield('nav-home', '')">Home</a></li>
        <li><a href="{{ route('home') }}#about" class="@yield('nav-about', '')">About</a></li>
        <li><a href="{{ route('schedule') }}" class="@yield('nav-schedule', '')">Schedule</a></li>
        <li><a href="{{ route('speakers') }}" class="@yield('nav-speakers', '')">Speakers</a></li>
        <li><a href="{{ route('venue') }}" class="@yield('nav-venue', '')">Venue</a></li>
        <li class="dropdown"><a href="{{ route('events.public.list') }}"><span>Events</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="{{ route('events.public.list') }}">All Events</a></li>
            <li><hr class="dropdown-divider"></li>
            @php
              $upcomingEvents = \App\Models\Event::where('status', 'published')
                ->where('date_event', '>=', now())
                ->where('visibility', '=', 'public')
                ->orderBy('date_event', 'asc')
                ->take(5)
                ->get();
            @endphp
            @forelse($upcomingEvents as $event)
              <li><a href="{{ route('events.public.show', $event->id) }}">{{ $event->name }} <small class="text-muted">({{ $event->date_event->format('M d') }})</small></a></li>
            @empty
              <li><a href="#" class="text-muted">No upcoming events</a></li>
            @endforelse
          </ul>
        </li>
        <li class="dropdown"><a href="#"><span>More Pages</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="{{ route('buy-tickets') }}">Buy Tickets</a></li>
            <li><a href="{{ route('terms') }}">Terms</a></li>
            <li><a href="{{ route('privacy') }}">Privacy</a></li>
            <li><a href="{{ route('contact') }}">Contact</a></li>
          </ul>
        </li>
        @auth
        <li class="dropdown"><a href="#"><span>My Account</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="{{ route('dashboard') }}"><i class="bi bi-house"></i> My Dashboard</a></li>
            <li><a href="{{ route('my-tickets') }}"><i class="bi bi-ticket-perforated"></i> My Tickets</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="#"><i class="bi bi-gear"></i> Settings</a></li>
            <li><a href="#"><i class="bi bi-question-circle"></i> Support</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer; color: #dc3545;"><i class="bi bi-box-arrow-right"></i> Logout</button>
              </form>
            </li>
          </ul>
        </li>
        @endauth
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    @auth
      <a class="btn-getstarted" href="{{ route('dashboard') }}">Dashboard</a>
    @else
      <div style="display: flex; gap: 10px;">
        <a class="btn-getstarted" href="{{ route('login') }}" style="background: transparent; color: #667eea; border: 2px solid #667eea; padding: 8px 20px;">Login</a>
        <a class="btn-getstarted" href="{{ route('register') }}">Register</a>
      </div>
    @endauth

  </div>
</header>
