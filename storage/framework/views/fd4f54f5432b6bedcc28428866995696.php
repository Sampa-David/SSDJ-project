

<?php $__env->startSection('title', 'Delete Users - Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h3 class="mb-0">
                        <i class="bi bi-trash me-2"></i>Delete Users
                    </h3>
                </div>
                <div class="card-body">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Filters -->
                    <div class="card mb-4 bg-light">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filtres de recherche</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="<?php echo e(route('admin.users.delete')); ?>" class="row g-3">
                                <div class="col-md-4">
                                    <label for="search_name" class="form-label">Nom</label>
                                    <input 
                                        type="text" 
                                        id="search_name" 
                                        name="search_name" 
                                        class="form-control" 
                                        placeholder="Rechercher par nom..."
                                        value="<?php echo e(request('search_name')); ?>"
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="search_email" class="form-label">Email</label>
                                    <input 
                                        type="email" 
                                        id="search_email" 
                                        name="search_email" 
                                        class="form-control" 
                                        placeholder="Rechercher par email..."
                                        value="<?php echo e(request('search_email')); ?>"
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="date_from" class="form-label">Date d'inscription (De)</label>
                                    <input 
                                        type="date" 
                                        id="date_from" 
                                        name="date_from" 
                                        class="form-control"
                                        value="<?php echo e(request('date_from')); ?>"
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="date_to" class="form-label">Date d'inscription (À)</label>
                                    <input 
                                        type="date" 
                                        id="date_to" 
                                        name="date_to" 
                                        class="form-control"
                                        value="<?php echo e(request('date_to')); ?>"
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="time_from" class="form-label">Heure (De)</label>
                                    <input 
                                        type="time" 
                                        id="time_from" 
                                        name="time_from" 
                                        class="form-control"
                                        value="<?php echo e(request('time_from')); ?>"
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="time_to" class="form-label">Heure (À)</label>
                                    <input 
                                        type="time" 
                                        id="time_to" 
                                        name="time_to" 
                                        class="form-control"
                                        value="<?php echo e(request('time_to')); ?>"
                                    >
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search me-2"></i>Filtrer
                                    </button>
                                    <a href="<?php echo e(route('admin.users.delete')); ?>" class="btn btn-secondary">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 50px;">
                                        <input type="checkbox" id="select_all" class="form-check-input">
                                    </th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Date d'inscription</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input user-checkbox" value="<?php echo e($user->id); ?>" data-user-name="<?php echo e($user->name); ?>">
                                        </td>
                                        <td>
                                            <strong><?php echo e($user->name); ?></strong>
                                        </td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo e($user->created_at->format('d/m/Y H:i')); ?>

                                            </small>
                                        </td>
                                        <td>
                                            <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                            <p>Aucun utilisateur trouvé</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <small class="text-muted">
                                Total: <strong><?php echo e($users->total()); ?></strong> utilisateurs
                            </small>
                        </div>
                        <div>
                            <?php echo e($users->appends(request()->query())->links('pagination::bootstrap-5')); ?>

                        </div>
                    </div>

                    <!-- Bulk Delete Section -->
                    <?php if($users->count() > 0): ?>
                        <div class="card mt-4 border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Suppression en masse
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">
                                    Sélectionnez les utilisateurs à supprimer ci-dessus, puis cliquez sur le bouton ci-dessous.
                                </p>
                                <form action="<?php echo e(route('admin.users.bulk-delete')); ?>" method="POST" onsubmit="return confirmBulkDelete();">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" id="selected_users" name="user_ids" value="">
                                    <button type="submit" class="btn btn-danger btn-lg" id="bulk_delete_btn" disabled>
                                        <i class="bi bi-trash-fill me-2"></i>Supprimer les utilisateurs sélectionnés
                                    </button>
                                    <span id="selected_count" class="ms-3 text-danger" style="display: none;">
                                        <strong><span id="count"></span> utilisateur(s) sélectionné(s)</strong>
                                    </span>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .user-checkbox:checked {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>

<script>
    const checkboxes = document.querySelectorAll('.user-checkbox');
    const selectAllCheckbox = document.getElementById('select_all');
    const selectedUsersInput = document.getElementById('selected_users');
    const bulkDeleteBtn = document.getElementById('bulk_delete_btn');
    const selectedCount = document.getElementById('selected_count');
    const countSpan = document.getElementById('count');

    function updateSelection() {
        const selectedIds = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        selectedUsersInput.value = JSON.stringify(selectedIds);
        
        if (selectedIds.length > 0) {
            bulkDeleteBtn.disabled = false;
            selectedCount.style.display = 'inline';
            countSpan.textContent = selectedIds.length;
        } else {
            bulkDeleteBtn.disabled = true;
            selectedCount.style.display = 'none';
        }
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelection);
    });

    selectAllCheckbox.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelection();
    });

    function confirmBulkDelete() {
        const count = Array.from(checkboxes).filter(cb => cb.checked).length;
        return confirm(`Êtes-vous sûr de vouloir supprimer ${count} utilisateur(s)? Cette action est irréversible.`);
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH S:\php(Laravel)\S²DJ\resources\views/admin/users-delete.blade.php ENDPATH**/ ?>