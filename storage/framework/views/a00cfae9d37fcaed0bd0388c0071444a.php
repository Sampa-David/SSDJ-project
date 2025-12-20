

<?php $__env->startSection('title', $conversation->subject . ' - Messages'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-5" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-12">
                <a href="<?php echo e(route('messages.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Messages
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9">
                <!-- Conversation Header -->
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1"><?php echo e($conversation->subject); ?></h5>
                                <small class="text-muted">
                                    Started <?php echo e($conversation->created_at->diffForHumans()); ?> by <?php echo e($conversation->user->name); ?>

                                </small>
                            </div>
                            <div>
                                <span class="badge bg-<?php echo e($conversation->status === 'open' ? 'success' : ($conversation->status === 'pending' ? 'warning' : 'secondary')); ?>">
                                    <?php echo e(ucfirst($conversation->status)); ?>

                                </span>
                                <span class="badge bg-<?php echo e($conversation->priority === 'high' ? 'danger' : ($conversation->priority === 'medium' ? 'warning' : 'info')); ?>">
                                    <?php echo e(ucfirst($conversation->priority)); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages List -->
                <div class="card shadow-sm border-0 mb-3" style="min-height: 400px; max-height: 500px; overflow-y: auto;">
                    <div class="card-body">
                        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="mb-4">
                            <div class="d-flex gap-2">
                                <div class="flex-shrink-0">
                                    <div class="avatar-circle" style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                        <?php echo e(substr($message->sender->name, 0, 1)); ?>

                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1"><?php echo e($message->sender->name); ?></h6>
                                            <small class="text-muted"><?php echo e($message->created_at->diffForHumans()); ?></small>
                                        </div>
                                        <?php if($message->isUnread() && $message->sender_id !== Auth::id()): ?>
                                        <span class="badge bg-primary">New</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="bg-light p-3 rounded mt-2">
                                        <p class="mb-0"><?php echo e($message->body); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <!-- Reply Form -->
                <?php if($conversation->status === 'open'): ?>
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Reply</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo e(route('messages.reply', $conversation)); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <textarea class="form-control <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          name="body" rows="4" placeholder="Type your reply here..."
                                          required><?php echo e(old('body')); ?></textarea>
                                <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-send"></i> Send Reply
                            </button>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i> This conversation is closed. You can reopen it if you need further assistance.
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-3">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Status</small>
                            <p class="mb-0">
                                <span class="badge bg-<?php echo e($conversation->status === 'open' ? 'success' : ($conversation->status === 'pending' ? 'warning' : 'secondary')); ?>">
                                    <?php echo e(ucfirst($conversation->status)); ?>

                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Priority</small>
                            <p class="mb-0">
                                <span class="badge bg-<?php echo e($conversation->priority === 'high' ? 'danger' : ($conversation->priority === 'medium' ? 'warning' : 'info')); ?>">
                                    <?php echo e(ucfirst($conversation->priority)); ?>

                                </span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Assigned Admin</small>
                            <p class="mb-0">
                                <strong><?php echo e($conversation->admin?->name ?? 'Unassigned'); ?></strong>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Messages Count</small>
                            <p class="mb-0">
                                <strong><?php echo e($conversation->messages()->count()); ?></strong>
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Created</small>
                            <p class="mb-0"><?php echo e($conversation->created_at->format('M d, Y H:i')); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Actions</h6>
                    </div>
                    <div class="card-body">
                        <?php if($conversation->status === 'open'): ?>
                        <form method="POST" action="<?php echo e(route('messages.close', $conversation)); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-warning w-100 mb-2" onclick="return confirm('Close this conversation?')">
                                <i class="fas fa-times"></i> Close
                            </button>
                        </form>
                        <?php else: ?>
                        <form method="POST" action="<?php echo e(route('messages.reopen', $conversation)); ?>" style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-undo"></i> Reopen
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    font-size: 0.875rem;
}

/* Auto-scroll to bottom */
.card-body {
    display: flex;
    flex-direction: column;
}
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/messages/show.blade.php ENDPATH**/ ?>