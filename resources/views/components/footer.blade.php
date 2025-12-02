<footer id="footer" class="footer position-relative light-background">

  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
          <span class="sitename">Eventix</span>
        </a>
        
        <div class="social-links d-flex mt-4">
          <a href=""><i class="bi bi-twitter-x"></i></a>
          <a href=""><i class="bi bi-facebook"></i></a>
          <a href=""><i class="bi bi-instagram"></i></a>
          <a href=""><i class="bi bi-linkedin"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Useful Links</h4>
        <ul>
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="#about">About us</a></li>
          <li><a href="{{ route('schedule') }}">Schedule</a></li>
          <li><a href="{{ route('terms') }}">Terms of service</a></li>
          <li><a href="{{ route('privacy') }}">Privacy policy</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Our Services</h4>
        <ul>
          <li><a href="#">Event Planning</a></li>
          <li><a href="#">Conference Management</a></li>
          <li><a href="#">Networking Events</a></li>
          <li><a href="#">Virtual Events</a></li>
          <li><a href="#">Workshop Organization</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Event Categories</h4>
        <ul>
          <li><a href="#">Technology</a></li>
          <li><a href="#">Business</a></li>
          <li><a href="#">Design</a></li>
          <li><a href="#">Startup</a></li>
          <li><a href="#">Innovation</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="{{ route('speakers') }}">Speakers</a></li>
          <li><a href="{{ route('venue') }}">Venue</a></li>
          <li><a href="{{ route('buy-tickets') }}">Tickets</a></li>
          <li><a href="{{ route('contact') }}">Contact</a></li>
          <li><a href="#">Gallery</a></li>
        </ul>
      </div>

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p>2025 © <span>Copyright</span> <strong class="px-1 sitename">Eventix</strong> <span>All Rights Reserved</span></p>
    <div class="credits">
      Designed by <a href="https://sampadavid.netlify.app/">Sampa David</a>
    </div>
  </div>

</footer>
