@extends('layouts.app')

@section('section')
<div class="dashboard-content payment-page">
    <div class="dashboard-menu-btn color-bg">
        <span><i class="fas fa-bars"></i></span>Tableau de bord
    </div>

    <div class="container dasboard-container">
        <!-- HEADER PAIEMENT -->
        <div class="dashboard-title fl-wrap payment-header">
            
            @include('partials/hearder2')
        </div>

        <div class="dasboard-wrapper fl-wrap no-pag">
            <div class="row g-4">
                <!-- COLONNE GAUCHE : RÉCAPITULATIF -->
                <div class="col-lg-7">
                    <div class="booking-summary shadow-soft">
                        <!-- Titre + référence -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="mb-1 d-flex align-items-center gap-2">
                                    <span class="stay-chip">
                                        <i class="fas fa-home"></i>
                                        Votre séjour
                                    </span>
                                </h4>
                                <p class="text-muted mb-0 small">
                                    Vérifiez les détails avant de procéder au paiement.
                                </p>
                            </div>
                            <span class="badge bg-light text-dark booking-ref">
                                <i class="fas fa-hashtag me-1"></i> {{ $logement->reference }}
                            </span>
                        </div>

                        <!-- CARTE LOGEMENT -->
                        <div class="property-card bg-white rounded-4 overflow-hidden mb-4">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <div class="property-image h-100"
                                         style="background-image: url('{{ $logement->photos->isNotEmpty() ? $logement->photos->first()->url : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80' }}');
                                             background-size: cover;
                                             background-position: center;">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="p-3 p-md-4">
                                        <h5 class="fw-bold mb-1 logement-title">
                                            {{ $logement->titre }}
                                        </h5>

                                        <div class="d-flex align-items-center mb-2">
                                            <span class="rating-stars me-2">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </span>
                                            <small class="text-muted">(24 avis)</small>
                                        </div>

                                        <div class="d-flex align-items-center text-muted mb-3">
                                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                            <small>{{ $logement->adresse }}</small>
                                        </div>

                                        <div class="stay-meta">
                                            <div class="stay-meta-item">
                                                <span class="label">Prix par nuit</span>
                                                <span class="value">
                                                    {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} FCFA
                                                </span>
                                            </div>
                                            {{-- Exemple si tu as les dates & nuits
                                            <div class="stay-meta-item">
                                                <span class="label">Dates</span>
                                                <span class="value">
                                                    {{ $debut_sejour }} → {{ $fin_sejour }}
                                                </span>
                                            </div>
                                            <div class="stay-meta-item">
                                                <span class="label">Nombre de nuits</span>
                                                <span class="value">{{ $nb_nuits }} nuits</span>
                                            </div>
                                            --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PROJET COMMUNAUTAIRE (OPTIONNEL) -->
                        @if(!empty($projetCommunautaire ?? null))
                            <div class="community-project-box">
                                <div class="cp-header">
                                    <div class="cp-title-wrap">
                                        <span class="cp-badge">
                                            <i class="far fa-hand-holding-heart"></i>
                                            Projet communautaire
                                        </span>
                                        <h6 class="cp-title">
                                            {{ $projetCommunautaire->titre ?? 'Projet communautaire soutenu' }}
                                        </h6>
                                        <span class="cp-location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $projetCommunautaire->localisation ?? 'Ouidah & environs' }}
                                        </span>
                                    </div>
                                    <span class="cp-tagline">
                                        Votre séjour contribue à ce projet ❤️
                                    </span>
                                </div>

                                <p class="cp-description">
                                    {{ $projetCommunautaire->description_courte ?? "Une partie de votre réservation finance directement ce projet au bénéfice de la communauté locale." }}
                                </p>

                                @php
                                    $progress = $projetCommunautaire->progression ?? 42; // %
                                @endphp

                                <div class="cp-progress-wrapper">
                                    <div class="cp-progress-header">
                                        <span>Progression du projet</span>
                                        <span class="fw-semibold">{{ $progress }}%</span>
                                    </div>
                                    <div class="cp-progress-bar">
                                        <div class="cp-progress-inner" style="width: {{ $progress }}%;"></div>
                                    </div>
                                    <div class="cp-progress-meta">
                                        <span>Objectif : {{ number_format($projetCommunautaire->objectif ?? 1000000, 0, ',', ' ') }} FCFA</span>
                                        <span>Déjà collecté : {{ number_format($projetCommunautaire->collecte ?? 420000, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- RÉCAP MONTANT -->
                        <div class="amount-summary">
                            <h6 class="amount-title">Récapitulatif du montant</h6>
                            <div class="amount-line">
                                <span>Séjour</span>
                                <span>{{ number_format($amount, 0, ',', ' ') }} FCFA</span>
                            </div>
                            {{-- Si tu veux détailler plus tard :
                            <div class="amount-line">
                                <span>Frais de service</span>
                                <span>{{ number_format($frais_service, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="amount-line">
                                <span>Contribution projet communautaire</span>
                                <span>{{ number_format($contrib_projet, 0, ',', ' ') }} FCFA</span>
                            </div>
                            --}}
                            <div class="amount-line total">
                                <span>Total à payer</span>
                                <span>{{ number_format($amount, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <p class="text-muted mt-1 small">
                                TVA incluse. Le paiement est 100% sécurisé et chiffré.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- COLONNE DROITE : PAIEMENT KKIAPAY -->
                <div class="col-lg-5">
                    <div class="sticky-sidebar">
                        <div class="dasboard-widget-box fl-wrap payment-widget premium-box">
                            {{-- <div class="premium-ribbon">
                                <span>Premium</span>
                            </div> --}}

                            <!-- En-tête marque -->
                            <div class="payment-brand-header">
                                <div class="vodoo-brand">
                                    <img src="{{ asset('assets/images/voodoo/why2.png') }}" alt="Vodoo"
                                         onerror="this.style.display='none'">
                                    <div class="vodoo-text">
                                        <span class="vodoo-title">Vodoo Host</span>
                                        <span class="vodoo-subtitle">Paiement sécurisé</span>
                                    </div>
                                </div>

                                <div class="payment-secure-badge">
                                    <i class="far fa-lock"></i>
                                    Chiffrement &amp; sécurité renforcée
                                </div>
                            </div>

                            <!-- Montant mis en avant -->
                            <div class="payment-amount-box">
                                <span class="label">Total à payer</span>
                                <div class="main-amount">
                                    {{ number_format($amount, 0, ',', ' ') }}
                                    <span class="currency">FCFA</span>
                                </div>
                                {{-- <span class="sub-text">
                                    Via Kkiapay – aucun frais supplémentaire.
                                </span> --}}
                            </div>

                            <!-- Méthodes de paiement -->
                            <div class="payment-methods-info">
                                <p class="mb-2">
                                    Le paiement est géré par <strong>Kkiapay</strong>, partenaire de confiance pour&nbsp;:
                                </p>
                                {{-- <div class="payment-methods">
                                    <div class="payment-method active">
                                        <i class="far fa-credit-card"></i>
                                        <span>Cartes bancaires</span>
                                        <small class="text-muted d-block mt-1">Visa, Mastercard</small>
                                    </div>
                                    <div class="payment-method">
                                        <i class="far fa-mobile"></i>
                                        <span>Mobile Money</span>
                                        <small class="text-muted d-block mt-1">MTN, Moov, etc.</small>
                                    </div>
                                </div> --}}
                            </div>

                            <!-- CTA PAIEMENT -->
                            <div class="payment-cta-box">
                                <button id="kkiapay-pay-btn" class="btn color-bg btn-full-width payment-btn-lg">
                                    <i class="far fa-shield-check"></i>
                                    Payer maintenant
                                </button>

                                <p class="payment-small-text">
                                    En cliquant sur «&nbsp;Payer maintenant&nbsp;», vous serez redirigé vers l’interface
                                    sécurisée de Kkiapay pour finaliser votre paiement.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- row -->
        </div>
    </div>
</div>

{{-- SDK JS Kkiapay --}}
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('kkiapay-pay-btn');
        if (!btn) return;

        btn.addEventListener('click', function (e) {
            e.preventDefault();

            openKkiapayWidget({
                amount: {{ (int) $amount }}, // Montant en XOF
                key: "{{ config('services.kkiapay.public_key') }}", // <---
                sandbox: {{ config('services.kkiapay.live') ? 'false' : 'true' }}, // Mode sandbox ou live
                currency: "XOF",
                name: "{{ trim(($user->prenom ?? '') . ' ' . ($user->nom ?? '')) }}",
                email: "{{ $user->email }}",
                phone: "{{ $user->telephone }}",
                paymentmethod: "", // laisser vide pour permettre carte + momo
                data: "{{ $payloadToken }}",
                callback: "{{ route('hoost.reservations.kkiapay.callback', ['token' => $payloadToken]) }}",
                position: "center",
                theme: "#D1B11B"
            });
        });
    });
</script>

<style>
    :root {
        --primary-color: #D1B11B;
        --secondary-color: #6c757d;
        --light-bg: #f8f9ff;
        --border-color: #e9ecef;
        --shadow-soft: 0 18px 40px rgba(15, 23, 42, 0.08);
    }

    .payment-page {
        background: radial-gradient(circle at top left, #eef2ff 0, transparent 50%),
                    radial-gradient(circle at bottom right, #fef3c7 0, transparent 55%);
    }

    .shadow-soft {
        box-shadow: var(--shadow-soft);
        border-radius: 18px;
    }

    /* HEADER PAIEMENT */
    .payment-header {
        align-items: flex-start;
        gap: 20px;
    }

    .payment-header .dashboard-title-item {
        display: none; /* on remplace par notre bloc custom */
    }

    .payment-title {
        font-size: 1.4rem;
        font-weight: 700;
    }

    .payment-label {
        display: inline-flex;
        align-items: center;
        padding: 2px 9px;
        font-size: 11px;
        border-radius: 999px;
        background: #eef2ff;
        color: #4f46e5;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .payment-icon {
        width: 36px;
        height: 36px;
        border-radius: 999px;
        background: linear-gradient(135deg, #4e66f8, #7b9dff);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 16px;
    }

    .payment-subtitle {
        font-size: 13px;
        color: #6b7280;
        margin-top: 6px;
        margin-bottom: 12px;
    }

    .payment-steps {
        display: flex;
        gap: 16px;
        align-items: center;
        font-size: 12px;
    }

    .payment-steps .step {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #9ca3af;
    }

    .payment-steps .step .step-number {
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

    .payment-steps .step.done .step-number {
        background: #10b981;
        border-color: #10b981;
        color: #fff;
    }

    .payment-steps .step.current .step-number {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #fff;
    }

    .payment-steps .step.current .step-label {
        color: #111827;
        font-weight: 600;
    }

    .booking-summary {
        background: #fff;
        border-radius: 18px;
        padding: 24px 22px;
        border: 1px solid rgba(148, 163, 184, 0.18);
    }

    .booking-ref {
        font-size: 11px;
        border-radius: 999px;
        border: 1px dashed #d1d5db;
        background: #f9fafb !important;
    }

    .property-card {
        border: 1px solid rgba(148, 163, 184, 0.3);
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.06);
    }

    .property-image {
        min-height: 170px;
    }

    .logement-title {
        font-size: 1.05rem;
    }

    .rating-stars {
        color: #fbbf24;
        font-size: 12px;
    }

    .stay-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        border-top: 1px dashed #e5e7eb;
        padding-top: 10px;
        margin-top: 6px;
    }

    .stay-meta-item {
        display: flex;
        flex-direction: column;
        font-size: 12px;
    }

    .stay-meta-item .label {
        color: #9ca3af;
    }

    .stay-meta-item .value {
        font-weight: 600;
        color: #111827;
    }

    /* PROJET COMMUNAUTAIRE */
    .community-project-box {
        margin-top: 18px;
        padding: 16px 16px 14px;
        border-radius: 14px;
        background: #f5f7ff;
        border: 1px solid #e0e5ff;
    }

    .cp-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 6px;
    }

    .cp-title-wrap {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .cp-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 10px;
        text-transform: uppercase;
        background: #4e66f8;
        color: #fff;
        padding: 3px 9px;
        border-radius: 999px;
        letter-spacing: 0.06em;
    }

    .cp-title {
        font-size: 14px;
        margin: 0;
        font-weight: 600;
        color: #111827;
    }

    .cp-location {
        font-size: 11px;
        color: #4b5563;
        white-space: nowrap;
    }

    .cp-location i {
        margin-right: 4px;
        color: #4e66f8;
    }

    .cp-tagline {
        font-size: 11px;
        color: #6d28d9;
        font-weight: 500;
    }

    .cp-description {
        font-size: 12px;
        color: #4b5563;
        margin-bottom: 8px;
    }

    .cp-progress-wrapper {
        margin-top: 2px;
    }

    .cp-progress-header {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        margin-bottom: 4px;
        color: #374151;
    }

    .cp-progress-bar {
        width: 100%;
        height: 7px;
        border-radius: 999px;
        background: #e4e7ff;
        overflow: hidden;
        position: relative;
    }

    .cp-progress-inner {
        height: 100%;
        background: linear-gradient(90deg, #4e66f8, #7b9dff);
        border-radius: 999px;
        transition: width 0.4s ease;
    }

    .cp-progress-meta {
        display: flex;
        justify-content: space-between;
        font-size: 10px;
        color: #4b5563;
        margin-top: 5px;
    }

    /* RECAP MONTANT */
    .amount-summary {
        margin-top: 20px;
        padding-top: 14px;
        border-top: 1px solid rgba(209, 213, 219, 0.7);
        font-size: 13px;
    }

    .amount-title {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
        color: #111827;
    }

    .amount-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
        color: #4b5563;
    }

    .amount-line.total {
        margin-top: 6px;
        padding-top: 6px;
        border-top: 1px dashed #d1d5db;
        font-weight: 700;
        color: #111827;
    }

    /* PAIEMENT WIDGET */
    .sticky-sidebar {
        position: sticky;
        top: 80px;
    }

    .payment-widget {
        background: #fff;
        border-radius: 18px;
        padding: 20px 18px 18px;
        box-shadow: var(--shadow-soft);
        border: 1px solid rgba(148, 163, 184, 0.26);
        position: relative;
        overflow: hidden;
    }

    .premium-box::before {
        content: "";
        position: absolute;
        inset: -40%;
        background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.12), transparent 60%);
        opacity: .8;
        z-index: -1;
    }

    .premium-ribbon {
        position: absolute;
        top: 12px;
        right: -30px;
        background: linear-gradient(45deg, #4e66f8, #7a8ef8);
        color: white;
        padding: 3px 30px;
        transform: rotate(45deg);
        font-size: 11px;
        font-weight: 600;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .payment-brand-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        gap: 10px;
    }

    .vodoo-brand {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .vodoo-brand img {
        width: 42px;
        height: 42px;
        border-radius: 14px;
        object-fit: cover;
        box-shadow: 0 5px 12px rgba(15, 23, 42, 0.25);
    }

    .vodoo-text .vodoo-title {
        font-weight: 700;
        font-size: 15px;
    }

    .vodoo-text .vodoo-subtitle {
        font-size: 11px;
        color: #6b7280;
    }

    .payment-secure-badge {
        background: #e8f7ee;
        color: #047857;
        font-size: 11px;
        padding: 6px 10px;
        border-radius: 999px;
        display: inline-flex;
        gap: 6px;
        align-items: center;
        font-weight: 600;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .payment-secure-badge i {
        font-size: 12px;
    }

    /* Montant mis en avant */
    .payment-amount-box {
        padding: 13px 12px 12px;
        border-radius: 14px;
        background: linear-gradient(135deg, #eef2ff, #f5f3ff);
        border: 1px solid rgba(129, 140, 248, 0.4);
        margin-bottom: 14px;
    }

    .payment-amount-box .label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: #6b7280;
    }

    .payment-amount-box .main-amount {
        font-size: 1.4rem;
        font-weight: 800;
        color: #111827;
        margin-top: 3px;
    }

    .payment-amount-box .currency {
        font-size: 0.8rem;
        margin-left: 4px;
        color: #4b5563;
    }

    .payment-amount-box .sub-text {
        font-size: 11px;
        color: #6b7280;
        margin-top: 2px;
        display: block;
    }

    .payment-methods-info {
        font-size: 13px;
        color: #4b5563;
        margin-bottom: 12px;
    }

    .payment-methods {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        margin-top: 10px;
    }

    .payment-method {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 10px 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        background: rgba(255, 255, 255, 0.85);
    }

    .payment-method:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 16px rgba(15, 23, 42, 0.12);
        border-color: var(--primary-color);
    }

    .payment-method.active {
        border-color: var(--primary-color);
        background-color: rgba(78, 102, 248, 0.05);
    }

    .payment-method i {
        font-size: 22px;
        margin-bottom: 4px;
        color: var(--primary-color);
    }

    .payment-method span {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #111827;
    }

    .payment-method small {
        font-size: 10px;
    }

    .payment-cta-box {
        border-top: 1px dashed #dee1f0;
        padding-top: 12px;
        margin-top: 6px;
    }

    .btn-full-width {
        width: 100%;
        justify-content: center;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .payment-btn-lg {
        padding-top: 9px;
        padding-bottom: 9px;
        border-radius: 999px;
        font-weight: 600;
        font-size: 14px;
    }

    .payment-small-text {
        font-size: 11px;
        color: #6b7280;
        margin-top: 8px;
    }

    .payment-footer-note {
        font-size: 11px;
        color: #4b5563;
        margin-top: 10px;
        background: #f7f9ff;
        padding: 8px 10px;
        border-radius: 8px;
    }

    .trust-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 12px;
        font-size: 10px;
        color: #6b7280;
    }

    .trust-badges span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f9fafb;
        border-radius: 999px;
        padding: 4px 8px;
        border: 1px dashed #e5e7eb;
    }

    /* RESPONSIVE */
    @media (max-width: 991.98px) {
        .sticky-sidebar {
            position: static;
            margin-top: 18px;
        }
    }

    @media (max-width: 767.98px) {
        .booking-summary {
            padding: 18px 14px;
        }

        .property-image {
            min-height: 140px;
        }

        .payment-steps {
            flex-wrap: wrap;
        }
    }
</style>
@endsection
