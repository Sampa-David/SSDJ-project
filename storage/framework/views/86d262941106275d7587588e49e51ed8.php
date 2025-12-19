

<?php $__env->startSection('title', 'My Events - Eventix'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <!-- Header Section -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>My Events</h2>
                    <a href="<?php echo e(route('events.payment')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Event
                    </a>
                </div>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if($events->count() > 0): ?>
            <div class="row">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1"><?php echo e($event->name); ?></h5>
                                        <small class="d-block">
                                            <i class="fas fa-calendar"></i> <?php echo e($event->date_event->format('M d, Y')); ?> | 
                                            <i class="fas fa-map-marker-alt"></i> <?php echo e($event->location); ?>

                                        </small>
                                    </div>
                                    <div>
                                        <?php if($event->status === 'published'): ?>
                                            <span class="badge bg-success">Published</span>
                                        <?php elseif($event->status === 'expired'): ?>
                                            <span class="badge bg-danger">Expired</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning"><?php echo e(ucfirst($event->status)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-text text-muted mb-3"><?php echo e(Str::limit($event->description, 100)); ?></p>
                                <div class="row mb-3 pb-3 border-bottom">
                                    <div class="col-6">
                                        <small class="text-muted">Package</small>
                                        <p class="mb-0"><strong><?php echo e(ucfirst($event->package_type)); ?></strong></p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Price</small>
                                        <p class="mb-0"><strong>$<?php echo e(number_format($event->price, 2)); ?></strong></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Visibility</small>
                                        <p class="mb-0">
                                            <?php if($event->visibility === 'public'): ?>
                                                <span class="badge bg-info">Public</span>
                                            <?php elseif($event->visibility === 'friends'): ?>
                                                <span class="badge bg-warning">Friends</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Private</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Promotion Until</small>
                                        <p class="mb-0"><?php echo e($event->date_event?->format('Y-m-d\ H:i:s')); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('events.show', $event->id)); ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <?php if($event->status === 'published'): ?>
                                        <a href="<?php echo e(route('events.edit', $event->id)); ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    <?php endif; ?>
                                    <form action="<?php echo e(route('events.destroy', $event->id)); ?>" method="POST" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                <?php echo e($events->links()); ?>

            </div>
        <?php else: ?>
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <div style="font-size: 3rem; margin-bottom: 20px;">📅</div>
                    <h5 class="card-title">No Events Yet</h5>
                    <p class="card-text text-muted mb-4">You haven't created any events yet. Create your first event and get it published!</p>
                    <a href="<?php echo e(route('events.payment')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus"></i> Create Your First Event
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/events/index.blade.php ENDPATH**/ ?>