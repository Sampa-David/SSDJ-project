

<?php $__env->startSection('title', 'Publish Events - Eventix'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="card-body p-5">
                        <h1 class="card-title mb-2">Get Publishing Rights 📅</h1>
                        <p class="card-text mb-0">Pay once to publish events for your chosen period</p>
                    </div>
                </div>
            </div>
        </div>

        <?php if($userHasRights): ?>
            <!-- Active Rights Message -->
            <div class="alert alert-success alert-dismissible fade show mb-5" role="alert">
                <h4 class="alert-heading">You have active publishing rights! ✅</h4>
                <p>Your current rights expire on: <strong><?php echo e($activeRight->expires_at->format('F d, Y')); ?></strong></p>
                <small>You can create and manage unlimited events until the expiry date.</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Packages Selection -->
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <h3 class="mb-4 text-center">Choose Your Publishing Plan</h3>
                
                <form id="paymentForm" method="POST" action="<?php echo e(route('events.process-payment')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow-sm border-0 h-100 package-card" data-package="<?php echo e($key); ?>" style="cursor: pointer; transition: all 0.3s ease;">
                                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; position: relative;">
                                        <div class="form-check" style="position: absolute; top: 10px; right: 10px;">
                                            <input 
                                                class="form-check-input" 
                                                type="radio" 
                                                name="package_type" 
                                                id="package_<?php echo e($key); ?>" 
                                                value="<?php echo e($key); ?>"
                                                <?php echo e(old('package_type') === $key ? 'checked' : ''); ?>>
                                        </div>
                                        <h5 class="mb-2"><?php echo e($package['name']); ?></h5>
                                        <div class="price-section">
                                            <span style="font-size: 2rem; font-weight: bold;">$<?php echo e($package['price']); ?></span>
                                            <small>/once</small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted small mb-3"><?php echo e($package['description']); ?></p>
                                        <ul class="list-unstyled">
                                            <?php $__currentLoopData = $package['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="mb-2">
                                                    <i class="fas fa-check" style="color: #28a745;"></i>
                                                    <span class="ms-2"><?php echo e($feature); ?></span>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                    <div class="card-footer bg-light">
                                        <button 
                                            type="button" 
                                            class="btn btn-primary w-100 select-package-btn"
                                            data-package="<?php echo e($key); ?>">
                                            Select Plan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Summary Section -->
                    <div class="card shadow-sm border-0 mt-5">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">📊 Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Selected Plan:</strong></p>
                                    <p id="summaryPackage" class="text-muted">Please select a plan</p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p><strong>One-time Price:</strong></p>
                                    <h4 id="summaryPrice" style="color: #667eea;">$0.00</h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary w-100">Cancel</a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>
                                        <i class="fas fa-credit-card"></i> Proceed to Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .package-card {
        border: 2px solid transparent;
        transition: all 0.3s ease;
    }

    .package-card:hover {
        border-color: #667eea;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2) !important;
        transform: translateY(-5px);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const packages = <?php echo json_encode($packages, 15, 512) ?>;
    const packageCards = document.querySelectorAll('.package-card');
    const submitBtn = document.getElementById('submitBtn');

    packageCards.forEach(card => {
        card.addEventListener('click', function() {
            const packageKey = this.getAttribute('data-package');
            const radio = document.getElementById('package_' + packageKey);
            radio.checked = true;
            updateSummary(packageKey);
            packageCards.forEach(c => c.style.boxShadow = '');
            this.style.boxShadow = '0 10px 30px rgba(102, 126, 234, 0.3)';
        });
    });

    document.querySelectorAll('input[name="package_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            updateSummary(this.value);
        });
    });

    function updateSummary(packageKey) {
        const package = packages[packageKey];
        document.getElementById('summaryPackage').textContent = package.name;
        document.getElementById('summaryPrice').textContent = '$' + package.price.toFixed(2);
        submitBtn.disabled = false;
    }

    // Check if a package is already selected
    const checkedRadio = document.querySelector('input[name="package_type"]:checked');
    if (checkedRadio) {
        updateSummary(checkedRadio.value);
    }
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/events/payment.blade.php ENDPATH**/ ?>