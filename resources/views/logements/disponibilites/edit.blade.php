@extends('layouts.app')

@section('section')
<div class="container">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col">
            <h2>Modifier la période de disponibilité</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('hoost.home') }}">Tableau de bord</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hoost.logements.show', $logement) }}">{{ $logement->titre }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hoost.logements.disponibilites.index', $logement) }}">Disponibilités</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Modifier</li>
                </ol>
            </nav>
        </div>
        <div class="col-auto">
            <a href="{{ route('hoost.logements.disponibilites.index', $logement) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    @include('partials.alerts')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('hoost.logements.disponibilites.update', $disponibilite) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date_debut" class="form-label">Date de début</label>
                            <input type="date" class="form-control @error('date_debut') is-invalid @enderror" 
                                   id="date_debut" name="date_debut" 
                                   value="{{ old('date_debut', $disponibilite->date_debut->format('Y-m-d')) }}" required>
                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date_fin" class="form-label">Date de fin</label>
                            <input type="date" class="form-control @error('date_fin') is-invalid @enderror" 
                                   id="date_fin" name="date_fin" 
                                   value="{{ old('date_fin', $disponibilite->date_fin->format('Y-m-d')) }}" required>
                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                                <option value="disponible" {{ old('statut', $disponibilite->statut) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                <option value="indisponible" {{ old('statut', $disponibilite->statut) == 'indisponible' ? 'selected' : '' }}>Indisponible</option>
                                <option value="reserve" {{ old('statut', $disponibilite->statut) == 'reserve' ? 'selected' : '' }}>Réservé</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="prix_nuit" class="form-label">Prix par nuit ({{ config('app.currency', 'FCFA') }})</label>
                            <input type="number" class="form-control @error('prix_nuit') is-invalid @enderror" 
                                   id="prix_nuit" name="prix_nuit" 
                                   value="{{ old('prix_nuit', $disponibilite->prix_nuit) }}" 
                                   min="0" step="0.01">
                            @error('prix_nuit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="min_nuits" class="form-label">Nuitées minimum</label>
                            <input type="number" class="form-control @error('min_nuits') is-invalid @enderror" 
                                   id="min_nuits" name="min_nuits" 
                                   value="{{ old('min_nuits', $disponibilite->min_nuits ?? 1) }}" 
                                   min="1">
                            @error('min_nuits')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" name="notes" rows="3">{{ old('notes', $disponibilite->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Enregistrer les modifications
                    </button>
                    
                    <button type="button" class="btn btn-danger" 
                            onclick="if(confirm('Êtes-vous sûr de vouloir supprimer cette période ?')) {
                                document.getElementById('delete-form').submit();
                            }">
                        <i class="fas fa-trash me-1"></i> Supprimer
                    </button>
                </div>
            </form>

            <!-- Formulaire de suppression -->
            <form id="delete-form" action="{{ route('hoost.logements.disponibilites.destroy', $disponibilite) }}" 
                  method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validation des dates
    document.addEventListener('DOMContentLoaded', function() {
        const dateDebut = document.getElementById('date_debut');
        const dateFin = document.getElementById('date_fin');

        // Mettre à jour la date de fin minimale lorsque la date de début change
        dateDebut.addEventListener('change', function() {
            dateFin.min = this.value;
            if (dateFin.value && dateFin.value < this.value) {
                dateFin.value = this.value;
            }
        });

        // S'assurer que la date de fin n'est pas antérieure à la date de début
        dateFin.addEventListener('change', function() {
            if (this.value < dateDebut.value) {
                this.value = dateDebut.value;
            }
        });
    });
</script>
@endpush
@endsection
