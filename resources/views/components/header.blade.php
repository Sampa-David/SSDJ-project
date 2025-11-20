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
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('my-tickets') }}">My Tickets</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer;">Logout</button>
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
