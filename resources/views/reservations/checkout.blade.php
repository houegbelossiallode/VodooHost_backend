@extends('layouts.app')

@section('section')
    <!-- content -->
    <div class="dashboard-content vh-checkout-page">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Tableau de bord
        </div>

        <div class="container dasboard-container">
            <!-- Titre / Étapes -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Finalisez votre réservation</span>
                </div>
                @include('partials/hearder2')
            </div>
            <!-- Titre dashboard end -->

            <div class="dasboard-widget-box fl-wrap vh-logement-body shadow-soft">
                <div class="row g-4">
                    <!-- Colonne gauche : recap logement / séjour / projet -->
                    <div class="col-lg-8">
                        {{-- Récap logement --}}
                        <div class="vh-section-block">
                            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                                <div>
                                    <h3 class="vh-logement-title">{{ $logement->titre }}</h3>
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

                                    {{-- <div class="vh-logement-meta">
                                        <span><i class="far fa-star"></i> 4,8 · 24 avis</span>
                                        <span><i class="far fa-badge-check"></i> Hôte vérifié</span>
                                    </div> --}}
                                </div>

                                {{-- @php
                                    $mainPhoto = $logement->photos->first()->url ?? asset('images/default-house.jpg');
                                    $galleryPhotos = $logement->photos->skip(1)->take(4); // 4 miniatures max
                                @endphp --}}
                                {{-- <div class="vh-photo-wrapper">
                                    
                                    <div class="vh-checkout-photo">
                                        <img id="vh-main-photo" src="{{ $mainPhoto }}" alt="Photo logement">
                                    </div> --}}

                                    {{-- Miniatures si on a plus d'une image --}}
                                    {{-- @if ($galleryPhotos->count() > 0)
                                        <div class="vh-photo-thumbs">
                                            @foreach ($galleryPhotos as $p)
                                                <button type="button" class="vh-photo-thumb"
                                                    data-photo-url="{{ $p->url }}">
                                                    <img src="{{ $p->url }}" alt="Photo supplémentaire">
                                                </button>
                                            @endforeach --}}

                                            {{-- Si plus d'images que 5 au total, petit lien "voir plus" --}}
                                            {{-- @if ($logement->photos->count() > 5)
                                                <a href="{{ route('hoost.logements.show', $logement) }}#photos"
                                                    class="vh-photo-more">
                                                    +{{ $logement->photos->count() - 5 }} photos
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div> --}}
                            </div>
                        </div>

                        {{-- Récap séjour --}}
                        <div class="vh-section-block">
                            <div class="vh-section-header">
                                <h4 class="vh-section-title">
                                    <i class="far fa-suitcase-rolling me-1"></i> Votre séjour
                                </h4>
                                <a href="{{ route('hoost.logements.show', $logement) }}#reservation" class="vh-edit-link">
                                    <i class="fal fa-pen"></i> Modifier les dates ou le nombre de voyageurs
                                </a>
                            </div>

                            <div class="vh-summary-grid">
                                <div class="vh-summary-item">
                                    <div class="vh-summary-label">Arrivée</div>
                                    <div class="vh-summary-value">{{ $dateDebut->format('d/m/Y') }}</div>
                                </div>
                                <div class="vh-summary-item">
                                    <div class="vh-summary-label">Départ</div>
                                    <div class="vh-summary-value">{{ $dateFin->format('d/m/Y') }}</div>
                                </div>
                                <div class="vh-summary-item">
                                    <div class="vh-summary-label">Nombre de nuits</div>
                                    <div class="vh-summary-value">{{ $nuits }} nuit(s)</div>
                                </div>
                                <div class="vh-summary-item">
                                    <div class="vh-summary-label">Voyageurs</div>
                                    <div class="vh-summary-value">{{ $nbVoyageur }} voyageur(s)</div>
                                </div>
                            </div>
                        </div>

                        {{-- Projet communautaire --}}
                        <div class="vh-section-block">
                            <h4 class="vh-section-title">
                                <i class="far fa-hand-holding-heart me-1"></i>
                                Projet communautaire soutenu
                            </h4>

                            <div class="vh-community-box">
                                @if ($projet)
                                    <div class="vh-community-header">
                                        <div>
                                            <p class="vh-section-text mb-1">
                                                Vous avez choisi de soutenir :
                                                <strong>{{ $projet->titre }}</strong>
                                                ({{ $projet->pourcentage_contribution }}% du montant de l’hébergement).
                                            </p>
                                            @if (!empty($projet->description))
                                                <p class="vh-section-text mb-0">{{ $projet->description }}</p>
                                            @endif
                                        </div>

                                    </div>

                                    @php
                                        // Accessors du modèle Projet
                                        $progress = $projet->progression ?? 0; // % (calculé dans le modèle)
                                        $objectif = $projet->objectif; // colonne en base
                                        $collecte = $projet->montant_collecte ?? 0; // somme des part_projet
                                    @endphp

                                    <div class="vh-progress-block">
                                        <div class="vh-progress-header">
                                            <span>Progression du projet</span>
                                            <span>{{ $progress }}%</span>
                                        </div>
                                        <div class="vh-progress-bar">
                                            <div class="vh-progress-inner" style="width: {{ $progress }}%;"></div>
                                        </div>
                                        <div class="vh-progress-meta">
                                            <span>
                                                Objectif :
                                                {{ number_format($objectif, 0, ',', ' ') }} FCFA
                                            </span>
                                            <span>
                                                Déjà collecté :
                                                {{ number_format($collecte, 0, ',', ' ') }} FCFA
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <p class="vh-section-text mb-1">
                                        Aucun projet communautaire n’a été sélectionné.
                                    </p>
                                    <p class="vh-section-text mb-0">
                                        Une partie de votre séjour pourra être affectée à un projet par défaut
                                        (éducation locale, patrimoine vaudou, artisans, eau potable…).
                                    </p>
                                @endif
                            </div>

                        </div>

                        {{-- Infos supplémentaires / conditions --}}
                        <div class="vh-section-block">
                            <h4 class="vh-section-title">
                                <i class="far fa-info-circle me-1"></i>
                                Avant de payer
                            </h4>
                            <ul class="vh-info-list">
                                <li>Votre réservation sera confirmée après validation du paiement.</li>
                                <li>La contribution au projet communautaire est reversée à nos partenaires locaux.</li>
                                <li>En cas de paiement en deux fois, la deuxième échéance devra être réglée avant l’arrivée.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Colonne droite : résumé prix + paiement -->
                    <div class="col-lg-4">
                        <div class="vh-summary-card shadow-soft">
                            <div class="vh-summary-header">
                                <div>
                                    <h4 class="vh-section-title mb-1">Récapitulatif du prix</h4>
                                    <span class="vh-summary-sub">
                                        Détails du montant à régler en FCFA.
                                    </span>
                                </div>
                                <span class="vh-badge-ref">
                                    <i class="far fa-hashtag"></i> {{ $logement->reference ?? 'Réf.' }}
                                </span>
                            </div>

                            @php
                                $prixParNuit = $logement->prix_par_nuit;
                            @endphp

                            <div class="vh-summary-body">
                                <div class="vh-summary-row">
                                    <span>{{ $prixParNuit ? number_format($prixParNuit, 0, ',', ' ') : '-' }} FCFA ×
                                        {{ $nuits }} nuit(s)</span>
                                    <span>{{ number_format($basePrix, 0, ',', ' ') }} FCFA</span>
                                </div>

                                <div class="vh-summary-row">
                                    @if ($projet)
                                        <span>Contribution projet ({{ $projet->pourcentage_contribution }}%)</span>
                                    @else
                                        <span>Contribution projet</span>
                                    @endif
                                    <span>{{ number_format($contrib, 0, ',', ' ') }} FCFA</span>
                                </div>

                                <div class="vh-summary-row vh-summary-total">
                                    <span>Total à payer</span>
                                    <span id="sum_total_main">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                                </div>

                                <div class="vh-summary-row" id="sum_total_other_currency" style="display:none;">
                                    <span>Total converti</span>
                                    <span id="sum_total_other_value">-</span>
                                </div>

                                <div class="vh-summary-row" id="sum_echeances" style="display:none;">
                                    <span>2 échéances de</span>
                                    <span id="sum_echeance_val">-</span>
                                </div>
                            </div>

                            {{-- Formulaire de paiement --}}
                            <form action="{{ route('hoost.reservations.store', $logement) }}" method="POST" id="checkout-form">
                                @csrf

                                {{-- Hidden backend --}}
                                <input type="hidden" name="date_debut" value="{{ $dateDebut->format('Y-m-d') }}">
                                <input type="hidden" name="date_fin" value="{{ $dateFin->format('Y-m-d') }}">
                                <input type="hidden" name="nb_voyageur" value="{{ $nbVoyageur }}">
                                <input type="hidden" name="nb_nuits" value="{{ $nuits }}">
                                <input type="hidden" name="projet_id" value="{{ $projet?->id }}">
                                <input type="hidden" name="montant_base" value="{{ $basePrix }}">
                                <input type="hidden" name="montant_contrib" value="{{ $contrib }}">
                                <input type="hidden" name="montant_total" id="montant_total_hidden"
                                    value="{{ $total }}">

                                {{-- Devise & mode de paiement (affichage only, backend en FCFA) --}}
                                {{-- <div class="vh-mini-block">
                                    <div class="vh-mini-label">Devise d’affichage</div>
                                    <select name="currency" id="currency" class="vh-select">
                                        <option value="XOF">FCFA (XOF)</option>
                                        <option value="EUR">Euro (€)</option>
                                        <option value="USD">Dollar ($)</option>
                                    </select>
                                    <small class="vh-meta-small">
                                        Le débit réel sera effectué en FCFA. La conversion est indicative.
                                    </small>
                                </div> --}}

                                {{-- <div class="vh-mini-block">
                                    <div class="vh-mini-label">Mode de paiement</div>
                                    <select name="payment_mode" id="payment_mode" class="vh-select">
                                        <option value="once">En une fois</option>
                                        <option value="twice">En deux fois (50% / 50%)</option>
                                    </select>
                                </div> --}}

                                {{-- Choix de la passerelle sous forme de cartes --}}
                                <div class="vh-mini-block">
                                    <div class="vh-mini-label">Passerelle de paiement</div>
                                    <div class="vh-gateway-grid">
                                        <label class="vh-gateway-card active">
                                            <input type="radio" name="gateway" value="fedapay" checked>
                                            <div class="vh-gateway-icon">
                                                <i class="far fa-wallet"></i>
                                            </div>
                                            <div class="vh-gateway-text">
                                                <span class="title">FedaPay</span>
                                                <span class="subtitle">Mobile Money / CB</span>
                                            </div>
                                        </label>

                                        <label class="vh-gateway-card">
                                            <input type="radio" name="gateway" value="kkiapay">
                                            <div class="vh-gateway-icon">
                                                <i class="far fa-credit-card"></i>
                                            </div>
                                            <div class="vh-gateway-text">
                                                <span class="title">Kkiapay</span>
                                                <span class="subtitle">Mobile Money + Visa / Mastercard</span>
                                            </div>
                                        </label>

                                        <label class="vh-gateway-card">
                                            <input type="radio" name="gateway" value="paypal">
                                            <div class="vh-gateway-icon">
                                                <i class="far fa-credit-card"></i>
                                            </div>
                                            <div class="vh-gateway-text">
                                                <span class="title">Paypal</span>
                                                {{-- <span class="subtitle">Mobile Money + Visa / Mastercard</span> --}}
                                            </div>
                                        </label>
                                        
                                    </div>
                                </div>

                                <button type="submit" class="btn color-bg fw-btn vh-pay-btn">
                                    <i class="far fa-shield-check me-1"></i>
                                    Payer maintenant
                                </button>
                            </form>

                            <small class="vh-meta-small d-block mt-2">
                                En cliquant sur « Payer maintenant », vous serez redirigé vers une page sécurisée de notre
                                partenaire de paiement. Aucune information de carte n’est stockée sur Vodoo.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- content end -->
    <div class="dashbard-bg gray-bg"></div>
    

    {{-- Script conversion / paiement 2x --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalXof = {{ $total }};
            const rates = {
                XOF: 1,
                EUR: 1 / 655.957,
                USD: 1 / 600
            };

            const currencySelect = document.getElementById('currency');
            const paymentModeSelect = document.getElementById('payment_mode');
            const sumTotalMain = document.getElementById('sum_total_main');
            const sumTotalOtherRow = document.getElementById('sum_total_other_currency');
            const sumTotalOtherVal = document.getElementById('sum_total_other_value');
            const sumEcheancesRow = document.getElementById('sum_echeances');
            const sumEcheanceVal = document.getElementById('sum_echeance_val');

            const gatewayCards = document.querySelectorAll('.vh-gateway-card');

            function formatCurrency(amountXof, currency) {
                if (!amountXof || amountXof <= 0) return '-';
                const rate = rates[currency] ?? 1;
                const val = amountXof * rate;
                let symbol = 'FCFA';
                if (currency === 'EUR') symbol = '€';
                if (currency === 'USD') symbol = '$';

                return new Intl.NumberFormat('fr-FR', {
                    maximumFractionDigits: (currency === 'XOF' ? 0 : 2)
                }).format(val) + ' ' + symbol;
            }

            function updatePriceDisplay() {
                const currency = currencySelect.value || 'XOF';
                const mode = paymentModeSelect.value || 'once';

                sumTotalMain.textContent = formatCurrency(totalXof, 'XOF');

                if (currency !== 'XOF') {
                    sumTotalOtherVal.textContent = formatCurrency(totalXof, currency);
                    sumTotalOtherRow.style.display = 'flex';
                } else {
                    sumTotalOtherRow.style.display = 'none';
                }

                if (mode === 'twice') {
                    const half = totalXof / 2;
                    sumEcheanceVal.textContent = formatCurrency(half, currency);
                    sumEcheancesRow.style.display = 'flex';
                } else {
                    sumEcheancesRow.style.display = 'none';
                }
            }

            if (currencySelect && paymentModeSelect) {
                currencySelect.addEventListener('change', updatePriceDisplay);
                paymentModeSelect.addEventListener('change', updatePriceDisplay);
                updatePriceDisplay();
            }

            // Active state visuelle pour les cartes de passerelle
            gatewayCards.forEach(card => {
                card.addEventListener('click', () => {
                    gatewayCards.forEach(c => c.classList.remove('active'));
                    card.classList.add('active');
                });
            });


            // Changement de photo principale au clic sur une miniature
            const mainPhoto = document.getElementById('vh-main-photo');
            const photoThumbs = document.querySelectorAll('.vh-photo-thumb');

            photoThumbs.forEach(thumb => {
                thumb.addEventListener('click', () => {
                    // Met à jour la photo principale
                    mainPhoto.src = thumb.dataset.photoUrl;

                    // Met à jour l'état actif
                    photoThumbs.forEach(t => t.classList.remove('active'));
                    thumb.classList.add('active');
                });
            });


        });
    </script>

    <style>
        :root {
            --vh-primary: #D1B11B;
            --vh-secondary: #6b7280;
            --vh-border: #e5e7eb;
            --vh-soft-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        }



        .vh-photo-wrapper {
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: flex-end;
        }

        .vh-checkout-photo {
            width: 220px;
            height: 150px;
            border-radius: 14px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 10px 22px rgba(15, 23, 42, 0.2);
        }

        .vh-checkout-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vh-photo-thumbs {
            display: flex;
            gap: 6px;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .vh-photo-thumb {
            border: none;
            padding: 0;
            background: transparent;
            border-radius: 8px;
            overflow: hidden;
            width: 46px;
            height: 38px;
            cursor: pointer;
            opacity: 0.8;
            transition: transform .15s ease, opacity .15s ease, box-shadow .15s ease;
        }

        .vh-photo-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vh-photo-thumb:hover {
            opacity: 1;
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(15, 23, 42, 0.2);
        }

        .vh-photo-thumb.active {
            opacity: 1;
            box-shadow: 0 0 0 2px #D1B11B;
        }

        .vh-photo-more {
            font-size: 11px;
            padding: 5px 9px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            background: #f9fafb;
            color: #374151;
            text-decoration: none;
            white-space: nowrap;
        }



        .shadow-soft {
            box-shadow: var(--vh-soft-shadow);
        }

        .vh-checkout-page {
            background:
                radial-gradient(circle at top left, #eef2ff 0, transparent 55%),
                radial-gradient(circle at bottom right, #fef3c7 0, transparent 60%);
        }

        /* Header */
        .vh-checkout-header {
            align-items: flex-start;
            gap: 20px;
        }

        .vh-header-icon {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            background: linear-gradient(135deg, #D1B11B, #D1B11B);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
        }

        .vh-step-chip {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            font-size: 11px;
            border-radius: 999px;
            background: #eef2ff;
            color: #D1B11B;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .vh-header-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .vh-header-subtitle {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .vh-steps {
            display: flex;
            gap: 16px;
            align-items: center;
            font-size: 12px;
        }

        .vh-step {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #9ca3af;
        }

        .vh-step-number {
            width: 22px;
            height: 22px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            background: #fff;
        }

        .vh-step.done .vh-step-number {
            background: #10b981;
            border-color: #10b981;
            color: #fff;
        }

        .vh-step.current .vh-step-number {
            background: #D1B11B;
            border-color: #D1B11B;
            color: #fff;
        }

        .vh-step.current .vh-step-label {
            color: #111827;
            font-weight: 600;
        }

        /* Corps / logement */
        .vh-logement-body {
            border-radius: 20px;
            padding: 22px 20px 18px;
            margin-top: 10px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            background: #fff;
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

        .vh-logement-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
        }

        .vh-logement-meta i {
            margin-right: 4px;
            color: #fbbf24;
        }



        /* Sections */
        .vh-section-block {
            margin-bottom: 20px;
        }

        .vh-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .vh-section-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .vh-section-text {
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }

        .vh-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 10px;
        }

        .vh-summary-item {
            padding: 8px 10px;
            border-radius: 10px;
            background: #f8fafc;
            font-size: 13px;
            border: 1px solid #e5e7eb;
        }

        .vh-summary-label {
            font-size: 11px;
            color: #777;
            margin-bottom: 2px;
        }

        .vh-summary-value {
            font-weight: 500;
        }

        .vh-edit-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #4e66f8;
        }

        .vh-edit-link i {
            font-size: 11px;
        }

        .vh-info-list {
            list-style: none;
            padding-left: 0;
            margin: 0;
            font-size: 13px;
            color: #555;
        }

        .vh-info-list li {
            margin-bottom: 4px;
        }

        .vh-info-list li::before {
            content: "•";
            margin-right: 6px;
            color: #d1b11b;
        }

        /* Projet communautaire */
        .vh-community-box {
            border-radius: 14px;
            background: #f5f7ff;
            border: 1px solid #e0e5ff;
            padding: 12px 12px 10px;
        }

        .vh-community-header {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 8px;
            align-items: flex-start;
        }

        .vh-community-chip {
            font-size: 11px;
            padding: 4px 9px;
            border-radius: 999px;
            background: #4e66f8;
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .vh-community-chip i {
            font-size: 12px;
        }

        .vh-progress-block {
            margin-top: 4px;
            font-size: 11px;
        }

        .vh-progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            color: #374151;
        }

        .vh-progress-bar {
            width: 100%;
            height: 7px;
            border-radius: 999px;
            background: #e4e7ff;
            overflow: hidden;
        }

        .vh-progress-inner {
            height: 100%;
            background: linear-gradient(90deg, #d1b11b, #D1B11B);
            border-radius: 999px;
        }

        .vh-progress-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 4px;
            color: #4b5563;
        }

        /* Carte résumé prix */
        .vh-summary-card {
            border-radius: 18px;
            border: 1px solid rgba(148, 163, 184, 0.3);
            padding: 16px 15px 14px;
            background: #fff;
            position: sticky;
            top: 90px;
        }

        .vh-summary-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            gap: 6px;
        }

        .vh-summary-sub {
            font-size: 12px;
            color: #6b7280;
        }

        .vh-badge-ref {
            font-size: 11px;
            border-radius: 999px;
            border: 1px dashed #d1d5db;
            background: #f9fafb;
            padding: 4px 8px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #4b5563;
        }

        .vh-summary-body {
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 10px 0;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .vh-summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
            color: #555;
        }

        .vh-summary-total {
            font-weight: 600;
            margin-top: 4px;
            padding-top: 4px;
            border-top: 1px dashed #ddd;
        }

        .vh-meta-small {
            font-size: 11px;
            color: #9ca3af;
        }

        .vh-mini-block {
            margin-top: 10px;
        }

        .vh-mini-label {
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .vh-select {
            width: 100%;
            font-size: 13px;
            padding: 6px 8px;
            border-radius: 999px;
            border: 1px solid #d1d5db;
            outline: none;
        }

        .vh-select:focus {
            border-color: #D1B11B;
            box-shadow: 0 0 0 1px rgba(79, 70, 229, 0.2);
        }

        /* Gateways cards */
        .vh-gateway-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
            margin-top: 4px;
        }

        .vh-gateway-card {
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            padding: 8px 9px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all .2s ease;
            background: #f9fafb;
        }

        .vh-gateway-card input[type="radio"] {
            display: none;
        }

        .vh-gateway-icon {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            background: #eef2ff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #D1B11B;
        }

        .vh-gateway-text {
            display: flex;
            flex-direction: column;
            font-size: 12px;
        }

        .vh-gateway-text .title {
            font-weight: 600;
            color: #111827;
        }

        .vh-gateway-text .subtitle {
            color: #6b7280;
            font-size: 11px;
        }

        .vh-gateway-card.active {
            border-color: #D1B11B;
            background: rgba(78, 102, 248, 0.05);
            box-shadow: 0 5px 16px rgba(15, 23, 42, 0.12);
        }

        .vh-pay-btn {
            width: 100%;
            margin-top: 12px;
            border-radius: 999px;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .vh-summary-card {
                position: static;
                margin-top: 12px;
            }
        }

        @media (max-width: 767.98px) {
            .vh-logement-body {
                padding: 16px 12px 12px;
            }

            .vh-checkout-photo {
                width: 100px;
                height: 74px;
            }

            .vh-steps {
                flex-wrap: wrap;
            }
        }
    </style>
@endsection
