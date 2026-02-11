@extends('layouts.app')

@section('section')
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
    <div class="container dasboard-container">
        <!-- Titre -->
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item"><span>Gestion des permissions - {{ $role->libelle }}</span></div>
            @include('partials/hearder2')
        </div>
        <!-- Titre end -->

        <div class="dasboard-wrapper fl-wrap">
           

            <div class="dasboard-widget-title fl-wrap" style="display:flex;justify-content:space-between;align-items:center;">
                <h5>Liste des permissions</h5>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="checkAll">
                    <label class="form-check-label" for="checkAll" style="font-weight: 600;">Tout sélectionner</label>
                </div>
            </div>

            <div class="dasboard-widget-box fl-wrap">
                <form action="{{ route('hoost.permissions.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Sous-menu</th>
                                    <th>URL</th>
                                    <th>Description</th>
                                    <th class="text-center">Accès</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                <tr class="permission-row">
                                    
                                    <td>
                                        <span class="badge color-bg">
                                            {{ $permission->sousmenu->menu->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $permission->sousmenu->name ?? 'N/A' }}</td>
                                    <td><code>{{ $permission->sousmenu->url ?? 'N/A' }}</code></td>
                                    <td class="small text-muted">{{ $permission->sousmenu->description ?? 'Aucune description' }}</td>
                                    <td class="text-center">
                                        <div class="form-check d-inline-block">
                                            <input type="checkbox"
                                                   name="permissions[{{ $permission->sousmenu_id }}]"
                                                   class="form-check-input permission-checkbox "
                                                   id="perm_{{ $permission->sousmenu_id }}"
                                                   value="1" {{ $permission->is_granted ? 'checked' : '' }}>
                                            <label class="form-check-label " for="perm_{{ $permission->sousmenu_id }}"></label>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fa fa-info-circle fa-2x mb-2 d-block"></i>
                                            Aucune permission trouvée
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn color-bg float-btn">
                                <i class="fas fa-save mr-1"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de la case "Tout sélectionner"
        const checkAll = document.getElementById('checkAll');
        const checkboxes = document.querySelectorAll('.permission-checkbox');

        checkAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkAll.checked;
            });
        });

        // Décocher "Tout sélectionner" si une case est décochée
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    checkAll.checked = false;
                } else {
                    // Vérifier si toutes les cases sont cochées
                    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                    checkAll.checked = allChecked;
                }
            });
        });

        // Vérifier l'état initial de "Tout sélectionner"
        const allCheckedInitially = Array.from(checkboxes).every(cb => cb.checked);
        checkAll.checked = allCheckedInitially;
    });
</script>

<style>
    .table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }

    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .table td, .table th {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
    }

    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.25rem;
    }

    code {
        color: #e83e8c;
        background-color: #f8f9fa;
        padding: 0.2em 0.4em;
        border-radius: 0.25rem;
        font-size: 90%;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.2em;
    }
</style>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du "Tout sélectionner"
    const checkAll = document.getElementById('checkAll');
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    const searchInput = document.getElementById('permSearch');
    const permissionRows = document.querySelectorAll('.permission-row');

    // Initialisation de la case "Tout sélectionner"
    if (checkAll && checkboxes.length > 0) {
        // Vérifier si toutes les cases sont cochées au chargement
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        checkAll.checked = allChecked;

        // Écouter les changements sur la case à cocher principale
        checkAll.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkAll.checked;
            });
        });

        // Mettre à jour la case à cocher principale lorsque les cases individuelles changent
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const allCheckedNow = Array.from(checkboxes).every(cb => cb.checked);
                checkAll.checked = allCheckedNow;
            });
        });
    }

    // Filtre de recherche
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.trim().toLowerCase();

            permissionRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const isVisible = text.includes(searchTerm);
                row.style.display = isVisible ? '' : 'none';

                // Ajout d'un effet visuel pour les résultats trouvés
                if (isVisible && searchTerm.length > 0) {
                    row.classList.add('highlight');
                    setTimeout(() => row.classList.remove('highlight'), 500);
                }
            });
        });
    }
});
</script>
<style>
.highlight {
    background-color: rgba(255, 255, 0, 0.2);
    transition: background-color 0.5s ease;
}
</style>

@endsection
