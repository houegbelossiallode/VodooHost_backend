@extends('layouts.app')

<style>
    /* Styles pour les cartes de divinités */
    .divinite-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #dee2e6;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .divinite-card:hover {
        border-color: #adb5bd;
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .divinite-card.border-primary {
        border-color: #4e54c8 !important;
        background-color: rgba(78, 84, 200, 0.05);
    }
    
    .divinite-checkbox input[type="checkbox"]:checked + label .card,
    .form-check-card input[type="radio"]:checked + label .card {
        border-color: #4e54c8;
        background-color: #f8f9ff;
    }
    
    /* Style pour les cartes de sélection */
    .form-check-card {
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-check-input {
        position: absolute;
        opacity: 0;
    }
    
    .form-check-label {
        cursor: pointer;
        width: 100%;
    }
    
    .form-check-card .card {
        transition: all 0.3s ease;
        border: 2px solid #dee2e6;
    }
    
    .form-check-card .card:hover {
        border-color: #adb5bd;
    }
    
    .form-check-card .card-body {
        padding: 1.5rem;
    }
    
    /* Style pour les indicateurs d'étapes */
    .step-indicator {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        position: relative;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 1;
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-bottom: 0.5rem;
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .step.active .step-number {
        background-color: #4e54c8;
        color: white;
        border-color: #4e54c8;
    }
    
    .step-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .step.active .step-label {
        color: #4e54c8;
        font-weight: 600;
    }
    
    .step-line {
        flex: 1;
        height: 2px;
        background-color: #dee2e6;
        margin: 0 10px;
        position: relative;
    }
    
    /* Style pour les boutons de navigation */
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #dee2e6;
    }
    
    .btn-outline-secondary:hover {
        background-color: #f8f9fa;
        border-color: #adb5bd;
    }
    
    /* Style pour les messages d'erreur */
    .alert-danger {
        background-color: #fff5f5;
        border-color: #f5c6cb;
        color: #721c24;
    }
    
    /* Style pour les icônes */
    .icon-wrapper {
        background-color: rgba(78, 84, 200, 0.1);
    }
    
    /* Responsive */
    @media (max-width: 767.98px) {
        .divinite-card {
            margin-bottom: 1rem;
        }
        
        .btn-lg {
            width: 100%;
            margin-bottom: 0.5rem;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
        }
        
        .btn-outline-secondary, .btn-primary, .btn-success {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>

@section('section')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
                <!-- En-tête avec image de fond -->
                <div class="card-header bg-primary text-white py-4 position-relative" style="background: linear-gradient(135deg, #4e54c8, #8f94fb);">
                    <div class="position-absolute w-100 h-100 bg-dark opacity-25" style="top: 0; left: 0;"></div>
                    <div class="position-relative text-center">
                        <h1 class="h3 mb-2">Modifier mes préférences</h1>
                        <p class="mb-0">Personnalisez votre expérience selon vos centres d'intérêt</p>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    <form id="preferencesForm" action="{{ route('hoost.preferences.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Barre de progression -->
                        <div class="progress rounded-0" style="height: 6px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="p-4 p-md-5">
                            <!-- Étapes du formulaire -->
                            <div class="step-indicator mb-5 text-center">
                                <div class="step active" data-step="1">
                                    <div class="step-number">1</div>
                                    <div class="step-label d-none d-md-block">Divinités</div>
                                </div>
                                <div class="step-line"></div>
                                <div class="step" data-step="2">
                                    <div class="step-number">2</div>
                                    <div class="step-label d-none d-md-block">Rituels</div>
                                </div>
                                <div class="step-line"></div>
                                <div class="step" data-step="3">
                                    <div class="step-number">3</div>
                                    <div class="step-label d-none d-md-block">Niveau</div>
                                </div>
                                <div class="step-line"></div>
                                <div class="step" data-step="4">
                                    <div class="step-number">4</div>
                                    <div class="step-label d-none d-md-block">Préférences</div>
                                </div>
                            </div>
                            
                            <!-- Étape 1: Divinités -->
                            <div class="question-step" data-step="1">
                                <div class="text-center mb-5">
                                    <div class="icon-wrapper d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-4" style="width: 80px; height: 80px;">
                                        <i class="fas fa-star text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h2 class="h3 mb-3">Vos Divinités Préférées</h2>
                                    <p class="text-muted">Sélectionnez jusqu'à 3 divinités qui vous intéressent le plus</p>
                                    <div class="selection-counter badge bg-primary-soft text-primary mt-2">
                                        <span id="selectedCount">0</span>/3 sélectionnés
                                    </div>
                                </div>
                                
                                <div class="row g-4">
                                    @php
                                        // Récupération des divinités sélectionnées
                                        $selectedDivinites = old('divinites_preferees', $preferences ? (is_array($preferences->divinites_preferees) ? $preferences->divinites_preferees : json_decode($preferences->divinites_preferees, true) ?? []) : []);
                                        $selectedDivinites = array_map('intval', (array)$selectedDivinites);
                                    @endphp
                                    
                                    @foreach($divinites as $divinite)
                                    @php
                                        $isSelected = in_array((int)$divinite->id, $selectedDivinites, true);
                                    @endphp
                                    <div class="col-md-4 mb-4">
                                        <div class="divinite-checkbox h-100">
                                            <input type="checkbox" 
                                                   name="divinites_preferees[]" 
                                                   value="{{ $divinite->id }}" 
                                                   id="divinite-{{ $divinite->id }}" 
                                                   class="d-none"
                                                   {{ $isSelected ? 'checked' : '' }}>
                                            <label for="divinite-{{ $divinite->id }}" 
                                                   class="divinite-card card h-100 border-2 {{ $isSelected ? 'border-primary bg-primary-light' : 'border-light' }}"
                                                   style="cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body text-center d-flex flex-column p-4">
                                                    <div class="icon-wrapper d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-3 mx-auto" 
                                                         style="width: 70px; height: 70px;">
                                                        <i class="{{ $divinite->icone ?? 'fas fa-question' }} text-primary" style="font-size: 1.75rem;"></i>
                                                    </div>
                                                    <h5 class="card-title mb-2">{{ $divinite->nom }}</h5>
                                                    <p class="text-muted small mb-3">{{ $divinite->domaine ?? 'Domaine non spécifié' }}</p>
                                                
                                                    <div class="mt-auto">
                                                        <span class="badge {{ $isSelected ? 'bg-primary text-white' : 'bg-light text-primary border' }} px-3 py-2" 
                                                              style="font-size: 0.9rem; font-weight: 500; min-width: 120px;">
                                                            <i class="fas {{ $isSelected ? 'fa-check' : 'fa-plus' }} me-1"></i>
                                                            {{ $isSelected ? 'Sélectionné' : 'Sélectionner' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                @error('divinites_preferees')
                                    <div class="alert alert-danger mt-3">
                                        <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                    </div>
                                @enderror
                                
                                <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                    <button type="button" class="btn btn-outline-secondary btn-lg px-4 prev-step" disabled>
                                        <i class="fas fa-arrow-left me-2"></i> Précédent
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg px-5 next-step" data-next="2">
                                        Suivant <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Étape 2: Participation aux rituels -->
                            <div class="question-step d-none" data-step="2">
                                <div class="text-center mb-5">
                                    <div class="icon-wrapper d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-4" style="width: 80px; height: 80px;">
                                        <i class="fas fa-hands-praying text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h3 class="h4 mb-3">Participation aux Rituels</h3>
                                    <p class="text-muted">Souhaitez-vous participer à des rituels ?</p>
                                </div>
                                
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="d-grid gap-3">
                                            <div class="form-check-card">
                                                <input class="form-check-input" type="radio" name="assister_rituel" id="assister_oui" value="1" 
                                                    {{ old('assister_rituel', $preferences ? $preferences->assister_rituel : '') == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label w-100" for="assister_oui">
                                                    <div class="card border-2 h-100">
                                                        <div class="card-body text-center p-4">
                                                            <i class="fas fa-check-circle text-success mb-3" style="font-size: 2rem;"></i>
                                                            <h5 class="card-title">Oui, je souhaite participer</h5>
                                                            <p class="text-muted mb-0">Je veux être informé des prochains rituels et y participer activement.</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                            
                                            <div class="form-check-card">
                                                <input class="form-check-input" type="radio" name="assister_rituel" id="assister_non" value="0" 
                                                    {{ old('assister_rituel', $preferences ? $preferences->assister_rituel : '') == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label w-100" for="assister_non">
                                                    <div class="card border-2 h-100">
                                                        <div class="card-body text-center p-4">
                                                            <i class="fas fa-times-circle text-muted mb-3" style="font-size: 2rem;"></i>
                                                            <h5 class="card-title">Non, pas pour l'instant</h5>
                                                            <p class="text-muted mb-0">Je préfère me renseigner d'abord avant de participer à des rituels.</p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('assister_rituel')
                                    <div class="alert alert-danger mt-3">
                                        <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                    </div>
                                @enderror
                                
                                <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                    <button type="button" class="btn btn-outline-secondary btn-lg px-4 prev-step" data-prev="1">
                                        <i class="fas fa-arrow-left me-2"></i> Précédent
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg px-5 next-step" data-next="3">
                                        Suivant <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Étape 3: Niveau d'immersion -->
                            <div class="question-step d-none" data-step="3">
                                <div class="text-center mb-5">
                                    <div class="icon-wrapper d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-4" style="width: 80px; height: 80px;">
                                        <i class="fas fa-layer-group text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h3 class="h4 mb-3">Niveau d'Immersion</h3>
                                    <p class="text-muted">Quel est votre niveau de connaissance actuel ?</p>
                                </div>
                                
                                <div class="row g-4">
                                    @php
                                        $niveaux = [
                                            'découverte' => [
                                                'icon' => 'compass',
                                                'title' => 'Débutant',
                                                'desc' => 'Je découvre le vaudou et souhaite en apprendre les bases.'
                                            ],
                                            'intermédiaire' => [
                                                'icon' => 'book',
                                                'title' => 'Intermédiaire',
                                                'desc' => 'J\'ai quelques connaissances de base sur le vaudou.'
                                            ],
                                            'avancé' => [
                                                'icon' => 'graduation-cap',
                                                'title' => 'Avancé',
                                                'desc' => 'Je pratique le vaudou et souhaite approfondir mes connaissances.'
                                            ],
                                            'complet' => [
                                                'icon' => 'star',
                                                'title' => 'Expert',
                                                'desc' => 'Je suis très expérimenté et cherche des connaissances avancées.'
                                            ]
                                        ];
                                        $currentLevel = old('niveau_immersion', $preferences ? $preferences->niveau_immersion : '');
                                    @endphp
                                    
                                    @foreach($niveaux as $value => $niveau)
                                    <div class="col-md-6">
                                        <div class="form-check-card">
                                            <input class="form-check-input" type="radio" name="niveau_immersion" id="niveau_{{ $value }}" value="{{ $value }}"
                                                {{ $currentLevel === $value ? 'checked' : '' }}>
                                            <label class="form-check-label w-100" for="niveau_{{ $value }}">
                                                <div class="card border-2 h-100">
                                                    <div class="card-body p-4">
                                                        <div class="d-flex align-items-start">
                                                            <div class="icon-wrapper d-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle me-4" style="min-width: 50px; height: 50px;">
                                                                <i class="fas fa-{{ $niveau['icon'] }} text-primary"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="card-title mb-1">{{ $niveau['title'] }}</h5>
                                                                <p class="text-muted mb-0">{{ $niveau['desc'] }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                @error('niveau_immersion')
                                    <div class="alert alert-danger mt-3">
                                        <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                    </div>
                                @enderror
                                
                                <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                    <button type="button" class="btn btn-outline-secondary btn-lg px-4 prev-step" data-prev="2">
                                        <i class="fas fa-arrow-left me-2"></i> Précédent
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg px-5 next-step" data-next="4">
                                        Suivant <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Étape 4: Préférences supplémentaires -->
                            <div class="question-step d-none" data-step="4">
                                <div class="text-center mb-5">
                                    <div class="icon-wrapper d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 rounded-circle mb-4" style="width: 80px; height: 80px;">
                                        <i class="fas fa-ellipsis-h text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h3 class="h4 mb-3">Préférences Supplémentaires</h3>
                                    <p class="text-muted">Avez-vous d'autres préférences ou besoins particuliers ?</p>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="preferences_supplementaires" class="form-label">Vos commentaires (facultatif)</label>
                                    @php
                                        $prefsSupplementaires = old('preferences_supplementaires', $preferences ? $preferences->preferences_supplementaires : '');
                                        if (is_array($prefsSupplementaires)) {
                                            $prefsSupplementaires = json_encode($prefsSupplementaires, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                                        }
                                    @endphp
                                    <textarea class="form-control" id="preferences_supplementaires" name="preferences_supplementaires" rows="4" 
                                        placeholder="Ex: J'aimerais en savoir plus sur les rituels de guérison...">{{ $prefsSupplementaires }}</textarea>
                                    <div class="form-text">Ces informations nous aideront à personnaliser davantage votre expérience.</div>
                                    
                                    @error('preferences_supplementaires')
                                        <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                                    <button type="button" class="btn btn-outline-secondary btn-lg px-4 prev-step" data-prev="3">
                                        <i class="fas fa-arrow-left me-2"></i> Précédent
                                    </button>
                                    <button type="submit" class="btn btn-success btn-lg px-5">
                                        <i class="fas fa-save me-2"></i> Enregistrer les modifications
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="text-center mt-4 p-4 bg-light">
                    <p class="text-muted small mb-0">
                        <i class="fas fa-lock me-1"></i> Vos données sont sécurisées et ne seront jamais partagées sans votre consentement.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    // Initialisation des étapes
    let currentStep = 1;
    const totalSteps = 4;
    
    // Afficher la première étape
    showStep(currentStep);
    
    // Mise à jour du compteur de divinités sélectionnées
    function updateSelectedCount() {
        const count = $('input[name="divinites_preferees[]"]:checked').length;
        $('#selectedCount').text(count);
        
        // Mettre à jour la classe du badge du compteur
        const counterBadge = $('.selection-counter');
        counterBadge.removeClass('bg-primary-soft bg-warning-soft bg-success-soft');
        
        if (count === 0) {
            counterBadge.addClass('bg-warning-soft').removeClass('text-primary').addClass('text-warning');
        } else if (count < 3) {
            counterBadge.addClass('bg-primary-soft').removeClass('text-warning').addClass('text-primary');
        } else {
            counterBadge.addClass('bg-success-soft').removeClass('text-primary').addClass('text-success');
        }
    }
    
    // Fonction pour mettre à jour l'apparence d'une carte de divinité
    function updateDiviniteCard(card) {
        const checkbox = card.find('input[type="checkbox"]');
        const badge = card.find('.badge');
        
        if (checkbox.is(':checked')) {
            card.addClass('border-primary bg-primary-light');
            badge
                .removeClass('bg-light text-primary')
                .addClass('bg-primary text-white')
                .html('<i class="fas fa-check me-1"></i> Sélectionné');
        } else {
            card.removeClass('border-primary bg-primary-light');
            badge
                .addClass('bg-light text-primary')
                .removeClass('bg-primary text-white')
                .html('<i class="fas fa-plus me-1"></i> Sélectionner');
        }
    }
    
    // Gestion de la sélection des divinités
    $('.divinite-card').on('click', function(e) {
        e.preventDefault();
        const card = $(this);
        const checkbox = card.find('input[type="checkbox"]');
        const isChecked = checkbox.prop('checked');
        
        // Vérifier si on peut cocher une nouvelle case (max 3)
        if (!isChecked && $('input[name="divinites_preferees[]"]:checked').length >= 3) {
            alert('Vous ne pouvez sélectionner que 3 divinités maximum.');
            return false;
        }
        
        // Basculer l'état de la case à cocher
        checkbox.prop('checked', !isChecked);
        
        // Mettre à jour le style de la carte
        updateDiviniteCard(card);
        
        // Mettre à jour le compteur
        updateSelectedCount();
    });
    
    // Initialiser les cartes de divinités au chargement de la page
    $('.divinite-card').each(function() {
        updateDiviniteCard($(this));
    });
    
    // Initialiser le compteur au chargement de la page
    updateSelectedCount();
    
    // Gestion de la sélection des cartes de niveau d'immersion
    $('.form-check-card input[type="radio"]').on('change', function() {
        const card = $(this).closest('.form-check-card');
        $('.form-check-card').removeClass('border-primary bg-primary-light');
        
        if ($(this).is(':checked')) {
            card.addClass('border-primary bg-primary-light');
        }
    });
    
    // Initialiser l'état des cartes de niveau d'immersion
    $('.form-check-card input[type="radio"]:checked').each(function() {
        $(this).closest('.form-check-card').addClass('border-primary bg-primary-light');
    });
    
    // Animation au survol des cartes
    $('.divinite-card, .form-check-card').hover(
        function() {
            if (!$(this).hasClass('border-primary')) {
                $(this).css('transform', 'translateY(-5px)');
            }
            $(this).css('box-shadow', '0 0.5rem 1rem rgba(0, 0, 0, 0.15)');
        },
        function() {
            if (!$(this).find('input[type="checkbox"]').is(':checked') && !$(this).find('input[type="radio"]').is(':checked')) {
                $(this).css('transform', 'translateY(0)');
            }
            $(this).css('box-shadow', '0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)');
        }
    );
    
    // Gestion de la navigation entre les étapes
    $('.next-step').on('click', function() {
        if (validateStep(currentStep)) {
            currentStep++;
            showStep(currentStep);
        }
    });
    
    $('.prev-step').on('click', function() {
        currentStep--;
        showStep(currentStep);
    });
    
    // Fonction pour afficher une étape spécifique
    function showStep(step) {
        // Masquer toutes les étapes
        $('.question-step').addClass('d-none');
        
        // Afficher l'étape courante
        $(`.question-step[data-step="${step}"]`).removeClass('d-none');
        
        // Mettre à jour la barre de progression
        updateProgressBar(step);
        
        // Mettre à jour les boutons de navigation
        updateNavigationButtons(step);
    }
    
    // Fonction pour valider l'étape courante
    function validateStep(step) {
        let isValid = true;
        
        switch(step) {
            case 1:
                // Validation des divinités sélectionnées
                const selectedDivinites = $('input[name="divinites_preferees[]"]:checked').length;
                if (selectedDivinites === 0) {
                    alert('Veuillez sélectionner au moins une divinité.');
                    isValid = false;
                }
                break;
                
            case 2:
                // Validation de la participation aux rituels
                if (!$('input[name="assister_rituel"]:checked').length) {
                    alert('Veuillez indiquer si vous souhaitez participer à des rituels.');
                    isValid = false;
                }
                break;
                
            case 3:
                // Validation du niveau d'immersion
                if (!$('input[name="niveau_immersion"]:checked').length) {
                    alert('Veuillez sélectionner votre niveau d\'immersion.');
                    isValid = false;
                }
                break;
        }
        
        return isValid;
    }
    
    // Fonction pour mettre à jour la barre de progression
    function updateProgressBar(step) {
        const progressPercentage = ((step - 1) / (totalSteps - 1)) * 100;
        $('.progress-bar').css('width', `${progressPercentage}%`).attr('aria-valuenow', progressPercentage);
        
        // Mettre à jour les indicateurs d'étapes
        $('.step').removeClass('active');
        $(`.step[data-step="${step}"]`).addClass('active');
    }
    
    // Fonction pour mettre à jour les boutons de navigation
    function updateNavigationButtons(step) {
        // Cacher tous les boutons par défaut
        $('.prev-step, .next-step, .submit-btn').addClass('d-none');
        
        if (step > 1) {
            $('.prev-step').removeClass('d-none');
        }
        
        if (step < totalSteps) {
            $('.next-step').removeClass('d-none');
        } else {
            $('.submit-btn').removeClass('d-none');
        }
    }
    
    // Soumission du formulaire
    $('#preferencesForm').on('submit', function(e) {
        if (!validateStep(currentStep)) {
            e.preventDefault();
            return false;
        }
        return true;
    });
});
</script>
