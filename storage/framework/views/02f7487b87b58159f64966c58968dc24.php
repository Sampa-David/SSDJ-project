

<?php $__env->startSection('title', $event->name . ' - Eventix'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <a href="<?php echo e(route('events.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Event Content -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h3 class="mb-2"><?php echo e($event->name); ?></h3>
                                <small>
                                    <i class="fas fa-calendar"></i> <?php echo e($event->date_event->format('F d, Y')); ?> | 
                                    <i class="fas fa-map-marker-alt"></i> <?php echo e($event->location); ?>

                                </small>
                            </div>
                            <div>
                                <?php if($event->status === 'published'): ?>
                                    <span class="badge bg-success" style="font-size: 0.9rem;">Published</span>
                                <?php elseif($event->status === 'expired'): ?>
                                    <span class="badge bg-danger" style="font-size: 0.9rem;">Expired</span>
                                <?php else: ?>
                                    <span class="badge bg-warning" style="font-size: 0.9rem;"><?php echo e(ucfirst($event->status)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h5 class="mb-3">Description</h5>
                            <p class="card-text"><?php echo e($event->description); ?></p>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Visibility</h6>
                                <p>
                                    <?php if($event->visibility === 'public'): ?>
                                        <i class="fas fa-globe"></i> Public
                                    <?php elseif($event->visibility === 'friends'): ?>
                                        <i class="fas fa-users"></i> Friends Only
                                    <?php else: ?>
                                        <i class="fas fa-lock"></i> Private
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Promotion Expires</h6>
                                <p>
                                    <?php if($event->expires_at): ?>
                                        <?php echo e($event->expires_at->format('F d, Y')); ?>

                                    <?php else: ?>
                                        <span class="text-muted">No expiration</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if(Auth::user()->id === $event->user_id && $event->status === 'published'): ?>
                    <div class="row gap-2">
                        <div class="col-md-6">
                            <a href="<?php echo e(route('events.edit', $event->id)); ?>" class="btn btn-warning w-100">
                                <i class="fas fa-edit"></i> Edit Event
                            </a>
                        </div>
                        <div class="col-md-6">
                            <form action="<?php echo e(route('events.destroy', $event->id)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i> Delete Event
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <!-- Sidebar Info -->
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Package Type</small>
                            <p class="mb-0">
                                <strong><?php echo e(ucfirst($event->package_type ?? 'N/A')); ?></strong>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Price Paid</small>
                            <p class="mb-0">
                                <strong>$<?php echo e(number_format($event->price ?? 0, 2)); ?></strong>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Payment ID</small>
                            <p class="mb-0">
                                <code><?php echo e($event->payment_id ?? 'N/A'); ?></code>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Status</small>
                            <p class="mb-0">
                                <?php if($event->status === 'published'): ?>
                                    <span class="badge bg-success">Published</span>
                                <?php elseif($event->status === 'expired'): ?>
                                    <span class="badge bg-danger">Expired</span>
                                <?php else: ?>
                                    <span class="badge bg-warning"><?php echo e(ucfirst($event->status)); ?></span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Created At</small>
                            <p class="mb-0"><?php echo e($event->created_at->format('M d, Y')); ?></p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Expires At</small>
                            <p class="mb-0"><?php echo e($event->date_event?->format('Y-m-d\TH:i') ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Related Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Actions</h5>
                    </div>
                    <div class="card-body">
                        <a href="<?php echo e(route('events.create')); ?>" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-plus"></i> Create Event
                        </a>
                        <a href="<?php echo e(route('events.index')); ?>" class="btn btn-outline-primary w-100">
                            <i class="fas fa-list"></i> My Events
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/events/show.blade.php ENDPATH**/ ?>