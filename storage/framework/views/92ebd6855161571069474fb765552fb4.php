

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <h2 class="mb-4">Purchase Tickets</h2>

            <p class="lead text-muted mb-5">
                Choose your ticket type and secure your spot at the Global Tech Summit 2026
            </p>

            <div class="row">
                <?php $__currentLoopData = $ticketTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm" style="border-top: 4px solid #667eea;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo e($details['name']); ?></h5>
                                <p class="text-muted small mb-3"><?php echo e($details['description']); ?></p>

                                <div class="mb-4">
                                    <h3 class="text-primary">$<?php echo e($details['price']); ?></h3>
                                    <small class="text-muted">per ticket</small>
                                </div>

                                <ul class="list-unstyled mb-4 flex-grow-1">
                                    <?php $__currentLoopData = $details['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success"></i>
                                            <small><?php echo e($feature); ?></small>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>

                                <form action="<?php echo e(route('ticket.purchase')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="ticket_type" value="<?php echo e($type); ?>">
                                    <div class="mb-3">
                                        <label for="quantity_<?php echo e($type); ?>" class="form-label small">Quantity</label>
                                        <select name="quantity" id="quantity_<?php echo e($type); ?>" class="form-select form-select-sm">
                                            <?php for($i = 1; $i <= 10; $i++): ?>
                                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Buy Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/tickets/purchase.blade.php ENDPATH**/ ?>