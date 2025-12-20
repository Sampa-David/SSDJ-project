

<?php $__env->startSection('title', 'Messages - Admin'); ?>
<?php $__env->startSection('page-title', 'Support Messages'); ?>

<?php $__env->startSection('content'); ?>

<!-- Messages Header -->
<div class="page-header">
    <div>
        <h2>Support Messages</h2>
        <p class="text-muted">Manage customer conversations and support tickets.</p>
    </div>
    <div class="header-actions">
        <a href="<?php echo e(route('admin.messages.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Message
        </a>
        <span class="badge bg-info">
            <i class="fas fa-inbox"></i> <?php echo e($conversations->total()); ?> Conversation(s)
        </span>
    </div>
</div>

<!-- Success Messages -->
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Conversations List -->
<?php if($conversations->count() > 0): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Subject</th>
                                <th>Client</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Unread</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e($conversation->unreadCount() > 0 ? 'table-active' : ''); ?>">
                                    <td>
                                        <strong><?php echo e($conversation->subject); ?></strong>
                                        <?php if($conversation->unreadCount() > 0): ?>
                                            <br>
                                            <small class="text-danger">
                                                <i class="fas fa-circle"></i> <?php echo e($conversation->unreadCount()); ?> unread
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="avatar-sm" style="width: 32px; height: 32px; background: #667eea; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 12px;">
                                                <?php echo e(strtoupper(substr($conversation->user->name, 0, 1))); ?>

                                            </div>
                                            <span><?php echo e($conversation->user->name); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($conversation->admin): ?>
                                            <span class="badge bg-primary"><?php echo e($conversation->admin->name); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Not Assigned</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($conversation->status === 'open' ? 'success' : ($conversation->status === 'pending' ? 'warning' : 'danger')); ?>">
                                            <i class="fas fa-<?php echo e($conversation->status === 'open' ? 'check-circle' : ($conversation->status === 'pending' ? 'clock' : 'ban')); ?>"></i>
                                            <?php echo e(ucfirst($conversation->status)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?php echo e($conversation->priority === 'high' ? 'danger' : ($conversation->priority === 'medium' ? 'warning' : 'info')); ?>">
                                            <i class="fas fa-<?php echo e($conversation->priority === 'high' ? 'fire' : ($conversation->priority === 'medium' ? 'exclamation' : 'info-circle')); ?>"></i>
                                            <?php echo e(ucfirst($conversation->priority)); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <?php if($conversation->unreadCount() > 0): ?>
                                            <span class="badge bg-danger" title="Unread messages">
                                                <?php echo e($conversation->unreadCount()); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted text-center">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e($conversation->updated_at->diffForHumans()); ?>

                                        </small>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.messages.show', $conversation)); ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <?php if($conversations->hasPages()): ?>
                <div class="mt-4 d-flex justify-content-center">
                    <?php echo e($conversations->links('pagination::bootstrap-5')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="row">
        <div class="col-12">
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc;"></i>
                    <h5 class="mt-3 text-muted">No conversations yet</h5>
                    <p class="text-muted">Customers will see their support conversations here.</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<style>
    .table-active {
        background-color: #fff3cd !important;
    }

    .badge {
        font-size: 0.85rem;
        padding: 0.35rem 0.65rem;
    }

    .avatar-sm {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .btn-sm {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/messages/admin-conversations.blade.php ENDPATH**/ ?>