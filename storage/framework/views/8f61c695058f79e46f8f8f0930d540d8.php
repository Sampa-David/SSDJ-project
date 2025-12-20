

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
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Total Users</p>
                        <h2 class="mb-0 fw-bold"><?php echo e($totalUsers ?? 0); ?></h2>
                    </div>
                    <div class="stat-icon bg-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card success h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Total Tickets</p>
                        <h2 class="mb-0 fw-bold"><?php echo e($totalTickets ?? 0); ?></h2>
                    </div>
                    <div class="stat-icon bg-success">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card warning h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Total Revenue</p>
                        <h2 class="mb-0 fw-bold">$<?php echo e(number_format($totalRevenue ?? 0, 2)); ?></h2>
                    </div>
                    <div class="stat-icon bg-warning">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stat-card info h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-2">Active Tickets</p>
                        <h2 class="mb-0 fw-bold"><?php echo e($activeTickets ?? 0); ?></h2>
                    </div>
                    <div class="stat-icon bg-info">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <!-- Revenue by Type -->
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-pie text-primary"></i> Revenue by Ticket Type</h5>
            </div>
            <div class="card-body">
                <?php if($revenueByType && count($revenueByType) > 0): ?>
                    <div id="revenueChart" style="height: 300px;"></div>
                    <table class="table table-sm mt-3 table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Type</th>
                                <th>Count</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $revenueByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="fw-5"><?php echo e(ucfirst(str_replace('_', ' ', $item->ticket_type ?? 'N/A'))); ?></td>
                                <td><span class="badge bg-primary"><?php echo e($item->count ?? 0); ?></span></td>
                                <td class="fw-bold text-success">$<?php echo e(number_format($item->revenue ?? 0, 2)); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-info-circle"></i> No data available</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Ticket Status Distribution -->
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-doughnut text-success"></i> Ticket Status Distribution</h5>
            </div>
            <div class="card-body">
                <?php if($ticketStatus && count($ticketStatus) > 0): ?>
                    <div id="statusChart" style="height: 300px;"></div>
                    <div class="mt-3">
                        <?php $__currentLoopData = $ticketStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                            <span class="text-capitalize">
                                <span class="badge 
                                    <?php if($status === 'active'): ?> bg-success
                                    <?php elseif($status === 'used'): ?> bg-info
                                    <?php elseif($status === 'expired'): ?> bg-warning
                                    <?php else: ?> bg-danger <?php endif; ?>">
                                    <?php echo e(ucfirst($status)); ?>

                                </span>
                            </span>
                            <span class="badge bg-secondary"><?php echo e($count); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-info-circle"></i> No data available</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-history text-info"></i> Recent Transactions</h5>
                <a href="<?php echo e(route('admin.tickets')); ?>" class="btn btn-sm btn-outline-primary">View All <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
            <div class="card-body">
                <?php if($recentTransactions && count($recentTransactions) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($transaction->purchased_at ? $transaction->purchased_at->format('M d, Y') : 'N/A'); ?></td>
                                    <td>
                                        <strong><?php echo e($transaction->user->name ?? 'Unknown'); ?></strong>
                                        <br>
                                        <small class="text-muted"><?php echo e($transaction->user->email ?? ''); ?></small>
                                    </td>
                                    <td><span class="badge bg-light text-dark"><?php echo e($transaction->type_label ?? $transaction->ticket_type ?? 'N/A'); ?></span></td>
                                    <td class="fw-bold text-success">$<?php echo e(number_format($transaction->price ?? 0, 2)); ?></td>
                                    <td>
                                        <span class="badge <?php if($transaction->status === 'active'): ?> bg-success <?php elseif($transaction->status === 'used'): ?> bg-info <?php else: ?> bg-danger <?php endif; ?>">
                                            <?php echo e(ucfirst($transaction->status ?? 'N/A')); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.ticket', $transaction)); ?>" class="btn btn-sm btn-outline-primary" title="View details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-inbox"></i> No transactions yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Top Buyers & Expiring Tickets -->
<div class="row">
    <!-- Top Buyers -->
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-crown text-warning"></i> Top Buyers</h5>
            </div>
            <div class="card-body p-0">
                <?php if($topBuyers && count($topBuyers) > 0): ?>
                    <div class="list-group list-group-flush">
                        <?php $__currentLoopData = $topBuyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('admin.user', $buyer)); ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-4 py-3 hover-effect">
                            <div>
                                <h6 class="mb-1 fw-bold"><?php echo e($buyer->name ?? 'Unknown'); ?></h6>
                                <small class="text-muted"><?php echo e($buyer->email ?? 'N/A'); ?></small>
                            </div>
                            <span class="badge bg-primary"><?php echo e($buyer->tickets_count ?? 0); ?> tickets</span>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-inbox"></i> No buyers yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Expiring Tickets -->
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-calendar-times text-danger"></i> Expiring Soon (30 days)</h5>
            </div>
            <div class="card-body p-0">
                <?php if($expiringTickets && count($expiringTickets) > 0): ?>
                    <div class="list-group list-group-flush">
                        <?php $__empty_1 = true; $__currentLoopData = $expiringTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="list-group-item px-4 py-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-bold"><?php echo e($ticket->user->name ?? 'Unknown'); ?></h6>
                                    <small class="text-muted d-block">
                                        <?php echo e($ticket->type_label ?? $ticket->ticket_type ?? 'N/A'); ?>

                                        <br>
                                        Expires: <strong class="text-warning"><?php echo e($ticket->valid_until ? $ticket->valid_until->format('M d, Y') : 'N/A'); ?></strong>
                                    </small>
                                </div>
                                <span class="badge bg-warning text-dark ms-2"><?php echo e($ticket->ticket_number ?? 'N/A'); ?></span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                            <p>No expiring tickets</p>
                        </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-4"><i class="fas fa-check-circle"></i> No expiring tickets</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Revenue by Type Chart
    const revenueData = <?php echo json_encode($revenueByType->map(fn($item) => [
        'type' => ucfirst(str_replace('_', ' ', $item->ticket_type ?? 'Unknown')),
        'revenue' => $item->revenue ?? 0
    ])->values()); ?>;
    
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx && revenueData.length > 0) {
        new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: revenueData.map(d => d.type),
                datasets: [{
                    data: revenueData.map(d => d.revenue),
                    backgroundColor: [
                        '#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8',
                        '#6f42c1', '#e83e8c', '#fd7e14', '#20c997', '#6c757d'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
    }

    // Status Chart
    const statusLabels = <?php echo json_encode($ticketStatus->keys()); ?>;
    const statusValues = <?php echo json_encode($ticketStatus->values()); ?>;
    const statusCtx = document.getElementById('statusChart');
    
    if (statusCtx && statusLabels.length > 0) {
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: statusLabels.map(label => label.charAt(0).toUpperCase() + label.slice(1)),
                datasets: [{
                    data: statusValues,
                    backgroundColor: [
                        '#28a745', '#007bff', '#ffc107', '#dc3545', '#6c757d',
                        '#17a2b8', '#6f42c1', '#e83e8c'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
    }
</script>

<style>
.stat-card {
    border: none;
    border-left: 4px solid #007bff;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.15);
}

.stat-card.success {
    border-left-color: #28a745;
}

.stat-card.success:hover {
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.15);
}

.stat-card.warning {
    border-left-color: #ffc107;
}

.stat-card.warning:hover {
    box-shadow: 0 8px 20px rgba(255, 193, 7, 0.15);
}

.stat-card.info {
    border-left-color: #17a2b8;
}

.stat-card.info:hover {
    box-shadow: 0 8px 20px rgba(23, 162, 184, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
}

.stat-icon.bg-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
}

.stat-icon.bg-success {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.stat-icon.bg-warning {
    background: linear-gradient(135deg, #ffc107, #cc9a06);
}

.stat-icon.bg-info {
    background: linear-gradient(135deg, #17a2b8, #0c5460);
}

.hover-effect {
    transition: all 0.3s ease;
}

.hover-effect:hover {
    background-color: #f8f9fa;
}

.card-header {
    background: linear-gradient(90deg, #f8f9fa, #ffffff);
    border-bottom: 1px solid #e9ecef;
}

table.table-hover tbody tr {
    transition: background-color 0.2s ease;
}

table.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('components.floating-message-btn', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>