@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Formulaire d’édition de projet</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->

            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5><i class="fas fa-user-tag"></i> Éditer le projet</h5>
            </div>



            <form method="POST" action="{{ route('hoost.projets.update', $projet->id) }}">
                @csrf
                @method('PUT')
                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form">
                        <div class="row">
                            <!-- Titre -->
                            <div class="col-sm-6 mb-3">
                                <label>Titre</label>
                                <input type="text" name="titre" placeholder="Titre du projet"
                                    value="{{ old('titre', $projet->titre) }}"
                                    class="form-control {{ $errors->has('titre') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;">
                                @error('titre')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date de début -->
                            <div class="col-sm-6 mb-3">
                                <label>Date de début</label>
                                <input type="date" name="date_debut" value="{{ old('date_debut', $projet->date_debut) }}"
                                    class="form-control {{ $errors->has('date_debut') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;">
                                @error('date_debut')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Catégorie -->
                            <div class="col-sm-6 mb-3">
                                <label>Catégorie</label>
                                <select name="categorie_id" data-placeholder="Sélectionnez une catégorie"
                                    class="chosen-select on-radius {{ $errors->has('categorie_id') ? 'is-invalid' : '' }}">
                                    <option value="">— Choisir —</option>
                                    @foreach ($categories as $m)
                                        <option value="{{ $m->id }}"
                                            {{ (string) old('categorie_id', $projet->categorie_id) === (string) $m->id ? 'selected' : '' }}>
                                            {{ $m->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pourcentage de contribution -->
                            <div class="col-sm-6 mb-3">
                                <label>Pourcentage de contribution (%)</label>
                                <input type="number" name="pourcentage_contribution" min="0" max="100"
                                    step="0.01"
                                    value="{{ old('pourcentage_contribution', $projet->pourcentage_contribution) }}"
                                    class="form-control {{ $errors->has('pourcentage_contribution') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;">
                                @error('pourcentage_contribution')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3">
                            <label>Objectif</label>
                            <input type="number" name="objectif" min="0" max="100"
                                step="0.01"
                                value="{{ old('objectif', $projet->objectif) }}"
                                class="form-control {{ $errors->has('objectif') ? 'is-invalid' : '' }}"
                                style="text-align: left; padding-left: 15px;">
                            @error('objectif')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="row">
                            <div class="col-sm-12 mb-3">
                                <p>Description</p>
                                <textarea name="description" rows="4" placeholder="Description du projet..."
                                    class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description', $projet->description) }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn color-bg float-btn">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
