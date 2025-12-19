

<?php $__env->startSection('content'); ?>
<div class="admin-page">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-history"></i>
                Payment History
            </h1>
            <p class="page-subtitle">All publishing rights transactions</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">Total Revenue</h6>
                    <h3 class="stat-value">$<?php echo e(number_format($totalRevenue, 2)); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-success">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">Total Transactions</h6>
                    <h3 class="stat-value"><?php echo e($totalTransactions); ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon bg-info">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">Active Rights</h6>
                    <h3 class="stat-value"><?php echo e($publishingRights->where('status', 'active')->count()); ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Transaction List</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Package</th>
                        <th>Price</th>
                        <th>Purchased</th>
                        <th>Expires</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $publishingRights; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $right): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <strong><?php echo e($right->user->name); ?></strong>
                        </td>
                        <td>
                            <?php echo e($right->user->email); ?>

                        </td>
                        <td>
                            <span class="badge badge-primary">
                                <?php echo e(ucfirst(str_replace('_', ' ', $right->package_type))); ?>

                            </span>
                        </td>
                        <td>
                            <strong class="text-success">$<?php echo e(number_format($right->price, 2)); ?></strong>
                        </td>
                        <td>
                            <?php echo e($right->purchased_at->format('M d, Y H:i')); ?>

                        </td>
                        <td>
                            <?php echo e($right->expires_at->format('M d, Y')); ?>

                        </td>
                        <td>
                            <?php
                                $days = $right->purchased_at->diffInDays($right->expires_at);
                                if($days <= 30) {
                                    $duration = 'Monthly';
                                } elseif($days <= 90) {
                                    $duration = 'Quarterly';
                                } else {
                                    $duration = 'Yearly';
                                }
                            ?>
                            <?php echo e($duration); ?> (<?php echo e($days); ?> days)
                        </td>
                        <td>
                            <?php if($right->status === 'active' && $right->expires_at > now()): ?>
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle"></i>
                                Active
                            </span>
                            <?php elseif($right->expires_at <= now()): ?>
                            <span class="badge badge-secondary">
                                <i class="fas fa-times-circle"></i>
                                Expired
                            </span>
                            <?php else: ?>
                            <span class="badge badge-warning">
                                <i class="fas fa-pause-circle"></i>
                                <?php echo e(ucfirst($right->status)); ?>

                            </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <p class="text-muted mb-0">No transactions found</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($publishingRights->hasPages()): ?>
        <div class="card-footer">
            <?php echo e($publishingRights->links('pagination::bootstrap-4')); ?>

        </div>
        <?php endif; ?>
    </div>

    <!-- Revenue Chart Section -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Revenue by Package</h5>
        </div>
        <div class="card-body">
            <canvas id="revenueChart" height="80"></canvas>
        </div>
    </div>
</div>

<style>
.stat-card {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1rem;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    margin-right: 1.5rem;
}

.stat-icon.bg-primary {
    background-color: #007bff;
}

.stat-icon.bg-success {
    background-color: #28a745;
}

.stat-icon.bg-info {
    background-color: #17a2b8;
}

.stat-content h6 {
    margin: 0;
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 600;
}

.stat-content .stat-value {
    margin: 0.5rem 0 0 0;
    font-size: 1.75rem;
    font-weight: 700;
    color: #333;
}

.badge {
    padding: 0.35rem 0.65rem;
    border-radius: 4px;
    font-weight: 500;
    font-size: 0.85rem;
}

.badge-primary {
    background-color: #007bff;
    color: white;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-secondary {
    background-color: #6c757d;
    color: white;
}

.badge-warning {
    background-color: #ffc107;
    color: #333;
}

.text-success {
    color: #28a745;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentData = <?php echo json_encode($publishingRights->groupBy('package_type')->map(function($items) {
        return $items->sum('price');
    }), 15, 512) ?>;
    
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(paymentData).map(key => 
                key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' ')
            ),
            datasets: [{
                data: Object.values(paymentData),
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8'],
                borderColor: '#fff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/payment-history.blade.php ENDPATH**/ ?>