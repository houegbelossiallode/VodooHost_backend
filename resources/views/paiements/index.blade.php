@extends('layouts.app')

@section('section')
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg">
        <span><i class="fas fa-bars"></i>Tableau de bord</span>
    </div>

    <div class="container dasboard-container">
        <!-- HEADER -->
        <div class="dashboard-title fl-wrap">
            <h3>Gestion des transactions</h3>
            <div class="dashboard-nav">
                <ul>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">Transactions</a></li>
                </ul>
            </div>
        </div>

        <div class="dasboard-wrapper fl-wrap">
            <!-- FILTRES -->
            <div class="dashboard-card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-filter"></i> Filtres</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('hoost.paiements.index') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Date de début</label>
                            <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date de fin</label>
                            <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Statut</label>
                            <select name="statut" class="form-select">
                                <option value="">Tous les statuts</option>
                                <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                <option value="paye" {{ request('statut') == 'paye' ? 'selected' : '' }}>Payé</option>
                                <option value="echec" {{ request('statut') == 'echec' ? 'selected' : '' }}>Échec</option>
                                <option value="annule" {{ request('statut') == 'annule' ? 'selected' : '' }}>Annulé</option>
                                <option value="rembourse" {{ request('statut') == 'rembourse' ? 'selected' : '' }}>Remboursé</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Méthode</label>
                            <select name="methode" class="form-select">
                                <option value="">Toutes les méthodes</option>
                                <option value="carte" {{ request('methode') == 'carte' ? 'selected' : '' }}>Carte bancaire</option>
                                <option value="mtn_mobile_money" {{ request('methode') == 'mtn_mobile_money' ? 'selected' : '' }}>MTN Mobile Money</option>
                                <option value="moov_money" {{ request('methode') == 'moov_money' ? 'selected' : '' }}>Moov Money</option>
                                <option value="fedapay" {{ request('methode') == 'fedapay' ? 'selected' : '' }}>Fedapay</option>
                                <option value="paypal" {{ request('methode') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="fas fa-search"></i> Filtrer
                            </button>
                            <a href="{{ route('hoost.paiements.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo"></i> Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- STATISTIQUES -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="dashboard-stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="stat-content">
                            <h6>Total des transactions</h6>
                            <h3>{{ $totalTransactions }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-stat-card">
                        <div class="stat-icon bg-success">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="stat-content">
                            <h6>Montant total</h6>
                            <h3>{{ number_format($totalMontant, 0, ',', ' ') }} FCFA</h3>
                        </div>
                    </div>
                </div>
                @if(request()->has('date_debut') || request()->has('date_fin'))
                <div class="col-md-4">
                    <div class="dashboard-stat-card bg-light">
                        <div class="stat-icon bg-info">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <div class="stat-content">
                            <h6>Période sélectionnée</h6>
                            <h3>{{ number_format($periodeMontant, 0, ',', ' ') }} FCFA</h3>
                            <small>
                                {{ request('date_debut') ? 'Du ' . \Carbon\Carbon::parse(request('date_debut'))->format('d/m/Y') : '' }}
                                {{ request('date_fin') ? 'au ' . \Carbon\Carbon::parse(request('date_fin'))->format('d/m/Y') : '' }}
                            </small>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- LISTE DES TRANSACTIONS -->
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="fas fa-list"></i> Liste des transactions</h5>
                    <div>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download"></i> Exporter
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Logement</th>
                                    <th class="text-end">Montant</th>
                                    <th>Méthode</th>
                                    <th>Statut</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                <tr>
                                    <td>#{{ $transaction->reference ?? 'N/A' }}</td>
                                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($transaction->reservation && $transaction->reservation->user)
                                            {{ $transaction->reservation->user->prenom }} {{ $transaction->reservation->user->nom }}
                                        @else
                                            Client inconnu
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->reservation && $transaction->reservation->logement)
                                            {{ $transaction->reservation->logement->titre }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold">{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        @php
                                            $methodIcons = [
                                                'carte' => 'credit-card',
                                                'mtn_mobile_money' => 'mobile-alt',
                                                'moov_money' => 'mobile-alt',
                                                'fedapay' => 'wallet',
                                                'paypal' => 'paypal',
                                                'virement' => 'university',
                                                'especes' => 'money-bill-wave'
                                            ];
                                            $icon = $methodIcons[$transaction->methode] ?? 'money-bill-wave';
                                        @endphp
                                        <i class="fas fa-{{ $icon }} me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $transaction->methode)) }}
                                    </td>
                                    <td>
                                        @php
                                            $statusClasses = [
                                                'en_attente' => 'warning',
                                                'paye' => 'success',
                                                'echec' => 'danger',
                                                'annule' => 'secondary',
                                                'rembourse' => 'info',
                                                'en_traitement' => 'primary'
                                            ];
                                            $statusLabels = [
                                                'en_attente' => 'En attente',
                                                'paye' => 'Payé',
                                                'echec' => 'Échec',
                                                'annule' => 'Annulé',
                                                'rembourse' => 'Remboursé',
                                                'en_traitement' => 'En traitement'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusClasses[$transaction->statut] ?? 'secondary' }}">
                                            {{ $statusLabels[$transaction->statut] ?? ucfirst($transaction->statut) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#transactionModal{{ $transaction->id }}">
                                                        <i class="fas fa-eye me-2"></i> Détails
                                                    </a>
                                                </li>
                                                @if($transaction->statut === 'en_attente' || $transaction->statut === 'en_traitement')
                                                <li>
                                                    <a class="dropdown-item text-success" href="#" onclick="return confirm('Confirmer le paiement de cette transaction ?')">
                                                        <i class="fas fa-check-circle me-2"></i> Valider
                                                    </a>
                                                </li>
                                                @endif
                                                @if(in_array($transaction->statut, ['paye', 'en_traitement']))
                                                <li>
                                                    <a class="dropdown-item text-warning" href="#">
                                                        <i class="fas fa-undo me-2"></i> Rembourser
                                                    </a>
                                                </li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette transaction ?')">
                                                        <i class="fas fa-times-circle me-2"></i> Annuler
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Détails de la transaction -->
                                <div class="modal fade" id="transactionModal{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Détails de la transaction #{{ $transaction->reference }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted mb-3">Informations de la transaction</h6>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Référence:</span>
                                                                <strong>#{{ $transaction->reference ?? 'N/A' }}</strong>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Date:</span>
                                                                <span>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Méthode:</span>
                                                                <span>
                                                                    <span class="badge bg-light text-dark">
                                                                        <i class="fas fa-{{ $icon }} me-1"></i>
                                                                        {{ ucfirst(str_replace('_', ' ', $transaction->methode)) }}
                                                                    </span>
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Statut:</span>
                                                                <span class="badge bg-{{ $statusClasses[$transaction->statut] ?? 'secondary' }}">
                                                                    {{ $statusLabels[$transaction->statut] ?? ucfirst($transaction->statut) }}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Montant:</span>
                                                                <strong class="h5 mb-0 text-primary">
                                                                    {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                                                                </strong>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="text-muted mb-3">Détails de la réservation</h6>
                                                        @if($transaction->reservation)
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Référence:</span>
                                                                <strong>#{{ $transaction->reservation->reference ?? 'N/A' }}</strong>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Logement:</span>
                                                                <span>{{ $transaction->reservation->logement->titre ?? 'N/A' }}</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Période:</span>
                                                                <span>
                                                                    {{ $transaction->reservation->date_debut->format('d/m/Y') ?? 'N/A' }}
                                                                    <i class="fas fa-arrow-right mx-2 text-muted"></i>
                                                                    {{ $transaction->reservation->date_fin->format('d/m/Y') ?? 'N/A' }}
                                                                </span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Nuits:</span>
                                                                <span>{{ $transaction->reservation->nuits ?? 'N/A' }} nuit(s)</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                                                <span>Voyageurs:</span>
                                                                <span>{{ $transaction->reservation->voyageurs ?? '1' }} personne(s)</span>
                                                            </li>
                                                        </ul>
                                                        @else
                                                        <div class="alert alert-warning">
                                                            Aucune réservation associée à cette transaction.
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                <a href="#" class="btn btn-primary">
                                                    <i class="fas fa-print me-2"></i>Imprimer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p class="mb-0">Aucune transaction trouvée</p>
                                            <small>Essayez de modifier vos critères de recherche</small>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Affichage de {{ $transactions->firstItem() }} à {{ $transactions->lastItem() }} sur {{ $transactions->total() }} transactions
                        </div>
                        <div>
                            {{ $transactions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-stat-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        height: 100%;
        transition: all 0.3s ease;
    }

    .dashboard-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: rgba(78, 102, 248, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #4e66f8;
        font-size: 24px;
    }

    .stat-icon.bg-success {
        background: rgba(40, 199, 111, 0.1);
        color: #28c76f;
    }

    .stat-icon.bg-info {
        background: rgba(0, 207, 232, 0.1);
        color: #00cfe8;
    }

    .stat-content h6 {
        color: #6e6b7b;
        margin-bottom: 5px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .stat-content h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
        color: #5d596c;
    }

    .table th {
        font-weight: 600;
        color: #5d596c;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-top: none;
        padding: 1rem 1.5rem;
        background-color: #f8f8f8;
    }

    .table td {
        padding: 1rem 1.5rem;
        vertical-align: middle;
    }

    .badge {
        padding: 0.4em 0.8em;
        font-weight: 500;
        border-radius: 4px;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 25px rgba(34, 41, 47, 0.1);
        border-radius: 8px;
        padding: 10px 0;
    }

    .dropdown-item {
        padding: 8px 20px;
        font-size: 0.9rem;
        color: #5d596c;
    }

    .dropdown-item:hover {
        background-color: #f8f8f8;
        color: #4e66f8;
    }

    .modal-header {
        border-bottom: 1px solid #e9e9e9;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #e9e9e9;
        padding: 1.25rem 1.5rem;
    }

    .list-group-item {
        border: none;
        border-bottom: 1px solid #f5f5f5;
        padding: 0.75rem 0;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }

    .pagination {
        margin-bottom: 0;
    }

    .page-item.active .page-link {
        background-color: #4e66f8;
        border-color: #4e66f8;
    }

    .page-link {
        color: #4e66f8;
        border: 1px solid #e9e9e9;
        padding: 0.5rem 0.9rem;
        margin: 0 3px;
        border-radius: 6px !important;
    }

    .page-link:hover {
        color: #3a50d9;
        background-color: #f5f5f5;
        border-color: #e9e9e9;
    }

    .form-select, .form-control {
        border-radius: 8px;
        padding: 0.6rem 1rem;
        border: 1px solid #e9e9e9;
        font-size: 0.9rem;
    }

    .form-select:focus, .form-control:focus {
        border-color: #4e66f8;
        box-shadow: 0 0 0 0.25rem rgba(78, 102, 248, 0.1);
    }

    .btn {
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }

    .btn-primary {
        background-color: #4e66f8;
        border-color: #4e66f8;
    }

    .btn-primary:hover {
        background-color: #3a50d9;
        border-color: #3a50d9;
    }

    .btn-outline-primary {
        color: #4e66f8;
        border-color: #4e66f8;
    }

    .btn-outline-primary:hover {
        background-color: #4e66f8;
        border-color: #4e66f8;
    }

    .btn-outline-secondary {
        color: #6e6b7b;
        border-color: #e9e9e9;
    }

    .btn-outline-secondary:hover {
        background-color: #f5f5f5;
        border-color: #e9e9e9;
        color: #5d596c;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #e9e9e9;
        padding: 1.25rem 1.5rem;
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
    }

    .dashboard-card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .dashboard-card .card-body {
        padding: 0;
    }

    .dashboard-card .card-footer {
        padding: 1.25rem 1.5rem;
        background-color: #fff;
        border-top: 1px solid #e9e9e9;
    }

    @media (max-width: 768px) {
        .dashboard-stat-card {
            margin-bottom: 1rem;
        }

        .table-responsive {
            border: none;
        }
    }
</style>

<!-- Modal d'exportation -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exporter les transactions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exportForm" method="POST" action="{{ route('hoost.paiements.export') }}">
                    @csrf
                    <input type="hidden" name="date_debut" value="{{ request('date_debut') }}">
                    <input type="hidden" name="date_fin" value="{{ request('date_fin') }}">
                    <input type="hidden" name="statut" value="{{ request('statut') }}">
                    <input type="hidden" name="methode" value="{{ request('methode') }}">

                    <div class="mb-3">
                        <label class="form-label">Format d'exportation</label>
                        <select name="format" class="form-select" required>
                            <option value="xlsx">Excel (.xlsx)</option>
                            <option value="csv">CSV (.csv)</option>
                            <option value="pdf">PDF (.pdf)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Colonnes à inclure</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="colReference" name="columns[reference]" checked>
                            <label class="form-check-label" for="colReference">
                                Référence
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="colDate" name="columns[date]" checked>
                            <label class="form-check-label" for="colDate">
                                Date
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="colClient" name="columns[client]" checked>
                            <label class="form-check-label" for="colClient">
                                Client
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="colLogement" name="columns[logement]" checked>
                            <label class="form-check-label" for="colLogement">
                                Logement
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="colMontant" name="columns[montant]" checked>
                            <label class="form-check-label" for="colMontant">
                                Montant
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="colMethode" name="columns[methode]" checked>
                            <label class="form-check-label" for="colMethode">
                                Méthode
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="colStatut" name="columns[statut]" checked>
                            <label class="form-check-label" for="colStatut">
                                Statut
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="exportForm" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Exporter
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    // Initialisation des tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Initialisation des popovers
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });

    // Gestion de l'exportation
    document.getElementById('exportBtn').addEventListener('click', function(e) {
        e.preventDefault();
        var exportModal = new bootstrap.Modal(document.getElementById('exportModal'));
        exportModal.show();
    });

    // Confirmation avant suppression
    function confirmDelete() {
        return confirm('Êtes-vous sûr de vouloir supprimer cette transaction ? Cette action est irréversible.');
    }
</script>


@endsection


