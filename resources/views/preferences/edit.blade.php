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
                    <span>Expérience culturelle personnalisée</span>
                </div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->

            <!-- dashboard-content-wrap -->
            <div class="dashboard-content-wrap">
                <!-- Titre widget -->
                <div class="dasboard-widget-title fl-wrap" id="sec1">
                    <h5 class="page-title">
                        <i class="fas fa-magic"></i>
                        Modifier mon expérience culturelle
                    </h5>
                    <span class="property-title">
                        Profil : <strong>{{ $user->nom ?? 'Visiteur' }}</strong>
                    </span>
                </div>

                <div class="dashboard-list-box fl-wrap">

                    <form action="{{ route('hoost.preferences.update') }}" method="POST" class="custom-form">
                        @csrf
                        @method('PUT')
                        <!-- Bloc "Tout sélectionner" + bouton -->
                        <div class="select-all-container">
                            <div class="select-all-left">
                                <input class="select-all-checkbox" type="checkbox" id="selectAllDivinites">
                                <label class="select-all-label" for="selectAllDivinites">
                                    <i class="fas fa-check-double me-2"></i>Tout sélectionner les divinités
                                </label>
                            </div>

                            <button type="submit" class="btn color-bg float-btn save-btn" style="margin-top:-15px;">
                                <i class="fas fa-save me-2"></i>Mettre à jour mes préférences
                            </button>
                        </div>

                        @php
                            // $divinites : collection de divinités (id, nom, image, etc.)
                            // $selected  : array des id déjà choisis (envoyé par le controller)
                            $selected = (array) ($selected ?? []);
                        @endphp

                        <!-- Grille des divinités -->
                        <div class="equipments-grid">
                            @forelse($divinites as $divinite)
                                @php
                                    $isChecked = in_array($divinite->id, $selected);
                                @endphp

                                <div class="equipment-card {{ $isChecked ? 'active' : '' }}">
                                    <div class="rituel-icon">
                                        <img src="{{ $divinite->image }}" alt="{{ $divinite->nom }}"
                                             class="rituel-symbole-img" loading="lazy">
                                    </div>

                                    <label class="equipment-label" for="divinite-{{ $divinite->id }}">
                                        {{ $divinite->nom }}
                                    </label>

                                    <input class="equipment-checkbox"
                                           type="checkbox"
                                           name="divinites[]"
                                           value="{{ $divinite->id }}"
                                           id="divinite-{{ $divinite->id }}"
                                           {{ $isChecked ? 'checked' : '' }}>
                                </div>
                            @empty
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Aucune divinité disponible pour le moment.
                                </div>
                            @endforelse
                        </div>

                        <!-- Question : rituel en direct -->
                        <div class="mt-2">
                            <label>
                                Souhaitez-vous assister à un rituel en direct ?
                            </label>

                            @php
                                // $wantLive envoyé par le controller : true/false ou null
                                // On force une valeur par défaut si null
                                $wantLive = !is_null($wantLive) ? (bool) $wantLive : true;
                            @endphp

                            <div class="add-list-media-header">
                                <label class="radio inline">
                                    <input type="radio" name="assister_rituel" value="1" {{ $wantLive ? 'checked' : '' }}>
                                    <span>OUI</span>
                                </label>
                            </div>
                            <div class="add-list-media-header">
                                <label class="radio inline">
                                    <input type="radio" name="assister_rituel" value="0" {{ !$wantLive ? 'checked' : '' }}>
                                    <span>NON</span>
                                </label>
                            </div>

                            
                        </div>

                    </form>
                </div>
            </div>
            <!-- dashboard-content-wrap end -->
        </div>
        <!-- content end -->
    </div>



 <style>
        .page-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .page-title i {
            margin-right: 0.75rem;
            color: var(--primary);
        }

        .property-title {
            display: inline-block;
            color: var(--primary);
            font-weight: 600;
            margin-top: 0.25rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid #f0f2f5;
        }

        /* Bloc "Tout sélectionner" */
        .select-all-container {
            background: #f8f9fa;
            padding: 0.9rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e1e8ed;
            gap: 1rem;
        }

        .select-all-left {
            display: flex;
            align-items: center;
        }

        .select-all-checkbox {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            cursor: pointer;
        }

        .select-all-label {
            font-weight: 600;
            color: #333;
            margin: 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .save-btn {
            border-radius: 30px;
            padding: 0.6rem 1.6rem;
            font-weight: 500;
            border: none;
        }

        /* Grille d’équipements (divinités ici) */
        .equipments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }

        @media (max-width: 768px) {
            .equipments-grid {
                grid-template-columns: 1fr;
            }

            .select-all-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .save-btn {
                align-self: stretch;
                text-align: center;
                width: 100%;
            }
        }

        /* Carte divinité */
        .equipment-card {
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 0.9rem 1rem;
            background: #fff;
            display: flex;
            align-items: center;
            transition: all 0.25s ease;
        }

        .equipment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
            border-color: var(--primary);
        }

        .equipment-card.active {
            background: #f4f7ff;
            border-color: #D1B11B;
        }

        .equipment-checkbox {
            width: 20px;
            height: 20px;
            margin-left: 0.9rem;
            cursor: pointer;
            flex-shrink: 0;
        }

        .equipment-label {
            font-size: 0.98rem;
            font-weight: 500;
            color: #333;
            margin: 0;
            cursor: pointer;
            flex: 1;
        }

        .rituel-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            overflow: hidden;
            border: 2px solid #e9ecef;
            flex-shrink: 0;
        }

        .rituel-symbole-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .rituel-icon:hover .rituel-symbole-img {
            transform: scale(1.05);
        }

        /* Radios Oui / Non */
        .live-toggle-wrap {
            display: flex;
            gap: 0.6rem;
            margin-top: 0.5rem;
        }

        .radio-pill {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .radio-pill input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .radio-pill span {
            border-radius: 999px;
            border: 1px solid #e1e8ed;
            padding: 6px 14px;
            font-size: 0.9rem;
            font-weight: 500;
            color: #344357;
            background: #fff;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .radio-pill input:checked+span {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAllDivinites');
            const diviniteCheckboxes = document.querySelectorAll('.equipment-checkbox');
            const cards = document.querySelectorAll('.equipment-card');

            function updateSelectAllCheckbox() {
                if (!selectAllCheckbox) return;
                const allChecked = Array.from(diviniteCheckboxes).every(cb => cb.checked);
                const someChecked = Array.from(diviniteCheckboxes).some(cb => cb.checked);

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
                    diviniteCheckboxes.forEach(cb => {
                        cb.checked = isChecked;
                        const card = cb.closest('.equipment-card');
                        if (card) {
                            card.classList.toggle('active', isChecked);
                        }
                    });
                });
            }

            diviniteCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const card = cb.closest('.equipment-card');
                    if (card) {
                        card.classList.toggle('active', cb.checked);
                    }
                    updateSelectAllCheckbox();
                });
            });

            // État initial (si pré-sélection)
            diviniteCheckboxes.forEach(cb => {
                const card = cb.closest('.equipment-card');
                if (card && cb.checked) {
                    card.classList.add('active');
                }
            });

            updateSelectAllCheckbox();
        });
    </script>


@endsection
