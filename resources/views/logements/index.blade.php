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
                <div class="dashboard-title-item">
                    <span>Gestion des logements</span>
                </div>
                @include('partials/hearder2')
            </div>
            <!-- Titre dashboard end -->

            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5><i class="fa fa-home"></i> Liste des logements</h5>
                <a href="{{ route('hoost.logements.create') }}" class="btn color-bg float-btn" style="margin-left: auto;">
                    <i class="fa fa-plus me-1"></i> Ajouter un logement
                </a>
            </div>

            <div class="dasboard-widget-box fl-wrap">


                @if ($logements->count() === 0)
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i> Aucun logement enregistré pour le moment.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 120px;">Photo</th>
                                    <th>Description</th>
                                    <th>Informations</th>
                                    <th>Prix</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($logements as $logement)
                                    @php
                                        $firstPhoto =
                                            optional($logement->photos->first())->url ??
                                            asset('images/default-house.jpg');
                                    @endphp
                                    <tr>
                                        <!-- Colonne Photo -->
                                        <td class="align-middle">
                                            <div class="position-relative"
                                                style="width: 100px; height: 70px; overflow: hidden; border-radius: 8px;">
                                                <img src="{{ $firstPhoto }}" alt="{{ $logement->titre }}"
                                                    class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">

                                            </div>
                                        </td>

                                        <!-- Colonne Description -->
                                        <td class="align-middle">
                                            <div class="desc-col">
                                                <span class="desc-title" >{{ $logement->titre }}</span>
                                                <span class="desc-text">{{ Str::limit($logement->description, 80) }}</span>
                                            </div>
                                        </td>


                                        <!-- Colonne Informations -->
                                        <td class="align-middle">
                                            <div class="info-block">
                                                <div class="info-row">
                                                    <i class="fa fa-map-marker-alt"></i>
                                                    <span>{{ $logement->quartier->libelle ?? 'AUCUN'}}</span>
                                                </div>

                                                <div class="info-row">
                                                    <i class="fa fa-home"></i>
                                                    <span>{{ $logement->typelogement->libelle ?? 'Type non défini' }}</span>
                                                </div>

                                                <div class="info-row">
                                                    <i class="fa fa-users"></i>
                                                    <span>Max. {{ $logement->nb_voyageur_max }} personnes</span>
                                                </div>
                                            </div>
                                        </td>


                                        <td class="align-middle">
                                            <div style="white-space: nowrap;">
                                                <span style="font-size:13px;" class="fw-bold text-primary">
                                                   {{ format_price($logement->prix_par_nuit) }} /
                                                </span>
                                                <div class="small text-muted">par nuit</div>
                                            </div>
                                        </td>

                                        <td class="align-middle text-end">
                                            <div class="vh-action-dropdown">
                                                <button type="button" class="vh-action-btn">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="vh-action-menu">
                                                    <a href="{{ route('hoost.logements.edit', $logement) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a>

                                                    <a href="{{ route('hoost.logements.equipements.edit', $logement) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-bezier-curve me-2"></i> Affecter équipements
                                                    </a>

                                                    <a href="{{ route('hoost.logements.rituels.edit', $logement) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-anchor me-2"></i> Affecter rituels
                                                    </a>

                                                    <a href="{{ route('hoost.logements.divinites.edit', $logement) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-fighter-jet me-2"></i> Affecter divinités
                                                    </a>

                                                    <a href="{{ route('hoost.logements.dejeuners.edit', $logement) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-fighter-jet me-2"></i> Affecter petits déjeuners
                                                    </a>

                                                    <a href="{{ route('hoost.logements.reglements.index', $logement) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-key me-2"></i>Règlements
                                                    </a>

                                                    <a href="{{ route('hoost.logements.disponibilites.index', $logement) }}"
                                                        class="vh-action-item">
                                                        <i class=" fa fa-calendar me-2"></i>Gérer disponibilité
                                                    </a>

                                                    <form action="{{ route('hoost.logements.destroy', $logement) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Confirmer la suppression de ce logement ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="vh-action-item vh-action-danger">
                                                            <i class="fa fa-trash me-2"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- content end -->
    <div class="dashbard-bg gray-bg"></div>



@endsection
