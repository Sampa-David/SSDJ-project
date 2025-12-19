

<?php $__env->startSection('content'); ?>
<div class="admin-page">
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <i class="fas fa-calendar"></i>
                Events Management
            </h1>
            <p class="page-subtitle">Manage all events in your system</p>
        </div>
        <a href="<?php echo e(route('admin.events.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Create Event
        </a>
    </div>

    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i>
        <?php echo e(session('success')); ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo e(session('error')); ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">All Events</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Organizer</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Visibility</th>
                        <th>Status</th>
                        <th>Expires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <strong><?php echo e($event->name); ?></strong>
                        </td>
                        <td>
                            <?php echo e($event->user->name ?? 'Unknown'); ?>

                        </td>
                        <td>
                            <?php echo e($event->date_event ? $event->date_event->format('M d, Y') : 'N/A'); ?>

                        </td>
                        <td>
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo e($event->location ?? 'N/A'); ?>

                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($event->visibility === 'public' ? 'success' : ($event->visibility === 'friends' ? 'info' : 'secondary')); ?>">
                                <i class="fas fa-<?php echo e($event->visibility === 'public' ? 'globe' : ($event->visibility === 'friends' ? 'users' : 'lock')); ?>"></i>
                                <?php echo e(ucfirst($event->visibility)); ?>

                            </span>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($event->status === 'published' ? 'success' : 'warning'); ?>">
                                <?php echo e(ucfirst($event->status)); ?>

                            </span>
                        </td>
                        <td>
                            <?php if($event->date_event): ?>
                                <?php echo e($event->date_event->format('M d, Y')); ?>

                            <?php else: ?>
                                <span class="text-muted">Never</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?php echo e(route('admin.events.edit', $event)); ?>" class="btn btn-sm btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('admin.events.destroy', $event)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <p class="text-muted mb-0">No events found. <a href="<?php echo e(route('admin.events.create')); ?>">Create one now</a></p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($events->hasPages()): ?>
        <div class="card-footer">
            <?php echo e($events->links('pagination::bootstrap-4')); ?>

        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.action-buttons {
    display: flex;
    gap: 5px;
}

.action-buttons form {
    display: inline;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/events/index.blade.php ENDPATH**/ ?>