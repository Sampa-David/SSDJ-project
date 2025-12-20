<?php $__env->startSection('title', 'Home - Eventix'); ?>
<?php $__env->startSection('body_class', 'index-page'); ?>

<?php $__env->startSection('content'); ?>

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
          <a href="<?php echo e(route('buy-tickets')); ?>" class="btn btn-primary btn-lg me-3">Register Now</a>
          <a href="<?php echo e(route('schedule')); ?>" class="btn btn-outline-primary btn-lg">View Schedule</a>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="hero-image-wrapper">
          <img src="<?php echo e(asset('assetss/img/events/gallery-7.webp')); ?>" alt="Global Tech Summit" class="img-fluid hero-image">
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
          <img src="<?php echo e(asset('assetss/img/events/showcase-8.webp')); ?>" alt="Event showcase" class="img-fluid">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Events Section -->
<section id="events" class="events section light-background">
  <div class="container section-title" data-aos="fade-up">
    <h2>Upcoming Events</h2>
    <p>Discover and join our latest events</p>
  </div>

  <div class="container" data-aos="fade-up" data-aos-delay="100">
    <div class="swiper init-swiper">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 4000
          },
          "slidesPerView": "auto",
          "spaceBetween": 20,
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "spaceBetween": 15
            },
            "480": {
              "slidesPerView": 3,
              "spaceBetween": 15
            },
            "768": {
              "slidesPerView": 4,
              "spaceBetween": 20
            },
            "1024": {
              "slidesPerView": 5,
              "spaceBetween": 20
            }
          }
        }
      </script>
      <div class="swiper-wrapper">
        <?php $__empty_1 = true; $__currentLoopData = $featuredEvents ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="swiper-slide">
            <div class="event-item position-relative h-100" style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: all 0.3s ease; display: flex; flex-direction: column;">
              <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); height: 100px; display: flex; align-items: center; justify-content: center; color: white; position: relative;">
                <i class="bi bi-calendar-event" style="font-size: 50px; opacity: 0.2; position: absolute;"></i>
                <span style="position: relative; z-index: 2; font-weight: 700; font-size: 0.85rem; text-align: center; padding: 0 8px;"><?php echo e($event->date_event->format('M d')); ?></span>
              </div>
              <div style="padding: 12px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                  <h5 style="color: #333; margin: 0 0 8px 0; font-weight: 700; font-size: 0.95rem; line-height: 1.3;"><?php echo e(Str::limit($event->name, 30)); ?></h5>
                  <p style="color: #999; margin: 0; font-size: 0.8rem;"><?php echo e(Str::limit($event->location, 25)); ?></p>
                </div>
                <a href="<?php echo e(route('events.public.show', $event)); ?>" class="btn btn-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; margin-top: 8px; text-align: center; text-decoration: none; transition: all 0.3s ease;">
                  View
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="swiper-slide">
            <div style="text-align: center; padding: 40px 20px; background: white; border-radius: 10px;">
              <i class="bi bi-calendar-x" style="font-size: 50px; color: #ccc; display: block; margin-bottom: 10px;"></i>
              <p style="color: #999; font-size: 0.9rem; margin: 0;">No events yet</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/welcome.blade.php ENDPATH**/ ?>