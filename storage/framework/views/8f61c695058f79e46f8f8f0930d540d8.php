

<?php $__env->startSection('title', 'Admin Dashboard'); ?>
<?php $__env->startSection('page-title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h2>Welcome back!</h2>
        <p class="text-muted">Here's your complete event overview.</p>
    </div>
</div>

    <!-- Key Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Total Users</p>
                        <h3 class="mb-0"><?php echo e($totalUsers); ?></h3>
                    </div>
                    <span class="badge bg-primary p-2">
                        <i class="fas fa-users"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card success">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Total Tickets</p>
                        <h3 class="mb-0"><?php echo e($totalTickets); ?></h3>
                    </div>
                    <span class="badge bg-success p-2">
                        <i class="fas fa-ticket-alt"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card warning">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Total Revenue</p>
                        <h3 class="mb-0">$<?php echo e(number_format($totalRevenue, 2)); ?></h3>
                    </div>
                    <span class="badge bg-warning p-2">
                        <i class="fas fa-dollar-sign"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card info">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-1">Active Tickets</p>
                        <h3 class="mb-0"><?php echo e($activeTickets); ?></h3>
                    </div>
                    <span class="badge bg-info p-2">
                        <i class="fas fa-check-circle"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <!-- Revenue by Type -->
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Revenue by Ticket Type</h5>
                </div>
                <div class="card-body">
                    <div id="revenueChart" style="height: 300px;"></div>
                    <table class="table table-sm mt-3">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Count</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $revenueByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(ucfirst(str_replace('_', ' ', $item->ticket_type))); ?></td>
                                <td><span class="badge bg-primary"><?php echo e($item->count); ?></span></td>
                                <td class="fw-bold">$<?php echo e(number_format($item->revenue, 2)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Ticket Status Distribution -->
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-doughnut"></i> Ticket Status Distribution</h5>
                </div>
                <div class="card-body">
                    <div id="statusChart" style="height: 300px;"></div>
                    <div class="mt-3">
                        <?php $__currentLoopData = $ticketStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <span class="text-capitalize"><?php echo e($status); ?></span>
                            <span class="badge bg-secondary"><?php echo e($count); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Recent Transactions</h5>
                    <a href="<?php echo e(route('admin.tickets')); ?>" class="btn btn-sm btn-outline-primary">View All <i class="fas fa-arrow-right"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($transaction->purchased_at->format('M d, Y')); ?></td>
                                    <td><strong><?php echo e($transaction->user->name); ?></strong></td>
                                    <td><span class="badge bg-light text-dark"><?php echo e($transaction->type_label); ?></span></td>
                                    <td class="fw-bold">$<?php echo e($transaction->price_display); ?></td>
                                    <td>
                                        <span class="badge <?php if($transaction->status === 'active'): ?> bg-success <?php elseif($transaction->status === 'used'): ?> bg-info <?php else: ?> bg-danger <?php endif; ?>">
                                            <?php echo e(ucfirst($transaction->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.ticket', $transaction)); ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Buyers & Expiring Tickets -->
    <div class="row">
        <!-- Top Buyers -->
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-crown"></i> Top Buyers</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $topBuyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('admin.user', $buyer)); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0"><?php echo e($buyer->name); ?></h6>
                                <small class="text-muted"><?php echo e($buyer->email); ?></small>
                            </div>
                            <span class="badge bg-primary"><?php echo e($buyer->tickets_count); ?> tickets</span>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expiring Tickets -->
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-calendar-times"></i> Expiring Soon (30 days)</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php $__empty_1 = true; $__currentLoopData = $expiringTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-0"><?php echo e($ticket->user->name); ?></h6>
                                    <small class="text-muted"><?php echo e($ticket->type_label); ?> - Expires: <?php echo e($ticket->valid_until->format('M d, Y')); ?></small>
                                </div>
                                <span class="badge bg-warning"><?php echo e($ticket->ticket_number); ?></span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-muted text-center py-4"><i class="fas fa-check-circle"></i> No expiring tickets</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Revenue by Type Chart
    const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($revenueByType->pluck('ticket_type')->map(fn($t) => ucfirst(str_replace('_', ' ', $t)))); ?>,
                datasets: [{
                    data: <?php echo json_encode($revenueByType->pluck('revenue')); ?>,
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Status Chart
    const statusCtx = document.getElementById('statusChart')?.getContext('2d');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode($ticketStatus->keys()); ?>,
                datasets: [{
                    data: <?php echo json_encode($ticketStatus->values()); ?>,
                    backgroundColor: ['#28a745', '#007bff', '#ffc107', '#dc3545', '#6c757d']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>