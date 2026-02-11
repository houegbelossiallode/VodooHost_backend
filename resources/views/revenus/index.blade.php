@extends('layouts.app')

@section('section')
    <div class="dashboard-content">
        <div class="container dasboard-container">

            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Mes revenus</span></div>
                <div class="d-flex align-items-center">
                    {{-- <a href="{{ route('hoost.retraits.historique') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-history me-1"></i> Historique des retraits
                    </a> --}}
                    @include('partials/hearder2')
                </div>
            </div>

        
            <div class="dasboard-wrapper fl-wrap">

                <!-- Solde -->
                <div class="dashboard-stats-container fl-wrap mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-wallet"></i>
                                <h4>Solde actuel</h4>
                                <div class="dashboard-stats-count">
                                    {{ number_format($compte->solde ?? 0, 0, ',', ' ') }} FCFA
                                </div>
                                {{-- @if(($compte->solde ?? 0) > 0)
                                    <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#retraitModal">
                                        <i class="fas fa-money-bill-wave"></i> Demander un retrait
                                    </button>
                                @endif --}}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-money-check-edit"></i>
                                <h4>Revenus cumulés</h4>
                                <div class="dashboard-stats-count">
                                    {{ number_format($revenusTotaux, 0, ',', ' ') }} FCFA
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-home"></i>
                                <h4>Nombre de logements</h4>
                                <div class="dashboard-stats-count">
                                    {{ $logements->count() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Liste des Réservations -->
                <div class="dashboard-widget-title fl-wrap d-flex justify-content-between align-items-center">
                    <span>Historique des revenus</span>
                    {{-- tu pourras mettre un filtre plus tard ici --}}
                    {{-- <button class="btn btn-sm btn-outline-secondary"><i class="fal fa-filter me-1"></i> Filtrer</button> --}}
                </div>

                <div class="dashboard-list-box fl-wrap revenues-table-wrapper">

                    @php $totalNet = 0; @endphp

                    @if($reservations->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle revenues-table">
                                <thead>
                                    <tr>
                                        <th>Logement</th>
                                        <th class="text-center">Période</th>
                                        <th class="text-end">Montant brut</th>
                                        <th class="text-end">Commission</th>
                                        <th class="text-end">Part projet</th>
                                        <th class="text-end">Revenu net</th>
                                        <th class="text-center">Date d’enregistrement</th>
                                        <th class="text-center">Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $res)
                                        @php
                                            $commission = $res->revenuPlateforme?->commission ?? 0;
                                            $partProjet = $res->revenuPlateforme?->part_projet ?? 0;
                                            $montantgenere = $res->montant - ($commission + $partProjet);
                                            $totalNet += $montantgenere;
                                        @endphp
                                        <tr>
                                            <td class="revenues-logement">
                                                <div class="d-flex flex-column">
                                                    <span class="revenues-logement-title">
                                                        <i class="fal fa-home me-1"></i>
                                                        {{ $res->logement->titre }}
                                                    </span>
                                                    <span class="revenues-logement-ref">
                                                        Réf. réservation #{{ $res->id }}
                                                    </span>
                                                </div>
                                            </td>

                                            <td class="text-center revenues-period">
                                                {{ \Carbon\Carbon::parse($res->date_debut)->format('d/m/Y') }}
                                                <span class="text-muted">→</span>
                                                {{ \Carbon\Carbon::parse($res->date_fin)->format('d/m/Y') }}
                                            </td>

                                            <td class="text-end">
                                                {{ number_format($res->montant, 0, ',', ' ') }} FCFA
                                            </td>

                                            <td class="text-end text-muted">
                                                {{ number_format($commission, 0, ',', ' ') }} FCFA
                                            </td>

                                            <td class="text-end text-muted">
                                                {{ number_format($partProjet, 0, ',', ' ') }} FCFA
                                            </td>

                                            <td class="text-end revenues-net">
                                                + {{ number_format($montantgenere, 0, ',', ' ') }} FCFA
                                            </td>

                                            <td class="text-center">
                                                <span class="revenues-date">
                                                    <i class="fal fa-calendar-week me-1"></i>
                                                    {{ $res->created_at->format('d M Y') }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="revenues-status-badge">
                                                    <i class="fal fa-check-circle me-1"></i> Complétée
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end fw-bold">
                                            Total des revenus nets :
                                        </td>
                                        <td class="text-end fw-bold revenues-total-net">
                                            {{ number_format($totalNet, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="dashboard-list empty-state">
                            <div class="dashboard-message text-center py-5">
                                <div class="empty-state-icon mb-3">
                                    <i class="fal fa-piggy-bank"></i>
                                </div>
                                <h5 class="mb-2">Aucun revenu pour l’instant</h5>
                                <p class="text-muted mb-0">
                                    Quand tes premières réservations seront confirmées,
                                    tu verras ici le détail de tes gains par logement.
                                </p>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>

<style>

/* Wrapper du tableau des revenus */
.revenues-table-wrapper {
    border-radius: 18px;
    padding: 10px 14px 16px;
    background: #ffffff;
    border: 1px solid rgba(148, 163, 184, 0.35);
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.06);
}

/* Tableau */
.revenues-table {
    margin-bottom: 0;
    font-size: 13px;
}

.revenues-table thead th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: .09em;
    color: #6b7280;
    border-bottom: 1px solid rgba(148, 163, 184, 0.6);
    background: #f9fafb;
    padding-top: 10px;
    padding-bottom: 10px;
}

.revenues-table tbody tr {
    transition: background 0.12s ease, transform 0.08s ease, box-shadow 0.12s ease;
}

.revenues-table tbody tr:hover {
    background: #f3f4ff;
    transform: translateY(-1px);
    box-shadow: 0 10px 18px rgba(148, 163, 184, 0.35);
}

/* Cellules */
.revenues-table td {
    vertical-align: middle;
    padding-top: 9px;
    padding-bottom: 9px;
    border-color: rgba(229, 231, 235, 0.8);
}

/* Colonne logement */
.revenues-logement-title {
    font-weight: 600;
    font-size: 13px;
    color: #111827;
}

.revenues-logement-ref {
    font-size: 11px;
    color: #9ca3af;
}

/* Période */
.revenues-period {
    font-size: 12px;
    color: #4b5563;
}

/* Montant net */
.revenues-net {
    font-weight: 700;
    color: #16a34a;
    font-size: 14px;
}

/* Total net en footer */
.revenues-total-net {
    font-size: 14px;
    color: #15803d;
}

/* Date */
.revenues-date {
    font-size: 12px;
    color: #4b5563;
    white-space: nowrap;
}

/* Badge statut */
.revenues-status-badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 9px;
    border-radius: 999px;
    font-size: 11px;
    background: rgba(22, 163, 74, 0.08);
    color: #15803d;
}

/* Empty state */
.empty-state {
    border-radius: 18px;
    border: 1px dashed rgba(148, 163, 184, 0.7);
    background: #f9fafb;
}

.empty-state-icon i {
    font-size: 40px;
    color: #D1B11B;
    opacity: 0.9;
}

</style>


@endsection
