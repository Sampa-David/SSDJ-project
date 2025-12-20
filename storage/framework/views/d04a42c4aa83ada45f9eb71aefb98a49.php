

<?php $__env->startSection('title', 'Statistics & Reports'); ?>
<?php $__env->startSection('page-title', 'Statistics & Reports'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <div>
        <h2>Statistics & Reports</h2>
        <p class="text-muted">Comprehensive overview of system performance and metrics</p>
    </div>
    <div class="btn-group-header">
        <button type="button" class="btn btn-outline-secondary" onclick="generateReport()">
            <i class="fas fa-sync me-1"></i> Refresh
        </button>
        <a href="<?php echo e(route('admin.export')); ?>" class="btn btn-outline-primary">
            <i class="fas fa-download me-1"></i> Export CSV
        </a>
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
                        <h2 class="mb-0 fw-bold" id="totalUsers">0</h2>
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
                        <h2 class="mb-0 fw-bold" id="totalTickets">0</h2>
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
                        <h2 class="mb-0 fw-bold">$<span id="totalRevenue">0.00</span></h2>
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
                        <h2 class="mb-0 fw-bold" id="activeTickets">0</h2>
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
    <!-- Ticket Status Distribution -->
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-pie text-primary"></i> Ticket Status Distribution</h5>
            </div>
            <div class="card-body">
                <div id="statusChart" style="height: 300px;"></div>
                <div class="mt-3" id="statusLegend"></div>
            </div>
        </div>
    </div>

    <!-- Key Metrics -->
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-tachometer-alt text-info"></i> Key Metrics</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="metric-box">
                            <h6 class="text-muted small mb-2">Avg Revenue per Ticket</h6>
                            <h3 class="fw-bold" id="avgRevenue">$0.00</h3>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="metric-box">
                            <h6 class="text-muted small mb-2">Revenue per User</h6>
                            <h3 class="fw-bold" id="revenuePerUser">$0.00</h3>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="metric-box">
                            <h6 class="text-muted small mb-2">Ticket Conversion Rate</h6>
                            <h3 class="fw-bold" id="conversionRate">0%</h3>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="metric-box">
                            <h6 class="text-muted small mb-2">Active Rate</h6>
                            <h3 class="fw-bold" id="activeRate">0%</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Status Table -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-table text-success"></i> Ticket Status Breakdown</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Status</th>
                        <th>Count</th>
                        <th>Percentage</th>
                        <th>Trend</th>
                    </tr>
                </thead>
                <tbody id="statusTableBody">
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="fas fa-spinner fa-spin"></i> Loading data...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Report Period -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-calendar text-warning"></i> Report Period</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-info mb-0">
                    <strong>Last Updated:</strong><br>
                    <span id="lastUpdated">Just now</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-success mb-0">
                    <strong>Report Generated:</strong><br>
                    <span id="reportGenerated"><?php echo e(now()->format('M d, Y H:i:s')); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    let statusChart = null;

    // Load statistics
    function generateReport() {
        fetch('<?php echo e(route("admin.stats")); ?>')
            .then(response => response.json())
            .then(data => {
                updateStatistics(data);
                updateCharts(data);
                updateTimestamp();
            })
            .catch(error => {
                console.error('Error loading statistics:', error);
                alert('Failed to load statistics. Please refresh the page.');
            });
    }

    function updateStatistics(data) {
        // Update card values
        document.getElementById('totalUsers').textContent = formatNumber(data.totalUsers);
        document.getElementById('totalTickets').textContent = formatNumber(data.totalTickets);
        document.getElementById('totalRevenue').textContent = formatCurrency(data.totalRevenue);
        document.getElementById('activeTickets').textContent = formatNumber(data.activeTickets);

        // Calculate and update metrics
        const avgRevenue = data.totalTickets > 0 ? data.totalRevenue / data.totalTickets : 0;
        const revenuePerUser = data.totalUsers > 0 ? data.totalRevenue / data.totalUsers : 0;
        const conversionRate = data.totalUsers > 0 ? (data.totalTickets / data.totalUsers) * 100 : 0;
        const activeRate = data.totalTickets > 0 ? (data.activeTickets / data.totalTickets) * 100 : 0;

        document.getElementById('avgRevenue').textContent = '$' + avgRevenue.toFixed(2);
        document.getElementById('revenuePerUser').textContent = '$' + revenuePerUser.toFixed(2);
        document.getElementById('conversionRate').textContent = conversionRate.toFixed(1) + '%';
        document.getElementById('activeRate').textContent = activeRate.toFixed(1) + '%';

        // Update status table
        updateStatusTable(data.ticketStatus);
    }

    function updateStatusTable(ticketStatus) {
        const total = Object.values(ticketStatus).reduce((a, b) => a + b, 0);
        let html = '';

        const colors = {
            'active': 'bg-success',
            'used': 'bg-info',
            'expired': 'bg-warning',
            'cancelled': 'bg-danger'
        };

        for (const [status, count] of Object.entries(ticketStatus)) {
            const percentage = total > 0 ? (count / total) * 100 : 0;
            const trend = '→'; // Could be enhanced with arrow up/down

            html += `
                <tr>
                    <td>
                        <span class="badge ${colors[status] || 'bg-secondary'}">
                            ${status.charAt(0).toUpperCase() + status.slice(1)}
                        </span>
                    </td>
                    <td><strong>${count}</strong></td>
                    <td>${percentage.toFixed(1)}%</td>
                    <td>${trend}</td>
                </tr>
            `;
        }

        document.getElementById('statusTableBody').innerHTML = html;
    }

    function updateCharts(data) {
        // Prepare data for status chart
        const labels = Object.keys(data.ticketStatus).map(s => 
            s.charAt(0).toUpperCase() + s.slice(1)
        );
        const values = Object.values(data.ticketStatus);

        const colors = ['#28a745', '#17a2b8', '#ffc107', '#dc3545', '#6c757d'];
        
        // Destroy existing chart if it exists
        if (statusChart) {
            statusChart.destroy();
        }

        const ctx = document.getElementById('statusChart').getContext('2d');
        statusChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors.slice(0, labels.length),
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

        // Update legend
        let legendHtml = '<div class="row g-2 mt-2">';
        labels.forEach((label, index) => {
            legendHtml += `
                <div class="col-auto">
                    <span class="badge" style="background-color: ${colors[index]}">${label}: ${values[index]}</span>
                </div>
            `;
        });
        legendHtml += '</div>';
        document.getElementById('statusLegend').innerHTML = legendHtml;
    }

    function updateTimestamp() {
        const now = new Date();
        document.getElementById('lastUpdated').textContent = now.toLocaleString();
    }

    function formatNumber(num) {
        return new Intl.NumberFormat('en-US').format(num);
    }

    function formatCurrency(num) {
        return new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(num).replace('$', '');
    }

    // Load statistics on page load
    document.addEventListener('DOMContentLoaded', generateReport);

    // Auto-refresh every 30 seconds
    setInterval(generateReport, 30000);
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

.metric-box {
    padding: 15px;
    background: linear-gradient(135deg, #f8f9fa, #ffffff);
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.metric-box:nth-child(2n) {
    border-left-color: #28a745;
}

.metric-box:nth-child(3n) {
    border-left-color: #ffc107;
}

.metric-box:nth-child(4n) {
    border-left-color: #17a2b8;
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

.badge {
    padding: 6px 12px;
    font-weight: 500;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/stats.blade.php ENDPATH**/ ?>