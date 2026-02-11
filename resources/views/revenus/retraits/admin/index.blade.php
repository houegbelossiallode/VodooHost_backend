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
                    <span>Gestion des retraits</span>
                </div>
                @include('partials/hearder2')
            </div>

            <div class="dasboard-wrapper fl-wrap no-pag">
                <!-- Filtres -->
                <div class="dasboard-opt fl-wrap">
                    <div class="dasboard-opt sl-opt fl-wrap">
                        <form method="GET" action="">
                            <div class="dashboard-search-listing">
                                <input type="text" name="q" onclick="this.select()"
                                    placeholder="Rechercher par utilisateur, compte ou titulaire" value="">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </div>

                            

                            <div class="price-opt">
                                <span class="price-opt-title">Mode :</span>
                                <div class="listsearch-input-item">
                                    <select name="mode" class="chosen-select no-search-select"
                                        onchange="this.form.submit()">
                                        <option value="">Tous</option>
                                        {{-- <option value="mobile_money" {{ $mode === 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                    <option value="card" {{ $mode === 'card' ? 'selected' : '' }}>Carte bancaire</option> --}}
                                    </select>
                                </div>
                            </div>
                        </form>
                        {{-- <a href="{{ route('hoost.admin.retraits.export', [
                            'q'      => $search,
                            'statut' => $statut,
                            'mode'   => $mode,
                        ]) }}"
                    class="btn color-bg"
                    style="margin-left: 10px;">
                        <i class="far fa-file-excel"></i> Exporter en Excel
                    </a> --}}
                    </div>
                </div>

                <!-- Liste -->
                <div class="dashboard-list-box fl-wrap">
                    <div class="dasboard-widget-title fl-wrap">
                        <h5><i class="fas fa-hand-holding-usd"></i> Demandes de retrait</h5>
                    </div>

                    @if ($retraits->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dashboard table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Utilisateur</th>
                                        <th>Montant</th>
                                        <th>Mode</th>
                                        <th>Coordonnées</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($retraits as $retrait)
                                        @php
                                            $user = $retrait->compte->user ?? null;

                                            $modeLabel =
                                                $retrait->methode === 'mobile_money'
                                                    ? 'Mobile Money'
                                                    : 'Carte bancaire';

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
                                                {{ $retrait->created_at->format('d/m/Y') }}<br>
                                                <small class="text-muted">{{ $retrait->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                @if ($user)
                                                    <strong>{{ $user->prenom }} {{ $user->nom }}</strong><br>
                                                    <small>{{ $user->email }}</small>
                                                @else
                                                    <em>Utilisateur supprimé</em>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ number_format($retrait->montant, 0, ',', ' ') }} FCFA</strong>
                                            </td>
                                            <td>
                                                <span class="mode-badge">
                                                    <i class="{{ $modeIcon }}"></i> {{ $modeLabel }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong>{{ $retrait->nom_titulaire }}</strong><br>
                                                <small>{{ $retrait->numero_compte }}</small>
                                            </td>
                                            <td>
                                                <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                                            </td>
                                            <td class="align-middle text-end">
                                                <div class="vh-action-dropdown">
                                                    <button type="button" class="vh-action-btn">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>

                                                    @if($retrait->statut == 'en_attente')
                                                    <div class="vh-action-menu">
                                                        {{-- VALIDER --}}
                                                        <form
                                                            action="{{ route('hoost.admin.retraits.updateStatut', $retrait) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="statut" value="valide">
                                                            <button type="submit" class="vh-action-item">
                                                                <i class="fa fa-check me-2"></i> VALIDER
                                                            </button>
                                                        </form>
                                                        <hr>
                                                        <hr>
                                                        {{-- REFUSER --}}
                                                        <form
                                                            action="{{ route('hoost.admin.retraits.updateStatut', $retrait) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <input type="hidden" name="statut" value="refuse">
                                                            <button type="submit" class="vh-action-item text-danger">
                                                                <i class="fa fa-times me-2"></i> REFUSER
                                                            </button>
                                                        </form>
                                                    
                                                        
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="pagination">
                        {{ $retraits->links() }}
                    </div> --}}
                    @else
                        <div class="dashboard-list-null">
                            <i class="far fa-file-alt"></i>
                            <h4>Aucune demande</h4>
                            <p>Aucune demande de retrait trouvée pour ces filtres.</p>
                        </div>
                    @endif
                </div>
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
