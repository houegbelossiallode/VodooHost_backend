@extends('layouts.app')

@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Tableau de bord
        </div>

        <div class="container dasboard-container">
            <!-- Titre dashboard -->
            <div class="dashboard-title fl-wrap">
                {{-- <div class="dashboard-title-item">
                    <span>Gestion des logements</span>
                </div> --}}
                @include('partials/hearder2')
            </div>
            <!-- Titre dashboard end -->

            @php
                $photos = $logement->photos ?? collect();
                $photoUrls = $photos->pluck('url')->all();
                $totalPhotos = count($photoUrls);
                $photoPrincipale = $photoUrls[0] ?? asset('images/default-house.jpg');
                $nbAvis = $logement->avis_count ?? 0;
                $note = $logement->note_moyenne ? round($logement->note_moyenne, 1) : 0;
                $host = $logement->user ?? null;
            @endphp

            <!-- Hero type Airbnb -->
            <div class="dasboard-widget-box fl-wrap vh-logement-hero">
                <div class="vh-logement-header">
                    <div class="vh-logement-title-block">
                        <h3 class="vh-logement-title">
                            {{ $logement->titre }}
                        </h3>
                        <div class="vh-logement-sub">
                            <span>
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $logement->adresse }}
                            </span>

                            @if ($logement->typelogement)
                                <span class="vh-pill">
                                    {{ $logement->typelogement->libelle }}
                                </span>
                            @endif

                            <span class="vh-pill-light">
                                {{ $logement->nb_voyageur_max }} voyageurs max.
                            </span>
                        </div>
                    </div>

                    <div class="vh-logement-rating-block">
                        {{-- @if ($nbAvis > 0)
                            <div class="vh-rating-line">
                                <i class="fas fa-star"></i>
                                <span>{{ $note }}/5</span>
                                <span class="vh-rating-count">({{ $nbAvis }} avis)</span>
                            </div>
                        @else
                            <div class="vh-rating-line vh-rating-empty">
                                <i class="fas fa-star"></i>
                                <span>Aucun avis pour le moment</span>
                            </div>
                        @endif --}}
                        {{-- <div class="vh-meta-small">
                            Mis à jour le {{ $logement->updated_at?->format('d/m/Y') }}
                            · {{ $logement->vues ?? 0 }} vues
                        </div> --}}
                    </div>
                </div>

                <!-- Hero images -->
                <div class="vh-hero-gallery">
                    <!-- Image principale cliquable -->
                    <div class="vh-hero-main">
                        <a href="#" class="vh-photo-trigger" data-index="0">
                            <img src="{{ $photoPrincipale }}" alt="Photo principale" class="vh-hero-main-img">
                        </a>
                    </div>

                    @if ($totalPhotos > 1)
                        <div class="vh-hero-thumbs">
                            @foreach ($photoUrls as $idx => $url)
                                @continue($idx === 0)
                                @break($idx > 4) {{-- au plus 4 vignettes --}}
                                <div class="vh-hero-thumb">
                                    <a href="#" class="vh-photo-trigger" data-index="{{ $idx }}">
                                        <img src="{{ $url }}" alt="Photo logement">
                                        @if ($idx === 4 && $totalPhotos > 5)
                                            <div class="vh-more-overlay">
                                                + {{ $totalPhotos - 5 }}
                                            </div>
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contenu type Airbnb -->
            <div class="dasboard-widget-box fl-wrap vh-logement-body">
                <div class="row">
                    <!-- Colonne gauche : contenu principal -->
                    <div class="col-md-8">
                        <!-- À propos -->
                        <div class="vh-section-block">
                            <h4 class="vh-section-title">À propos de ce logement</h4>
                            <p class="vh-section-text">
                                {{ $logement->description }}
                            </p>

                            <div class="vh-keyline"></div>

                            {{-- <div class="vh-keyfacts">
                                @if (!is_null($logement->nb_chambre))
                                    <div class="vh-keyfact-item">
                                        <i class="fal fa-bed"></i>
                                        <div>
                                            <div class="vh-keyfact-label">Chambres</div>
                                            <div class="vh-keyfact-value">{{ $logement->nb_chambre }} chambre(s)</div>
                                        </div>
                                    </div>
                                @endif

                                @if (!is_null($logement->nb_salle_bain ?? null))
                                    <div class="vh-keyfact-item">
                                        <i class="fal fa-bath"></i>
                                        <div>
                                            <div class="vh-keyfact-label">Salles de bain</div>
                                            <div class="vh-keyfact-value">{{ $logement->nb_salle_bain }}</div>
                                        </div>
                                    </div>
                                @endif

                                <div class="vh-keyfact-item">
                                    <i class="fal fa-users"></i>
                                    <div>
                                        <div class="vh-keyfact-label">Capacité</div>
                                        <div class="vh-keyfact-value">{{ $logement->nb_voyageur_max }} voyageurs</div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <!-- Ce que propose ce logement -->
                        @if (
                            ($logement->equipements && $logement->equipements->count()) ||
                                ($logement->rituels && $logement->rituels->count()) ||
                                ($logement->divinites && $logement->divinites->count()))
                            <div class="vh-section-block">
                                <h4 class="vh-section-title">Ce que propose ce logement</h4>

                                @if ($logement->dejeuners && $logement->dejeuners->count())
                                    <h5 class="vh-subtitle">Petits déjeuners</h5>
                                    <div class="vh-grid">
                                        @foreach ($logement->dejeuners as $dejeuner)
                                            <div class="vh-grid-item vh-grid-item-rituel">
                                                <i class="fal fa-check-circle"></i>
                                                <span>{{ $dejeuner->libelle }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if ($logement->equipements && $logement->equipements->count())
                                    <h5 class="vh-subtitle">Équipements</h5>
                                    <div class="vh-grid">
                                        @foreach ($logement->equipements as $equipement)
                                            <div class="vh-grid-item vh-grid-item-rituel">
                                                <i class="fal fa-check-circle"></i>
                                                <span>{{ $equipement->libelle }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if ($logement->rituels && $logement->rituels->count())
                                    <h5 class="vh-subtitle">Rituels</h5>
                                    <div class="vh-grid">
                                        @foreach ($logement->rituels as $rituel)
                                            <div class="vh-grid-item vh-grid-item-rituel">
                                                <i class="fal fa-magic"></i>
                                                <span>{{ $rituel->titre }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if ($logement->divinites && $logement->divinites->count())
                                    <h5 class="vh-subtitle">Divinités associées</h5>
                                    <div class="vh-grid">
                                        @foreach ($logement->divinites as $divinite)
                                            <div class="vh-grid-item vh-grid-item-divinite">
                                                <i class="fal fa-star-of-david"></i>
                                                <span>{{ $divinite->nom }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Localisation -->
                        <div class="vh-section-block">
                            <h4 class="vh-section-title">Localisation</h4>
                            <p class="vh-section-text">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $logement->adresse }}
                            </p>

                            <div id="logement-map"></div>

                            {{-- <div class="vh-location-info">
                                <p><i class="fas fa-map-marker-alt"></i> {{ $logement->adresse }}</p>

                                <a href="https://www.google.com/maps?q={{ $logement->latitude }},{{ $logement->longitude }}"
                                    target="_blank" class="vh-map-btn">
                                    Voir itinéraire Google Maps
                                </a>
                            </div> --}}


                        </div>
                    </div>

                    <!-- Colonne droite : résumé + hôte -->

                    <div class="col-md-4">
                        <div class="vh-sidebar-sticky">

                            {{--CARTE PRIX / RÉSUMÉ --}}
                            <div class="vh-summary-card">
                                <div class="vh-summary-header">
                                    <div>
                                        <span class="vh-summary-price">
                                            {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} FCFA
                                        </span>
                                        <span class="vh-summary-unit">/ nuit</span>
                                    </div>

                                    {{-- @if ($nbAvis > 0)
                                        <div class="vh-summary-rating">
                                            <i class="fas fa-star"></i>
                                            <span>{{ $note }}</span>
                                            <span class="vh-summary-rating-count">· {{ $nbAvis }} avis</span>
                                        </div>
                                    @else
                                        <div class="vh-summary-rating vh-rating-empty">
                                            <i class="fas fa-star"></i>
                                            <span>Aucun avis</span>
                                        </div>
                                    @endif --}}
                                </div>

                                <div class="vh-summary-body">
                                    <div class="vh-summary-row">
                                        <i class="fal fa-home"></i>
                                        <span>{{ $logement->typelogement->libelle ?? 'Type non défini' }}</span>
                                    </div>

                                    <div class="vh-summary-row">
                                        <i class="fal fa-users"></i>
                                        <span>{{ $logement->nb_voyageur_max }} voyageurs</span>
                                    </div>

                                    @if (!is_null($logement->nb_chambre))
                                        <div class="vh-summary-row">
                                            <i class="fal fa-bed"></i>
                                            <span>{{ $logement->nb_chambre }} chambre(s)</span>
                                        </div>
                                    @endif

                                    {{-- <div class="vh-summary-row">
                                        <i class="fal fa-eye"></i>
                                        <span>{{ $logement->vues ?? 0 }} vues</span>
                                    </div> --}}
                                </div>

                                <div class="vh-summary-footer">
                                    Créé le {{ $logement->created_at?->format('d/m/Y') }}
                                </div>
                            </div>


                            {{--CARTE HÔTE (propre + cohérente) --}}
                            @if ($host)
                                <div class="vh-host-card ">
                                    <h5 class="vh-host-title">
                                        Logement proposé par {{ $host->prenom ?? '' }} {{ $host->nom ?? '' }}
                                    </h5>

                                    <div class="vh-host-body">
                                        <div class="vh-host-avatar">
                                            @php
                                                $avatar = $host->photo ?? ($host->avatar ?? null);
                                            @endphp

                                            @if ($avatar)
                                                <img src="{{ $avatar }}" alt="Hôte">
                                            @else
                                                <div class="vh-host-initials">
                                                    {{ strtoupper(mb_substr($host->prenom ?? ($host->nom ?? 'H'), 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="vh-host-info">
                                            <div class="vh-host-name">
                                                {{ $host->prenom }} {{ $host->nom }}
                                            </div>

                                            @if (!empty($host->profession))
                                                <div class="vh-host-meta">{{ $host->profession }}</div>
                                            @endif

                                            @if (!empty($host->telephone))
                                                <div class="vh-host-meta"><i class="fal fa-phone"></i>
                                                    {{ $host->telephone }}</div>
                                            @endif

                                            @if (!empty($host->email))
                                                <div class="vh-host-meta"><i class="fal fa-envelope"></i>
                                                    {{ $host->email }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- <div class="custom-form" style="margin-bottom: 20px;">
                                        <h5 class="vh-section-title" style="margin-bottom:8px;">
                                            Un problème avec ce logement ?
                                        </h5>
                                        <p class="vh-section-text" style="font-size:12px;margin-bottom:10px;">
                                            Si vous constatez un contenu inapproprié, une fraude ou un autre problème
                                            avec cette annonce, vous pouvez nous le signaler.
                                        </p>

                                        <a href="{{ route('hoost.reports.create', ['annonce' => request()->fullUrl()]) }}"
                                            class="btn color-bg fw-btn" style="width:100%; text-align:center;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Signaler un problème
                                        </a>
                                    </div> --}}


                                    {{--Envoyer message --}}
                                    <div class="custom-form" style="margin-top:12px;">
                                        <form method="POST" action="{{ route('hoost.chats.start') }}">
                                            @csrf
                                            <input type="hidden" name="receiver_id" value="{{ $host->id }}">
                                            <input type="hidden" name="logement_id" value="{{ $logement->id }}">

                                            <label class="vh-host-form-label" style="margin-top:10px;">
                                                Envoyer un message à l’hôte :
                                            </label>

                                            <textarea name="message" required placeholder="Votre message..."></textarea>

                                            <button type="submit" class="btn float-btn color-bg fw-btn"
                                                style="margin-top:10px;">
                                                <i class="fal fa-paper-plane"></i> Envoyer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif


                            {{-- CARTE RÉSERVATION (tu peux laisser en custom-form, mais on l'encapsule proprement) --}}
                            <div class="vh-host-card">
                                <div class="custom-form">
                                    <form action="{{ route('hoost.reservations.checkout', $logement) }}" method="GET"
                                        name="reservation-form">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Date d'arrivée</label>
                                                <div class="date-container fl-wrap">
                                                     <input type="text" id="date_debut" name="date_debut"
                                                     style="padding-left: 16px;"
                                                     value="{{ request('date_debut') }}" required />
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <label>Date de départ</label>
                                                <div class="date-container fl-wrap">
                                                     <input type="text" id="date_fin" name="date_fin"
                                                     style="padding-left: 16px;"
                                                     value="{{ request('date_fin') }}" required />
                                                </div>
                                            </div>

                                            <input type="hidden" name="nb_nuits" id="nb_nuits">
                                            <input type="hidden" name="total_prix" id="total_prix">
                                            <input type="hidden" name="pourcentage_contribution"
                                                id="pourcentage_contribution">
                                            <input type="hidden" name="montant_contribution" id="montant_contribution">
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Nombre de voyageurs</label>
                                                <input type="number" name="nb_voyageur" min="1" style="padding-left:15px;"
                                                    placeholder="Ex: 2" value="{{ request('nb_voyageur') }}" required>
                                            </div>

                                            <div class="col-sm-12">
                                                <label>Projets Communautaires</label>
                                                <div class="listsearch-input-item">
                                                    <select name="projet_id" class="chosen-select on-radius">
                                                        <option value="">— Choisir —</option>
                                                        @foreach ($projets as $projet)
                                                            <option value="{{ $projet->id }}"
                                                                data-pourcentage="{{ $projet->pourcentage_contribution }}">{{ $projet->titre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn float-btn color-bg fw-btn"
                                            style="margin-top:25px;">
                                            Réserver
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>




                </div>
            </div>

        </div>
    </div>

    <!-- content end -->
    <div class="dashbard-bg gray-bg"></div>

    {{-- Visionneuse plein écran pour les photos --}}
    <div id="vh-photo-viewer" class="vh-photo-viewer" style="display:none;">
        <div class="vh-photo-viewer-overlay"></div>
        <div class="vh-photo-viewer-content">
            <button class="vh-photo-close" type="button">
                <i class="fal fa-times"></i>
            </button>
            <button class="vh-photo-nav vh-photo-prev" type="button">
                <i class="fal fa-chevron-left"></i>
            </button>
            <img src="" alt="Photo logement" class="vh-photo-viewer-img">
            <button class="vh-photo-nav vh-photo-next" type="button">
                <i class="fal fa-chevron-right"></i>
            </button>
            <div class="vh-photo-counter"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const photos = @json($photoUrls);
            if (!photos.length) return;

            const viewer = document.getElementById('vh-photo-viewer');
            const img = viewer.querySelector('.vh-photo-viewer-img');
            const counterEl = viewer.querySelector('.vh-photo-counter');
            const btnClose = viewer.querySelector('.vh-photo-close');
            const btnPrev = viewer.querySelector('.vh-photo-prev');
            const btnNext = viewer.querySelector('.vh-photo-next');
            const overlay = viewer.querySelector('.vh-photo-viewer-overlay');

            let currentIndex = 0;

            function updateViewer() {
                img.src = photos[currentIndex];
                counterEl.textContent = (currentIndex + 1) + ' / ' + photos.length;
            }

            function openViewer(index) {
                currentIndex = index;
                updateViewer();
                viewer.style.display = 'block';
                document.body.classList.add('vh-no-scroll');
            }

            function closeViewer() {
                viewer.style.display = 'none';
                document.body.classList.remove('vh-no-scroll');
            }

            function showNext() {
                currentIndex = (currentIndex + 1) % photos.length;
                updateViewer();
            }

            function showPrev() {
                currentIndex = (currentIndex - 1 + photos.length) % photos.length;
                updateViewer();
            }

            document.querySelectorAll('.vh-photo-trigger').forEach(el => {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    const idx = parseInt(this.dataset.index, 10);
                    if (!isNaN(idx)) {
                        openViewer(idx);
                    }
                });
            });

            btnClose.addEventListener('click', closeViewer);
            overlay.addEventListener('click', closeViewer);
            btnNext.addEventListener('click', showNext);
            btnPrev.addEventListener('click', showPrev);

            document.addEventListener('keydown', function(e) {
                if (viewer.style.display !== 'block') return;
                if (e.key === 'Escape') closeViewer();
                if (e.key === 'ArrowRight') showNext();
                if (e.key === 'ArrowLeft') showPrev();
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ranges désactivés : indisponible + réserver
            const blockedRanges = @json($blockedRanges ?? []);
            // Ranges disponibles : statut = "disponible"
            const availableRanges = @json($availableRanges ?? []);

            function parseYmd(str) {
                const [y, m, d] = str.split('-').map(Number);
                return new Date(y, m - 1, d);
            }

            // Vérifie si l’intervalle [startStr, endStr] chevauche un des ranges BLOQUÉS
            function hasOverlap(startStr, endStr) {
                if (!startStr || !endStr) return false;

                const start = parseYmd(startStr);
                const end = parseYmd(endStr);

                for (const r of blockedRanges) {
                    const bStart = parseYmd(r.from);
                    const bEnd = parseYmd(r.to);

                    // Chevauchement réel
                    if (bStart <= end && bEnd >= start) {
                        return true;
                    }
                }
                return false;
            }

            let endPicker = null;

            const startPicker = flatpickr("#date_debut", {
                dateFormat: "Y-m-d",
                minDate: "today",

                //On n'autorise que les jours avec statut "disponible"
                enable: availableRanges,

                //Et on bloque explicitement les périodes "indisponible" / "reserver"
                disable: blockedRanges,

                onChange: function(selectedDates, dateStr) {
                    if (endPicker) {
                        endPicker.set('minDate', dateStr || "today");

                        const endVal = document.querySelector('#date_fin').value;

                        if (dateStr && endVal && hasOverlap(dateStr, endVal)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Période non disponible',
                                text: 'La période que vous avez choisie contient des jours indisponibles.',
                                confirmButtonColor: '#d33'
                            });

                            document.querySelector('#date_fin').value = '';
                            endPicker.clear();
                        }
                    }
                }
            });

            endPicker = flatpickr("#date_fin", {
                dateFormat: "Y-m-d",
                minDate: "today",

                // Même logique pour la date de fin
                enable: availableRanges,
                disable: blockedRanges,

                onChange: function(selectedDates, dateStr) {
                    const startVal = document.querySelector('#date_debut').value;

                    if (!startVal || !dateStr) return;

                    if (hasOverlap(startVal, dateStr)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Période impossible',
                            text: 'La période sélectionnée traverse une période indisponible.',
                            confirmButtonColor: '#d33'
                        });

                        this.clear();
                        document.querySelector('#date_fin').value = '';
                    }
                }
            });

            // Sécurité supplémentaire lors du submit
            const form = document.querySelector('form[action*="reservations"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const d1 = document.querySelector('#date_debut').value;
                    const d2 = document.querySelector('#date_fin').value;

                    // 1) Vérifier que les dates sont renseignées
                    if (!d1 || !d2) {
                        e.preventDefault();

                        Swal.fire({
                            icon: 'error',
                            title: 'Dates manquantes',
                            text: 'Merci de choisir une date d’arrivée et une date de départ avant de réserver.',
                            confirmButtonColor: '#d33'
                        });

                        return; // on sort, pas besoin d’aller plus loin
                    }

                    if (hasOverlap(d1, d2)) {
                        e.preventDefault();

                        Swal.fire({
                            icon: 'error',
                            title: 'Impossible de réserver',
                            text: 'Votre période traverse une indisponibilité ou une réservation en cours.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    </script>


    {{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    // Ranges désactivés envoyés par le backend : [{from:'YYYY-MM-DD', to:'YYYY-MM-DD'}, ...]
    const blockedRanges = @json($blockedRanges ?? []);

    function parseYmd(str) {
        const [y, m, d] = str.split('-').map(Number);
        return new Date(y, m - 1, d);
    }

    // Vérifie si l’intervalle [startStr, endStr] chevauche un des ranges bloqués
    function hasOverlap(startStr, endStr) {
        if (!startStr || !endStr) return false;

        const start = parseYmd(startStr);
        const end   = parseYmd(endStr);

        for (const r of blockedRanges) {
            const bStart = parseYmd(r.from);
            const bEnd   = parseYmd(r.to);

            if (bStart <= end && bEnd >= start) {
                return true;
            }
        }
        return false;
    }

    let endPicker = null;

    const startPicker = flatpickr("#date_debut", {
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: blockedRanges,
        onChange: function (selectedDates, dateStr) {
            if (endPicker) {
                endPicker.set('minDate', dateStr || "today");

                const endVal = document.querySelector('#date_fin').value;

                if (dateStr && endVal && hasOverlap(dateStr, endVal)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Période non disponible',
                        text: 'La période que vous avez choisie contient des jours indisponibles.',
                        confirmButtonColor: '#d33'
                    });

                    document.querySelector('#date_fin').value = '';
                    endPicker.clear();
                }
            }
        }
    });

    endPicker = flatpickr("#date_fin", {
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: blockedRanges,
        onChange: function (selectedDates, dateStr) {
            const startVal = document.querySelector('#date_debut').value;

            if (!startVal || !dateStr) return;

            if (hasOverlap(startVal, dateStr)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Période impossible',
                    text: 'La période  sélectionnée traverse une période indisponible.',
                    confirmButtonColor: '#d33'
                });

                this.clear();
                document.querySelector('#date_fin').value = '';
            }
        }
    });

    // Sécurité supplémentaire lors du submit
    const form = document.querySelector('form[action*="reservations"]');
    if (form) {
        form.addEventListener('submit', function (e) {
            const d1 = document.querySelector('#date_debut').value;
            const d2 = document.querySelector('#date_fin').value;

            if (hasOverlap(d1, d2)) {
                e.preventDefault();

                Swal.fire({
                    icon: 'error',
                    title: 'Impossible de réserver',
                    text: 'Votre période traverse une indisponibilité ou une réservation en cours.',
                    confirmButtonColor: '#d33'
                });
            }
        });
    }
});
</script> --}}



    <style>
        /* HERO / HEADER */
        .vh-logement-hero {
            margin-bottom: 25px;
            border-radius: 16px;
            overflow: hidden;
            padding: 18px 18px 20px;
        }

        .vh-logement-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
            gap: 15px;
        }

        .vh-logement-title {
            font-size: 20px;
            font-weight: 600;
            margin: 0 0 5px;
        }

        .vh-logement-sub {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            font-size: 13px;
            color: #555;
            align-items: center;
        }

        .vh-logement-sub i {
            margin-right: 4px;
        }

        .vh-pill,
        .vh-pill-light {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .vh-pill {
            background: #fff3cd;
            color: #856404;
        }

        .vh-pill-light {
            background: #f1f3f5;
            color: #495057;
        }

        .vh-logement-rating-block {
            text-align: right;
            font-size: 13px;
        }

        .vh-rating-line {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 4px;
            font-weight: 500;
        }

        .vh-rating-line i {
            color: #ffb400;
        }

        .vh-rating-empty i {
            color: #ccc;
        }

        .vh-rating-count {
            color: #777;
            font-weight: 400;
        }

        .vh-meta-small {
            font-size: 12px;
            color: #999;
            margin-top: 3px;
        }

        /* HERO GALLERY */
        .vh-hero-gallery {
            display: grid;
            grid-template-columns: 2fr 1.1fr;
            gap: 10px;
        }

        .vh-hero-main {
            border-radius: 12px;
            overflow: hidden;
            height: 260px;
        }

        .vh-hero-main-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .vh-hero-thumbs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-auto-rows: 125px;
            gap: 8px;
        }

        .vh-hero-thumb {
            border-radius: 10px;
            overflow: hidden;
            position: relative;
        }

        .vh-hero-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .vh-more-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 600;
        }

        /* CONTENU */
        .vh-logement-body {
            border-radius: 16px;
            padding: 20px;
        }

        .vh-section-block {
            margin-bottom: 25px;
        }

        .vh-section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .vh-section-text {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }

        .vh-keyline {
            height: 1px;
            background: #eee;
            margin: 15px 0;
        }

        .vh-keyfacts {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .vh-keyfact-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 13px;
            min-width: 150px;
        }

        .vh-keyfact-item i {
            width: 18px;
            text-align: center;
            margin-top: 2px;
        }

        .vh-keyfact-label {
            font-size: 12px;
            color: #777;
        }

        .vh-keyfact-value {
            font-size: 13px;
            font-weight: 500;
        }

        .vh-subtitle {
            font-size: 13px;
            font-weight: 600;
            margin: 10px 0 6px;
        }

        /* GRID POUR EQUIPEMENTS / RITUELS / DIVINITES */
        .vh-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 10px;
            margin-bottom: 15px;
        }

        .vh-grid-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 10px;
            background: #f8f9fa;
            font-size: 13px;
            color: #444;
        }

        .vh-grid-item i {
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        {{-- .vh-grid-item-rituel {
            color: #D1B11B;
        }

        .vh-grid-item-divinite {
            color: #D1B11B;
        } --}}

        .vh-map-placeholder {
            border-radius: 12px;
            border: 1px dashed #ddd;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            color: #999;
            background: #fafafa;
        }

        /* SUMMARY CARD (colonne droite) */
        .vh-summary-card {
            border-radius: 16px;
            border: 1px solid #eee;
            padding: 15px 15px 12px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.03);
            position: relative;
            
            margin-bottom: 20px;
        }

        .vh-summary-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
            gap: 8px;
        }

        .vh-summary-price {
            font-size: 18px;
            font-weight: 600;
        }

        .vh-summary-unit {
            font-size: 12px;
            color: #777;
            margin-left: 4px;
        }

        .vh-summary-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 13px;
        }

        .vh-summary-rating i {
            color: #ffb400;
        }

        .vh-summary-rating-count {
            color: #777;
            font-size: 12px;
        }

        .vh-summary-body {
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
            margin-bottom: 6px;
        }

        .vh-summary-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            margin-bottom: 5px;
            color: #555;
        }

        .vh-summary-row i {
            width: 16px;
            text-align: center;
        }

        .vh-summary-footer {
            font-size: 11px;
            color: #999;
            text-align: right;
        }

        /* SECTION HOTE */
        .vh-host-card {
            border-radius: 16px;
            border: 1px solid #eee;
            padding: 15px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.02);
        }

        .vh-host-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .vh-host-body {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .vh-host-avatar {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            overflow: hidden;
            background: #f1f3f5;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .vh-host-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .vh-host-initials {
            font-size: 18px;
            font-weight: 600;
            color: #444;
        }

        .vh-host-info {
            font-size: 13px;
            color: #555;
        }

        .vh-host-name {
            font-weight: 600;
            margin-bottom: 3px;
        }

        .vh-host-meta {
            font-size: 12px;
            color: #777;
        }

        /* VISIONNEUSE PLEIN ECRAN */
        .vh-no-scroll {
            overflow: hidden;
        }

        .vh-photo-viewer {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
        }

        .vh-photo-viewer-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.8);
        }

        .vh-photo-viewer-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80vw;
            height: 80vh;
            max-width: 1100px;
            max-height: 700px;
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vh-photo-viewer-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        }

        .vh-photo-close {
            position: absolute;
            top: 16px;
            right: 16px;
            border: none;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vh-photo-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vh-photo-prev {
            left: 16px;
        }

        .vh-photo-next {
            right: 16px;
        }

        .vh-photo-counter {
            position: absolute;
            bottom: 16px;
            right: 20px;
            color: #fff;
            font-size: 13px;
            background: rgba(0, 0, 0, 0.5);
            padding: 3px 8px;
            border-radius: 10px;
        }

        /* Taille du textarea dans la carte hôte */
        .vh-host-card .custom-form textarea {
            width: 100%;
            min-height: 70px;
            max-height: 130px;
            padding: 8px 10px;
            font-size: 13px;
            border-radius: 10px;
            border: 1px solid #ddd;
            resize: vertical;
            /* ou 'none' si tu veux bloquer le redimensionnement */
            line-height: 1.4;
        }

        /* ✅ Le sticky doit être sur le conteneur, pas sur la card prix */
        .vh-sidebar-sticky {
            position: sticky;
            top: 90px;
            /* ajuste si ton header est plus haut */
            display: flex;
            flex-direction: column;
            gap: 16px;
            z-index: 5;
        }

        {{-- /* ✅ La card prix ne doit plus être sticky */
        .vh-sidebar-sticky {
            position: relative;
            /* IMPORTANT */
            top: auto;
            /* IMPORTANT */
        } --}}



        #logement-map {
            width: 100%;
            height: 260px;
            border-radius: 14px;
            overflow: hidden;
            margin-top: 10px;
            margin-bottom: 12px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        /* popup */
        .vh-map-popup {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .vh-map-popup-img {
            width: 80px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
        }

        .vh-map-popup-text {
            font-size: 12px;
            line-height: 1.4;
        }

        /* bloc infos sous la carte */
        .vh-location-info {
            padding: 12px 14px;
            border-radius: 12px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .vh-location-info p {
            margin: 0 0 8px;
            font-size: 13px;
            color: #374151;
        }

        .vh-location-info i {
            color: #ef4444;
        }

        .vh-map-btn {
            font-size: 13px;
            padding: 6px 10px;
            background: #D1B11B;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }

        .vh-map-btn:hover {
            background: #D1B11B;
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const lat = @json($logement->latitude);
            const lng = @json($logement->longitude);
            if (!lat || !lng) return;

            var map = L.map('logement-map').setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            var popupHtml = `
        <div class="vh-map-popup">
            <img src="{{ $photoPrincipale }}" class="vh-map-popup-img">
            <div class="vh-map-popup-text">
                <strong>{{ addslashes($logement->titre) }}</strong><br>
                {{ addslashes($logement->adresse) }}<br>
                <span style="color:#D1B11B;font-size:12px;">
                {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} FCFA / nuit
                </span>
            </div>
        </div>
    `;

            let marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup(popupHtml, {
                maxWidth: 280
            });

        });
    </script>


@endsection
