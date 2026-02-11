@extends('layouts.app')

@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Menu admin
        </div>

        <div class="container dasboard-container">
            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Transactions</span>
                </div>
                @include('partials/hearder2')
            </div>

            <div class="dasboard-wrapper fl-wrap no-pag">
                <!-- Filtres -->
                <div class="dasboard-opt fl-wrap">
                    <div class="dasboard-opt sl-opt fl-wrap">
                        <form method="GET" action="{{ route('hoost.transactions.index') }}">
                            <div class="dashboard-search-listing">
                                <input type="text" name="q" onclick="this.select()"
                                    placeholder="Rechercher par utilisateur, référence, compte..."
                                    value="{{ request('q') }}">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </div>

                            {{-- Filtre dates --}}
                            {{-- <div class="price-opt custom-form">
                              <div class="row">
                                <div class="col-sm-6">
                                    <p>Date d'arrivée</p>
                                    <div class="date-container fl-wrap">
                                        <input type="date" id="date_debut" placeholder="Date d'arrivée"
                                            style="padding-left: 16px;" name="date_debut"
                                            value="{{ request('date_debut') }}" required />
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <p>Date de départ</p>
                                    <div class="date-container fl-wrap">
                                        <input type="date" id="date_fin" placeholder="Date de fin" name="date_fin"
                                            value="{{ request('date_fin') }}" style="padding-left: 16px;" required />
                                    </div>
                                </div>

                              </div>

                            </div> --}}



                            {{-- Filtre mode (optionnel) --}}
                            <div class="price-opt">
                                <span class="price-opt-title">Type:</span>
                                <div class="listsearch-input-item">
                                    <select name="mode" class="chosen-select no-search-select"
                                        onchange="this.form.submit()">
                                        <option value="">Tous</option>
                                        <option value="retrait" {{ request('type') === 'retrait' ? 'selected' : '' }}>
                                            Retrait</option>
                                        <option value="credit" {{ request('type') === 'credit' ? 'selected' : '' }}>Crédit
                                        </option>
                                    </select>
                                </div>
                            </div>


                        </form>

                        {{-- Export Excel (reprend les filtres courants) --}}
                        {{-- <a href=""
                           class="btn color-bg"
                           style="margin-left: 10px;">
                            <i class="far fa-file-excel"></i> Exporter en Excel
                        </a> --}}
                    </div>
                </div>

                <!-- Liste -->
                <div class="dashboard-list-box fl-wrap">
                    <div class="dasboard-widget-title fl-wrap">
                        <h5><i class="fas fa-exchange-alt"></i> Liste des transactions</h5>
                    </div>

                    @if ($transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dashboard table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Utilisateur</th>
                                        <th>Type</th>
                                        <th>Montant</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($transactions as $trx)
                                        @php
                                            $user = $trx->compte->user;

                                            // Mode
                                            $modeLabel = match ($trx->mode ?? ($trx->methode ?? null)) {
                                                'mobile_money' => 'Mobile Money',
                                                'card' => 'Carte bancaire',
                                                'wallet' => 'Wallet',
                                                default => '—',
                                            };

                                            $modeIcon = match ($trx->mode ?? ($trx->methode ?? null)) {
                                                'mobile_money' => 'far fa-mobile-alt',
                                                'card' => 'far fa-credit-card',
                                                'wallet' => 'far fa-wallet',
                                                default => 'far fa-question-circle',
                                            };

                                            // Statut (adapte si tes statuts diffèrent)
                                            $statut = $trx->statut ?? 'en_attente';
                                            switch ($statut) {
                                                case 'success':
                                                case 'valide':
                                                case 'paid':
                                                    $statusClass = 'badge-status badge-success';
                                                    $statusLabel = 'Succès';
                                                    break;
                                                case 'failed':
                                                case 'refuse':
                                                    $statusClass = 'badge-status badge-danger';
                                                    $statusLabel = 'Échoué';
                                                    break;
                                                default:
                                                    $statusClass = 'badge-status badge-pending';
                                                    $statusLabel = 'En attente';
                                                    break;
                                            }

                                            // Type (ex: depot/retrait/paiement...)
                                            $typeLabel = ucfirst($trx->type ?? '—');
                                        @endphp

                                        <tr>
                                            <td>
                                                {{ optional($trx->created_at)->format('d/m/Y') }}<br>
                                                <small
                                                    class="text-muted">{{ optional($trx->created_at)->format('H:i') }}</small>
                                            </td>

                                            <td>
                                                @if ($user)
                                                    <strong>{{ $user->prenom ?? '' }} {{ $user->nom ?? '' }}</strong><br>
                                                    <small>{{ $user->email ?? '' }}</small>
                                                @else
                                                    <em>Utilisateur indisponible</em>
                                                @endif
                                            </td>

                                            {{-- <td>
                                                <strong>{{ $trx->reference ?? $trx->ref ?? $trx->uuid ?? '—' }}</strong>
                                                @if (!empty($trx->gateway))
                                                    <br><small class="text-muted">{{ strtoupper($trx->gateway) }}</small>
                                                @endif
                                            </td> --}}

                                            <td>
                                                <span class="mode-badge">
                                                    <i class="far fa-tag"></i> {{ $typeLabel }}
                                                </span>
                                            </td>

                                            <td>
                                                <strong>{{ number_format((float) ($trx->montant ?? 0), 0, ',', ' ') }}
                                                    FCFA</strong>
                                            </td>

                                            {{-- <td>
                                                <span class="mode-badge">
                                                    <i class="{{ $modeIcon }}"></i> {{ $modeLabel }}
                                                </span>
                                            </td> --}}

                                            {{-- <td>
                                                <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="dashboard-list-null">
                            <i class="far fa-file-alt"></i>
                            <h4>Aucune transaction</h4>
                            <p>Aucune transaction trouvée pour ces filtres.</p>
                        </div>
                    @endif
                </div>


                @if ($transactions->hasPages())
                    <div class="pagination">
                        {{-- Précédent --}}
                        @if ($transactions->onFirstPage())
                            <a href="javascript:void(0)" class="prevposts-link disabled">
                                <i class="fa fa-caret-left"></i>
                            </a>
                        @else
                            <a href="{{ $transactions->previousPageUrl() }}" class="prevposts-link">
                                <i class="fa fa-caret-left"></i>
                            </a>
                        @endif

                        {{-- Pages --}}
                        @for ($page = 1; $page <= $transactions->lastPage(); $page++)
                            @if ($page == $transactions->currentPage())
                                {{-- Page active : même structure que le template --}}
                                <a href="{{ $transactions->url($page) }}" class="current-page">
                                    {{ $page }}
                                </a>
                            @else
                                <a href="{{ $transactions->url($page) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endfor

                        {{-- Suivant --}}
                        @if ($transactions->hasMorePages())
                            <a href="{{ $transactions->nextPageUrl() }}" class="nextposts-link">
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
        </div>
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
    </style>
@endsection
