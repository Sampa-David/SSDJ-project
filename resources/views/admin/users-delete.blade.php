@extends('layouts.admin')

@section('title', 'Delete Users - Admin')

@section('content')
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
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filters -->
                    <div class="card mb-4 bg-light">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filtres de recherche</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('admin.users.delete') }}" class="row g-3">
                                <div class="col-md-4">
                                    <label for="search_name" class="form-label">Nom</label>
                                    <input 
                                        type="text" 
                                        id="search_name" 
                                        name="search_name" 
                                        class="form-control" 
                                        placeholder="Rechercher par nom..."
                                        value="{{ request('search_name') }}"
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
                                        value="{{ request('search_email') }}"
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="date_from" class="form-label">Date d'inscription (De)</label>
                                    <input 
                                        type="date" 
                                        id="date_from" 
                                        name="date_from" 
                                        class="form-control"
                                        value="{{ request('date_from') }}"
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="date_to" class="form-label">Date d'inscription (À)</label>
                                    <input 
                                        type="date" 
                                        id="date_to" 
                                        name="date_to" 
                                        class="form-control"
                                        value="{{ request('date_to') }}"
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="time_from" class="form-label">Heure (De)</label>
                                    <input 
                                        type="time" 
                                        id="time_from" 
                                        name="time_from" 
                                        class="form-control"
                                        value="{{ request('time_from') }}"
                                    >
                                </div>

                                <div class="col-md-4">
                                    <label for="time_to" class="form-label">Heure (À)</label>
                                    <input 
                                        type="time" 
                                        id="time_to" 
                                        name="time_to" 
                                        class="form-control"
                                        value="{{ request('time_to') }}"
                                    >
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-search me-2"></i>Filtrer
                                    </button>
                                    <a href="{{ route('admin.users.delete') }}" class="btn btn-secondary">
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
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input user-checkbox" value="{{ $user->id }}" data-user-name="{{ $user->name }}">
                                        </td>
                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $user->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                            <p>Aucun utilisateur trouvé</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <small class="text-muted">
                                Total: <strong>{{ $users->total() }}</strong> utilisateurs
                            </small>
                        </div>
                        <div>
                            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                    <!-- Bulk Delete Section -->
                    @if($users->count() > 0)
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
                                <form action="{{ route('admin.users.bulk-delete') }}" method="POST" onsubmit="return confirmBulkDelete();">
                                    @csrf
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
                    @endif
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
@endsection
