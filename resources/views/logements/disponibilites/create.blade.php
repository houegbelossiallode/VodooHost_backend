@extends('layouts.app')

@section('section')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Ajouter une période de disponibilité</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('hoost.logements.disponibilites.store', $logement) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" 
                                   class="form-control @error('date_debut') is-invalid @enderror" 
                                   id="date_debut" 
                                   name="date_debut" 
                                   value="{{ old('date_debut') }}"
                                   min="{{ now()->format('Y-m-d') }}"
                                   required>
                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de fin</label>
                            <input type="date" 
                                   class="form-control @error('date_fin') is-invalid @enderror" 
                                   id="date_fin" 
                                   name="date_fin" 
                                   value="{{ old('date_fin') }}"
                                   min="{{ now()->addDay()->format('Y-m-d') }}"
                                   required>
                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="prix" class="form-label">Prix (optionnel - laisser vide pour utiliser le prix par défaut)</label>
                            <input type="number" 
                                   class="form-control @error('prix') is-invalid @enderror" 
                                   id="prix" 
                                   name="prix" 
                                   value="{{ old('prix') }}"
                                   min="0"
                                   step="0.01">
                            @error('prix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Prix par nuit. Prix par défaut: {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} FCFA</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="statut" id="statut_disponible" value="disponible" {{ old('statut', 'disponible') === 'disponible' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statut_disponible">
                                    Disponible
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="statut" id="statut_indisponible" value="indisponible" {{ old('statut') === 'indisponible' ? 'checked' : '' }}>
                                <label class="form-check-label" for="statut_indisponible">
                                    Indisponible
                                </label>
                            </div>
                            @error('statut')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('hoost.logements.disponibilites.index', $logement) }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateDebut = document.getElementById('date_debut');
        const dateFin = document.getElementById('date_fin');

        dateDebut.addEventListener('change', function() {
            dateFin.min = this.value;
            if (dateFin.value && new Date(dateFin.value) < new Date(this.value)) {
                dateFin.value = this.value;
            }
        });
    });
</script>
@endsection