@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Tableau de bord
        </div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Historique des retraits</span>
                </div>
                <div class="dashbard-menu-header">
                    <div class="dashbard-menu-avatar fl-wrap">
                        <img src="{{ auth()->user()->avatar_url ?? asset('assets/images/avatar/1.jpg') }}" alt="">
                        <h4>Bonjour, <span>{{ auth()->user()->prenom }}</span></h4>
                    </div>
                    <a href="{{ route('hoost.retraits.create') ?? '#' }}" class="log-out-btn tolt"
                        data-microtip-position="bottom" data-tooltip="Faire une demande de retrait">
                        <i class="far fa-plus-circle"></i>
                    </a>
                </div>
            </div>
            <!-- dashboard-title end -->

            <div class="dasboard-wrapper fl-wrap no-pag">
                <!-- Résumé solde -->
                <div class="dashboard-stats-container fl-wrap mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-wallet"></i>
                                <h4>Solde disponible</h4>
                                <div class="dashboard-stats-count">
                                    {{ number_format($solde, 0, ',', ' ') }} FCFA
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-hand-holding-usd"></i>
                                <h4>Total retiré</h4>
                                <div class="dashboard-stats-count">
                                    {{ number_format($retraits->where('statut', 'valide')->sum('montant'), 0, ',', ' ') }}
                                    FCFA
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-hand-holding-usd"></i>
                                <h4>Recette totale</h4>
                                @php
                                    $retrait = $retraits->where('statut', 'valide')->sum('montant');
                                    $recette = $solde + $retrait;
                                @endphp
                                <div class="dashboard-stats-count">
                                    {{ number_format($recette, 0, ',', ' ') }} FCFA
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtres -->
                <div class="dasboard-opt fl-wrap">
                    <div class="dasboard-opt sl-opt fl-wrap">
                        <form method="GET" action="{{ route('hoost.retraits.index') }}">
                            <div class="dashboard-search-listing">
                                <input type="text" name="q" onclick="this.select()"
                                    placeholder="Rechercher par référence ou méthode">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </div>

                            <div class="price-opt">
                                <span class="price-opt-title">Filtrer par statut :</span>
                                <div class="listsearch-input-item">
                                    <select name="statut" class="chosen-select no-search-select"
                                        onchange="this.form.submit()">
                                        <option value="">Tous les statuts</option>
                                        <option value="en_attente" {{ $statut === 'en_attente' ? 'selected' : '' }}>
                                            En attente
                                        </option>
                                        <option value="valide" {{ $statut === 'valide' ? 'selected' : '' }}>
                                            Validé
                                        </option>
                                        <option value="refuse" {{ $statut === 'refuse' ? 'selected' : '' }}>
                                            Refusé
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- dashboard-list-box -->
                <div class="dashboard-list-box fl-wrap">
                    <div class="dasboard-widget-title fl-wrap">
                        <h5><i class="fas fa-money-check-alt"></i> Mes retraits</h5>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-dashboard table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Référence</th>
                                    <th>Montant</th>
                                    <th>Mode</th>
                                    <th>Destinataire</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($retraits as $retrait)
                                    @php
                                        $modeLabel =
                                            $retrait->methode === 'mobile_money' ? 'Mobile Money' : 'Carte bancaire';

                                        $modeIcon =
                                            $retrait->methode === 'mobile_money'
                                                ? 'far fa-mobile-alt'
                                                : 'far fa-credit-card';

                                        switch ($retrait->statut) {
                                            case 'valide':
                                                $statusClass = 'badge-status badge-success';
                                                $statusLabel = 'Validé';
                                                break;
                                            case 'refuse':
                                                $statusClass = 'badge-status badge-danger';
                                                $statusLabel = 'Refusé';
                                                break;
                                            default:
                                                $statusClass = 'badge-status badge-pending';
                                                $statusLabel = 'En attente';
                                                break;
                                        }
                                    @endphp

                                    <tr>
                                        <td>
                                            {{ $retrait->created_at->format('d/m/Y') }}
                                            <br>
                                            <small class="text-muted">
                                                {{ $retrait->created_at->format('H:i') }}
                                            </small>
                                        </td>
                                        <td>#{{ $retrait->id }}</td>
                                        <td>
                                            <strong>{{ number_format($retrait->montant, 0, ',', ' ') }} FCFA</strong>
                                        </td>
                                        <td>
                                            <span class="badge-pending mode-badge">
                                                <i class="{{ $modeIcon }}"></i>
                                                {{ $modeLabel }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="destinataire">
                                                <strong>{{ $retrait->nom_titulaire ?? '-' }}</strong><br>
                                                <small>{{ $retrait->numero_compte }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    @if ($retraits->hasPages())
                        <div class="pagination">
                            {{-- Précédent --}}
                            @if ($retraits->onFirstPage())
                                <a href="javascript:void(0)" class="prevposts-link disabled">
                                    <i class="fa fa-caret-left"></i>
                                </a>
                            @else
                                <a href="{{ $retraits->previousPageUrl() }}" class="prevposts-link">
                                    <i class="fa fa-caret-left"></i>
                                </a>
                            @endif

                            {{-- Pages --}}
                            @for ($page = 1; $page <= $retraits->lastPage(); $page++)
                                @if ($page == $retraits->currentPage())
                                    <a href="{{ $retraits->url($page) }}" class="current-page">
                                        {{ $page }}
                                    </a>
                                @else
                                    <a href="{{ $retraits->url($page) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endfor

                            {{-- Suivant --}}
                            @if ($retraits->hasMorePages())
                                <a href="{{ $retraits->nextPageUrl() }}" class="nextposts-link">
                                    <i class="fa fa-caret-right"></i>
                                </a>
                            @else
                                <a href="javascript:void(0)" class="nextposts-link disabled">
                                    <i class="fa fa-caret-right"></i>
                                </a>
                            @endif
                        </div>
                    @endif

                </div>
                <!-- dashboard-list-box end-->
            </div>
        </div>

        <div class="limit-box fl-wrap"></div>
    </div>

    <style>
        .table-dashboard {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .table-dashboard thead tr {
            background: #f5f7ff;
        }

        .table-dashboard th,
        .table-dashboard td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table-dashboard tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .table-dashboard tbody tr:hover {
            background: #f3f6ff;
        }

        .badge-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-success {
            background: #d4f5e3;
            color: #1c9c60;
        }

        .badge-danger {
            background: #ffd7d7;
            color: #d93025;
        }

        .badge-pending {
            background: #fff2cc;
            color: #a07800;
        }

        .mode-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            background: #eef1ff;
            padding: 4px 10px;
            border-radius: 999px;
            color: #a07800;
        }

        .mode-badge i {
            font-size: 14px;
        }

        .dashboard-list-null {
            text-align: center;
            padding: 50px 20px;
        }

        .dashboard-list-null i {
            font-size: 50px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .dashboard-list-null h4 {
            font-size: 18px;
            color: #444;
            margin-bottom: 10px;
        }

        .dashboard-list-null p {
            color: #999;
            font-size: 14px;
        }
    </style>
@endsection
