<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - SSDJ</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #007bff;
            --sidebar-width: 280px;
            --sidebar-bg: #2c3e50;
            --sidebar-text: #ecf0f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .sidebar-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            margin: 0;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-menu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: var(--primary-color);
            padding-left: 25px;
        }

        .sidebar-menu a.active {
            background-color: var(--primary-color);
            border-left-color: #fff;
            color: white;
        }

        .sidebar-menu a i {
            width: 20px;
            text-align: center;
        }

        .sidebar-section-title {
            padding: 20px 20px 10px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* TOP NAV */
        .top-navbar {
            background: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .navbar-title h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            background: #f0f0f0;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-menu:hover {
            background: #e0e0e0;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* PAGE CONTENT */
        .page-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .page-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .btn-group-header {
            display: flex;
            gap: 10px;
        }

        /* CARDS */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: 10px 10px 0 0;
        }

        .stat-card {
            border-left: 4px solid var(--primary-color);
            padding: 20px;
        }

        .stat-card.success {
            border-left-color: #28a745;
        }

        .stat-card.warning {
            border-left-color: #ffc107;
        }

        .stat-card.info {
            border-left-color: #17a2b8;
        }

        .stat-card.danger {
            border-left-color: #dc3545;
        }

        /* BADGES */
        .badge {
            padding: 6px 10px;
            border-radius: 5px;
            font-weight: 600;
        }

        /* TABLES */
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 700;
            border-color: #e9ecef;
            color: #2c3e50;
        }

        .table tbody tr:hover {
            background-color: #f0f0f0;
        }

        /* BUTTONS */
        .btn {
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* ALERTS */
        .alert {
            border-radius: 8px;
            border: none;
        }

        /* MENU TOGGLE BUTTON */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #2c3e50;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }

        .menu-toggle:hover {
            transform: scale(1.1);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            :root {
                --sidebar-width: 280px;
            }

            .menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1001;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .page-content {
                padding: 20px;
            }

            .navbar-title h1 {
                font-size: 1.3rem;
            }

            .navbar-right {
                gap: 10px;
            }

            .user-menu {
                padding: 6px 10px;
                font-size: 0.9rem;
            }

            .user-avatar {
                width: 30px;
                height: 30px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .navbar-title h1 {
                font-size: 1.1rem;
            }

            .page-content {
                padding: 15px;
            }

            .stat-card {
                padding: 15px;
            }

            .card-header {
                padding: 12px 15px;
            }

            .top-navbar {
                padding: 12px 15px;
                gap: 10px;
            }
        }

        /* SCROLLBAR */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="admin-wrapper">
        <!-- SIDEBAR OVERLAY (Mobile) -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h4>SSDJ Admin</h4>
            </div>

            <ul class="sidebar-menu">
                <!-- DASHBOARD -->
                <li class="sidebar-section-title">Main</li>
                <li>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php if(Route::currentRouteName() === 'admin.dashboard'): ?> active <?php endif; ?>">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- USERS -->
                <li class="sidebar-section-title">Management</li>
                <li>
                    <a href="<?php echo e(route('admin.users')); ?>" class="<?php if(Route::currentRouteName() === 'admin.users' || Route::currentRouteName() === 'admin.user'): ?> active <?php endif; ?>">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.tickets')); ?>" class="<?php if(Route::currentRouteName() === 'admin.tickets' || Route::currentRouteName() === 'admin.ticket'): ?> active <?php endif; ?>">
                        <i class="fas fa-ticket-alt"></i>
                        <span>Tickets</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.events.index')); ?>" class="<?php if(Route::currentRouteName() === 'admin.events.index' || Route::currentRouteName() === 'admin.events.create' || Route::currentRouteName() === 'admin.events.edit'): ?> active <?php endif; ?>">
                        <i class="fas fa-calendar"></i>
                        <span>Events</span>
                    </a>
                </li>

                <!-- REPORTS -->
                <li class="sidebar-section-title">Analytics</li>
                <li>
                    <a href="<?php echo e(route('admin.stats')); ?>">
                        <i class="fas fa-chart-bar"></i>
                        <span>Statistics</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.payment-history')); ?>" class="<?php if(Route::currentRouteName() === 'admin.payment-history'): ?> active <?php endif; ?>">
                        <i class="fas fa-history"></i>
                        <span>Payment History</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo e(route('admin.export')); ?>">
                        <i class="fas fa-download"></i>
                        <span>Export Data</span>
                    </a>
                </li>

                <!-- SETTINGS -->
                <li class="sidebar-section-title">System</li>
                <li>
                    <a href="#settings">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                </li>
                <li>
                    <a href="#logs">
                        <i class="fas fa-file-alt"></i>
                        <span>Activity Logs</span>
                    </a>
                </li>

                <!-- USER SECTION -->
                <li class="sidebar-section-title">Account</li>
                <li>
                    <a href="<?php echo e(route('home')); ?>">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to App</span>
                    </a>
                </li>
                <li>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" style="margin: 0;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="sidebar-menu" style="width: 100%; border: none; background: none; padding: 12px 20px; justify-content: flex-start;">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- TOP NAVBAR -->
            <nav class="top-navbar">
                <div class="d-flex align-items-center gap-3">
                    <button class="menu-toggle" id="menuToggle" title="Toggle Menu">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="navbar-title">
                        <h1><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                    </div>
                </div>
                <div class="navbar-right">
                    <div class="user-menu dropdown">
                        <button class="btn btn-link dropdown-toggle p-0" type="button" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: inherit;">
                            <div class="user-avatar">
                                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                            </div>
                            <div>
                                <small class="text-muted"><?php echo e(auth()->user()->email); ?></small>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuDropdown">
                            <li><a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">
                                <i class="fas fa-user me-2"></i> My Profile
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                                <i class="fas fa-edit me-2"></i> Edit Profile
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </button>
                            </form></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- PAGE CONTENT -->
            <div class="page-content">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <h5><i class="fas fa-exclamation-circle"></i> Error</h5>
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        // Toggle menu
        menuToggle?.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });

        // Close menu when clicking overlay
        sidebarOverlay?.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });

        // Close menu when clicking on a link
        document.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        });

        // Close menu on window resize (if resizing to larger screen)
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH S:\php(Laravel)\S²DJ\resources\views/layouts/admin.blade.php ENDPATH**/ ?>