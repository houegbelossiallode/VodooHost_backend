@extends('layouts.app')

@section('section')
<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title">Nouvelle réservation - {{ $logement->titre }}</div>
    </div>

    <div class="ibox-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('hoost.reservations.store', $logement->id) }}" method="POST" id="reservationForm">
            @csrf

            <div class="row">
                <!-- Colonne de gauche - Détails de la réservation -->
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="form-label">Dates du séjour</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" class="form-control"
                                   value="{{ \Carbon\Carbon::parse($debut)->isoFormat('dddd D MMMM YYYY') }} - {{ \Carbon\Carbon::parse($fin)->isoFormat('dddd D MMMM YYYY') }}"
                                   readonly>
                            <input type="hidden" name="date_debut" value="{{ $debut }}">
                            <input type="hidden" name="date_fin" value="{{ $fin }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nombre de voyageurs</label>
                        <select class="form-control" name="voyageurs" id="voyageurs" required>
                            @for($i = 1; $i <= $logement->nb_voyageur_max; $i++)
                                <option value="{{ $i }}" {{ $i == $voyageurs ? 'selected' : '' }}>
                                    {{ $i }} {{ $i > 1 ? 'voyageurs' : 'voyageur' }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Logement</label>
                        <div class="form-control-static">
                            <p><i class="fa fa-home"></i> {{ $logement->titre }} ({{ $logement->type_logement }})</p>
                            <p><i class="fa fa-map-marker text-danger"></i> {{ $logement->adresse }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Projet à soutenir</label>
                        <div class="mt-3">
                            @foreach($projets as $projet)
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="projet_id" value="{{ $projet->id }}" {{ $loop->first ? 'checked' : '' }}>
                                        <strong>{{ $projet->titre }}</strong>
                                        <p class="text-muted small">{{ Str::limit($projet->description, 120) }}</p>
                                    </label>
                                </div>
                                @if(!$loop->last)
                                    <hr class="mt-2 mb-3">
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="conditions" id="conditions" required>
                                J'accepte les <a href="#" data-toggle="modal" data-target="#conditionsModal">conditions générales de réservation</a>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Colonne de droite - Récapitulatif -->
                <div class="col-md-4">
                    <div class="ibox">
                        <div class="ibox-head">
                            <div class="ibox-title">Récapitulatif</div>
                        </div>
                        <div class="ibox-body">
                            @php
                                $nuits = \Carbon\Carbon::parse($debut)->diffInDays(\Carbon\Carbon::parse($fin));
                                $prixNuit = $logement->prix_par_nuit;
                                $sousTotal = $nuits * $prixNuit;
                                $contribution = $sousTotal * 0.05;
                                $total = $sousTotal + $contribution;
                            @endphp

                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $nuits }} nuit(s) × {{ number_format($prixNuit, 0, ',', ' ') }} FCFA</span>
                                <span>{{ number_format($sousTotal, 0, ',', ' ') }} FCFA</span>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Contribution solidaire (5%)</span>
                                <span>+ {{ number_format($contribution, 0, ',', ' ') }} FCFA</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between font-weight-bold">
                                <span>Total</span>
                                <span class="text-success">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                            </div>

                            <div class="alert alert-info mt-3">
                                <i class="fa fa-info-circle"></i>
                                <strong>Politique d'annulation</strong><br>
                                <small>Annulation gratuite jusqu'à 7 jours avant l'arrivée. En cas d'annulation tardive, la première nuit vous sera facturée.</small>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-credit-card"></i> Procéder au paiement
                            </button>

                            <div class="text-center mt-3">
                                <p class="text-muted small">
                                    <i class="fa fa-lock"></i> Paiement sécurisé
                                </p>
                                <div>
                                    <i class="fa fa-cc-visa text-muted"></i>
                                    <i class="fa fa-cc-mastercard text-muted"></i>
                                    <i class="fa fa-cc-paypal text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Conditions Générales -->
<div class="modal fade" id="conditionsModal" tabindex="-1" role="dialog" aria-labelledby="conditionsModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="conditionsModalLabel">Conditions Générales de Réservation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>1. Réservation et Paiement</h5>
                <p>La réservation est considérée comme ferme et définitive à réception du paiement. Le paiement peut être effectué en une ou plusieurs fois selon les modalités choisies.</p>

                <h5>2. Annulation</h5>
                <p>En cas d'annulation plus de 7 jours avant la date d'arrivée, aucun frais ne sera retenu. En cas d'annulation entre 7 et 3 jours avant l'arrivée, 50% du montant total sera facturé. En cas d'annulation moins de 72h avant l'arrivée ou en cas de non-présentation, la totalité du séjour sera due.</p>

                <h5>3. Contribution solidaire</h5>
                <p>5% du montant de votre séjour sera reversé au projet communautaire de votre choix. Cette contribution est incluse dans le prix total affiché.</p>

                <h5>4. Arrivée et départ</h5>
                <p>L'heure d'arrivée est fixée à partir de 15h et l'heure de départ est fixée au plus tard à 12h. Des arrangements peuvent être prévus en fonction des disponibilités.</p>

                <h5>5. Capacité</h5>
                <p>Le nombre de personnes ne peut en aucun cas dépasser la capacité d'accueil mentionnée lors de la réservation. L'hébergeur se réserve le droit de refuser l'accès aux personnes non déclarées.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        // Validation du formulaire
        $('#reservationForm').on('submit', function(e) {
            if (!$('#conditions').is(':checked')) {
                e.preventDefault();
                toastr.warning('Veuillez accepter les conditions générales de réservation.');
                return false;
            }
            return true;
        });
    });
</script>


@endsection
