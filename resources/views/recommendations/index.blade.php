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
                <span>Recommandations culturelles</span>
            </div>
            @include('partials/hearder2')
        </div>
        <!-- dashboard-title end -->

        <!-- dashboard-content-wrap -->
        <div class="dashboard-content-wrap">
            <!-- Titre widget -->
            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5 class="page-title">
                    <i class="fas fa-home"></i>
                    Logements recommandés pour vous
                </h5>
                <span class="property-title">
                    Profil : <strong>{{ $user->nom ?? 'Visiteur' }}</strong>
                </span>
            </div>

            <div class="dashboard-list-box fl-wrap">

                {{-- @if(!$preference)
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Vous n'avez pas encore renseigné vos préférences culturelles.
                        <a href="" class="color-bg" style="padding:4px 10px;border-radius:20px;margin-left:8px;">
                            Compléter le questionnaire
                        </a>
                    </div>
                @elseif($logements->isEmpty())
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        Aucun logement ne correspond encore à vos préférences. Essayez d’ajuster vos divinités préférées.
                    </div> --}}
                @if($logements)
                    {{-- Grille des logements recommandés --}}
                    <div class="equipments-grid">
                        @foreach($logements as $logement)
                            @php
                                $photo = optional($logement->photos->first())->url;
                            @endphp

                            <div class="equipment-card logement-card">
                                {{-- Image --}}
                                <div class="rituel-icon">
                                    <img src="{{ $photo ? asset($photo) : asset('images/default-logement.jpg') }}"
                                         alt="{{ $logement->titre }}"
                                         class="rituel-symbole-img"
                                         loading="lazy">
                                </div>

                                {{-- Infos logement --}}
                                <div class="logement-info">
                                    <div class="logement-title">
                                        {{ $logement->titre }}
                                    </div>
                                    <div class="logement-address">
                                        {{ $logement->adresse }}
                                    </div>

                                    {{-- Divinités associées (tags) --}}
                                    @if($logement->divinites->count())
                                        <div class="logement-divinites">
                                            @foreach($logement->divinites as $d)
                                                <span class="divinite-tag">
                                                    {{ $d->nom }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- Bouton voir --}}
                                <div class="logement-actions">
                                    <a href="{{ route('hoost.logements.show', $logement->id) }}" class="btn color-bg view-btn">
                                        Voir
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                   
                @endif

            </div>
        </div>
        <!-- dashboard-content-wrap end -->
    </div>
    <!-- content end -->
</div>
<!-- dashboard content end -->

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

    /* On réutilise les styles "equipments-grid" et "equipment-card" déjà définis
       dans ta vue de questionnaire pour garder le même rendu */

    .logement-card {
        align-items: stretch;
    }

    .logement-info {
        flex: 1;
        min-width: 0;
    }

    .logement-title {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .logement-address {
        font-size: 0.85rem;
        color: #777;
        margin-bottom: 6px;
    }

    .logement-divinites {
        margin-top: 4px;
    }

    .divinite-tag {
        display: inline-block;
        background: #f1f3f5;
        border-radius: 999px;
        padding: 2px 8px;
        font-size: 0.78rem;
        color: #555;
        margin-right: 4px;
        margin-top: 2px;
    }

    .logement-actions {
        display: flex;
        align-items: center;
        margin-left: 0.8rem;
    }

    .view-btn {
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .equipment-card.logement-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.6rem;
        }

        .logement-actions {
            margin-left: 0;
        }

        .view-btn {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection
