<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

    <a href="<?php echo e(route('home')); ?>" class="logo d-flex align-items-center">
      <h1 class="sitename">Eventix</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="<?php echo e(route('home')); ?>" class="<?php echo $__env->yieldContent('nav-home', ''); ?>">Home</a></li>
        <li><a href="<?php echo e(route('home')); ?>#about" class="<?php echo $__env->yieldContent('nav-about', ''); ?>">About</a></li>
        <li><a href="<?php echo e(route('schedule')); ?>" class="<?php echo $__env->yieldContent('nav-schedule', ''); ?>">Schedule</a></li>
        <li><a href="<?php echo e(route('speakers')); ?>" class="<?php echo $__env->yieldContent('nav-speakers', ''); ?>">Speakers</a></li>
        <li><a href="<?php echo e(route('venue')); ?>" class="<?php echo $__env->yieldContent('nav-venue', ''); ?>">Venue</a></li>
        <li class="dropdown"><a href="#"><span>More Pages</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="<?php echo e(route('buy-tickets')); ?>">Buy Tickets</a></li>
            <li><a href="<?php echo e(route('terms')); ?>">Terms</a></li>
            <li><a href="<?php echo e(route('privacy')); ?>">Privacy</a></li>
            <li><a href="<?php echo e(route('contact')); ?>">Contact</a></li>
          </ul>
        </li>
        <?php if(auth()->guard()->check()): ?>
        <li class="dropdown"><a href="#"><span>My Account</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="<?php echo e(route('dashboard')); ?>"><i class="bi bi-house"></i> My Dashboard</a></li>
            <li><a href="<?php echo e(route('my-tickets')); ?>"><i class="bi bi-ticket-perforated"></i> My Tickets</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a href="#"><i class="bi bi-gear"></i> Settings</a></li>
            <li><a href="#"><i class="bi bi-question-circle"></i> Support</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="<?php echo e(route('logout')); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="dropdown-item" style="border: none; background: none; cursor: pointer; color: #dc3545;"><i class="bi bi-box-arrow-right"></i> Logout</button>
              </form>
            </li>
          </ul>
        </li>
        <?php endif; ?>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <?php if(auth()->guard()->check()): ?>
      <a class="btn-getstarted" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
    <?php else: ?>
      <div style="display: flex; gap: 10px;">
        <a class="btn-getstarted" href="<?php echo e(route('login')); ?>" style="background: transparent; color: #667eea; border: 2px solid #667eea; padding: 8px 20px;">Login</a>
        <a class="btn-getstarted" href="<?php echo e(route('register')); ?>">Register</a>
      </div>
    <?php endif; ?>

  </div>
</header>
<?php /**PATH S:\php(Laravel)\S²DJ\resources\views/components/header.blade.php ENDPATH**/ ?>