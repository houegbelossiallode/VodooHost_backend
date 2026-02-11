@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Paiement de votre réservation #{{ $reservation->id }}</h4>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        @if($reservation->mode_paiement === 'acompte')
                            Vous allez effectuer un acompte de <strong>{{ number_format($reservation->montant_total * 0.3, 0, ',', ' ') }} FCFA</strong>.
                            Le solde de <strong>{{ number_format($reservation->montant_total * 0.7, 0, ',', ' ') }} FCFA</strong> sera à régler sur place.
                        @else
                            Montant total à payer : <strong>{{ number_format($reservation->montant_total, 0, ',', ' ') }} FCFA</strong>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <h5>Détails de la réservation</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Logement :</strong> {{ $reservation->logement->titre }}</p>
                                <p class="mb-1"><strong>Dates :</strong> 
                                    {{ $reservation->date_debut->format('d/m/Y') }} - {{ $reservation->date_fin->format('d/m/Y') }}
                                    ({{ $reservation->date_debut->diffInDays($reservation->date_fin) }} nuits)
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Voyageurs :</strong> {{ $reservation->nombre_voyageurs }} personne(s)</p>
                                <p class="mb-1"><strong>Projet soutenu :</strong> {{ $reservation->contribution->projet->nom }}</p>
                                <p class="mb-1"><strong>Contribution :</strong> {{ number_format($reservation->montant_total * 0.05, 0, ',', ' ') }} FCFA</p>
                            </div>
                        </div>
                    </div>
                    
                    <form id="payment-form" action="{{ route('hoost.paiements.store', $reservation) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <h5>Méthode de paiement</h5>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mode_paiement" id="carte" value="carte" checked>
                                    <label class="form-check-label" for="carte">
                                        <i class="fas fa-credit-card me-2"></i>Carte bancaire
                                    </label>
                                </div>
                                <div id="carte-details" class="mt-3 p-3 border rounded bg-light">
                                    <div class="mb-3">
                                        <label class="form-label">Numéro de carte</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456" data-fedapay="card.number">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Date d'expiration</label>
                                            <input type="text" class="form-control" placeholder="MM/AA" data-fedapay="card.expiry">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">CVV</label>
                                            <input type="text" class="form-control" placeholder="123" data-fedapay="card.cvc">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nom sur la carte</label>
                                        <input type="text" class="form-control" placeholder="NOM PRENOM" data-fedapay="card.name">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mode_paiement" id="mtn" value="mtn">
                                    <label class="form-check-label" for="mtn">
                                        <img src="{{ asset('images/mtn.png') }}" alt="MTN Mobile Money" style="height: 24px;" class="me-2">
                                        MTN Mobile Money
                                    </label>
                                </div>
                                <div id="mtn-details" class="mt-3 p-3 border rounded bg-light d-none">
                                    <div class="mb-3">
                                        <label class="form-label">Numéro de téléphone MTN</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+229</span>
                                            <input type="tel" name="telephone" class="form-control" placeholder="XX XX XX XX">
                                        </div>
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Vous recevrez une demande de paiement sur votre téléphone pour confirmer la transaction.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="mode_paiement" id="moov" value="moov">
                                    <label class="form-check-label" for="moov">
                                        <img src="{{ asset('images/moov.png') }}" alt="Moov Money" style="height: 24px;" class="me-2">
                                        Moov Money
                                    </label>
                                </div>
                                <div id="moov-details" class="mt-3 p-3 border rounded bg-light d-none">
                                    <div class="mb-3">
                                        <label class="form-label">Numéro de téléphone Moov</label>
                                        <div class="input-group">
                                            <span class="input-group-text">+229</span>
                                            <input type="tel" name="telephone_moov" class="form-control" placeholder="XX XX XX XX">
                                        </div>
                                    </div>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i> Vous recevrez une demande de paiement sur votre téléphone pour confirmer la transaction.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg" id="submit-payment">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                Payer maintenant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script src="https://s3-us-west-2.amazonaws.com/cdn.fedapay.com/checkout.js?v=1.1.7"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de l'affichage des détails de paiement
        const paymentMethods = document.querySelectorAll('input[name="mode_paiement"]');
        
        paymentMethods.forEach(method => {
            method.addEventListener('change', function() {
                // Cacher tous les détails
                document.querySelectorAll('[id$="-details"]').forEach(el => {
                    el.classList.add('d-none');
                });
                
                // Afficher les détails de la méthode sélectionnée
                const detailsId = this.id + '-details';
                const detailsEl = document.getElementById(detailsId);
                if (detailsEl) {
                    detailsEl.classList.remove('d-none');
                }
            });
        });
        
        // Initialiser FedaPay
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-payment');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedMethod = document.querySelector('input[name="mode_paiement"]:checked').value;
            
            // Désactiver le bouton et afficher le spinner
            submitButton.disabled = true;
            submitButton.querySelector('.spinner-border').classList.remove('d-none');
            
            if (selectedMethod === 'carte') {
                // Paiement par carte avec FedaPay
                const formData = new FormData(form);
                
                // Créer un token de carte
                FedaPay.token.create(form, {
                    card: {
                        number: document.querySelector('[data-fedapay="card.number"]').value,
                        expiry_month: document.querySelector('[data-fedapay="card.expiry"]').value.split('/')[0],
                        expiry_year: '20' + document.querySelector('[data-fedapay="card.expiry"]').value.split('/')[1],
                        cvc: document.querySelector('[data-fedapay="card.cvc"]').value,
                        name: document.querySelector('[data-fedapay="card.name"]').value
                    }
                }, function(result) {
                    if (result.error) {
                        // Afficher l'erreur
                        alert('Erreur: ' + result.error.message);
                        submitButton.disabled = false;
                        submitButton.querySelector('.spinner-border').classList.add('d-none');
                    } else {
                        // Ajouter le token au formulaire et soumettre
                        const token = document.createElement('input');
                        token.type = 'hidden';
                        token.name = 'fedapayToken';
                        token.value = result.token;
                        form.appendChild(token);
                        
                        // Soumettre le formulaire
                        form.submit();
                    }
                });
            } else {
                // Paiement mobile (MTN ou Moov)
                form.submit();
            }
        });
    });
</script>
