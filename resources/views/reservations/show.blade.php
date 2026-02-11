@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-{{ $reservation->statut === 'confirmee' ? 'success' : ($reservation->statut === 'annulee' ? 'danger' : 'warning') }} text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Réservation #{{ $reservation->id }}</h4>
                        <span class="badge bg-light text-dark">{{ ucfirst($reservation->statut) }}</span>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Détails du séjour</h5>
                            <p class="mb-1"><strong>Logement :</strong> {{ $reservation->logement->titre }}</p>
                            <p class="mb-1">
                                <strong>Dates :</strong> 
                                {{ $reservation->date_debut->format('d/m/Y') }} - {{ $reservation->date_fin->format('d/m/Y') }}
                                ({{ $reservation->date_debut->diffInDays($reservation->date_fin) }} nuits)
                            </p>
                            <p class="mb-1"><strong>Voyageurs :</strong> {{ $reservation->nombre_voyageurs }} personne(s)</p>
                            <p class="mb-1">
                                <strong>Prix total :</strong> 
                                {{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA
                            </p>
                            
                            @if($reservation->mode_paiement === 'acompte')
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Vous avez choisi de payer un acompte de 30%. 
                                    Le solde de {{ number_format($reservation->montant_total * 0.7, 0, ',', ' ') }} FCFA 
                                    sera à régler sur place.
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Projet soutenu</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $reservation->contribution->projet->nom }}</h6>
                                    <p class="card-text">{{ $reservation->contribution->projet->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-primary">
                                            Contribution : {{ number_format($reservation->montant_total * 0.05, 0, ',', ' ') }} FCFA
                                        </span>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Voir le projet</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Paiements</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Méthode</th>
                                        <th>Statut</th>
                                        <th>Référence</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($reservation->paiements as $paiement)
                                        <tr>
                                            <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                            <td>{{ ucfirst($paiement->methode) }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = [
                                                        'en_attente' => 'bg-warning',
                                                        'paye' => 'bg-success',
                                                        'annule' => 'bg-danger',
                                                        'erreur' => 'bg-danger',
                                                    ][$paiement->statut] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}
                                                </span>
                                            </td>
                                            <td>{{ $paiement->reference }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Aucun paiement enregistré</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        @if($reservation->statut === 'en_attente_paiement' && $reservation->paiements->where('statut', 'paye')->isEmpty())
                            <div class="text-center mt-3">
                                <a href="{{ route('hoost.paiements.create', $reservation) }}" class="btn btn-primary">
                                    <i class="fas fa-credit-card me-2"></i>Payer maintenant
                                </a>
                            </div>
                        @endif
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('hoost.home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour à l'accueil
                        </a>
                        
                        @if($reservation->statut === 'en_attente_paiement' || $reservation->statut === 'confirmee')
                            <form action="{{ route('hoost.reservations.cancel', $reservation) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-times me-2"></i>Annuler la réservation
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
