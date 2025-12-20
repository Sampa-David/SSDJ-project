

<?php $__env->startSection('title', 'Users Management'); ?>
<?php $__env->startSection('page-title', 'Users Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header mb-4">
    <h2>Manage System Users</h2>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-users"></i> Users List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Company</th>
                        <th>Tickets</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><strong><?php echo e($user->name); ?></strong></td>
                        <td><?php echo e($user->email); ?></td>
                        <td><?php echo e($user->phone ?? '-'); ?></td>
                        <td><?php echo e($user->company ?? '-'); ?></td>
                        <td><span class="badge bg-info"><?php echo e($user->tickets_count); ?></span></td>
                        <td><?php echo e($user->created_at->format('M d, Y')); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.user', $user)); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php echo e($users->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/users.blade.php ENDPATH**/ ?>