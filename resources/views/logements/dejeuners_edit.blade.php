@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dashboard Menu
        </div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Gestion des petits déjeuners</span>
                </div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->

            <!-- dashboard-content-wrap -->
            <div class="dashboard-content-wrap">
                <!-- Titre widget -->
                <div class="dasboard-widget-title fl-wrap" id="sec1">
                    <h5 class="page-title">
                        <i class="fas fa-tools"></i>
                        Gestion des petits déjeuners
                    </h5>
                    <span class="property-title">
                        Logement : <strong>{{ $logement->titre ?? ($logement->nom ?? "Logement #{$logement->id}") }}</strong>
                    </span>
                </div>

                <div class="dashboard-list-box fl-wrap">

                    <form action="{{ route('hoost.logements.dejeuners.update', $logement->id) }}" method="POST"
                        class="custom-form">
                        @csrf
                        @method('PUT')

                        <!-- Bloc "Tout sélectionner" + bouton -->
                        <div class="select-all-container">
                            <div class="select-all-left">
                                <label class="select-all-label" for="selectAllEquipments">
                                    <input class="select-all-checkbox" type="checkbox" id="selectAllEquipments">

                                    <span class="select-all-text">
                                        <i class="fas fa-check-double me-2"></i>
                                        Tout sélectionner
                                    </span>
                                </label>
                            </div>

                            <button type="submit" class="btn color-bg float-btn save-btn" style="margin-top:-15px;">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>

                        <!-- Grille des équipements -->
                        <div class="equipments-grid">
                            @forelse($dejeuners as $dejeuner)
                                <div class="equipment-card">
                                    <input class="equipment-checkbox" type="checkbox" name="dejeuners[]"
                                        value="{{ $dejeuner->id }}" id="equipment-{{ $dejeuner->id }}"
                                        {{ in_array($dejeuner->id, $selected) ? 'checked' : '' }}>

                                    {{-- <div class="equipment-icon">
                                    <i class="fas {{ $dejeuner->icon ?? 'fa-check' }}"></i>
                                </div> --}}

                                    <label class="equipment-label" for="equipment-{{ $dejeuner->id }}">
                                        {{ $dejeuner->libelle }}
                                    </label>
                                </div>
                            @empty
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Aucun petit déjeuner disponible pour le moment.
                                </div>
                            @endforelse
                        </div>


                    </form>
                </div>
            </div>
            <!-- dashboard-content-wrap end -->
        </div>
        <!-- content end -->
    </div>
    <!-- dashboard content end -->



    

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAllEquipments');
            const equipmentCheckboxes = document.querySelectorAll('.equipment-checkbox');

            function updateSelectAllCheckbox() {
                if (!selectAllCheckbox) return;
                const allChecked = Array.from(equipmentCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(equipmentCheckboxes).some(cb => cb.checked);

                if (allChecked) {
                    selectAllCheckbox.checked = true;
                    selectAllCheckbox.indeterminate = false;
                } else if (someChecked) {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = true;
                } else {
                    selectAllCheckbox.checked = false;
                    selectAllCheckbox.indeterminate = false;
                }
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const isChecked = this.checked;
                    equipmentCheckboxes.forEach(cb => cb.checked = isChecked);
                });
            }

            equipmentCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateSelectAllCheckbox);
            });

            updateSelectAllCheckbox();
        });
    </script>
@endsection
