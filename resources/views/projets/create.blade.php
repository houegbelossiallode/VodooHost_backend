@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Formulaire de création de projet</span></div>
                 @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5><i class="fas fa-user-tag"></i> Création d'un projet</h5>
            </div>
            <form method="post" action="{{ route('hoost.projets.store') }}">
                @csrf
                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Titre</label>
                                <input type="text" name="titre" placeholder="libelle" value="{{ old('titre') }}"
                                    class="{{ $errors->has('titre') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('titre')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label>Date de début</label>
                                <input type="date" name="date_debut" value="{{ old('date_debut') }}"
                                    class="form-control {{ $errors->has('date_debut') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('date_debut')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label>Catégorie</label>
                                <select name="categorie_id" data-placeholder="Sélectionnez un categorie"
                                    class="chosen-select on-radius {{ $errors->has('categorie_id') ? 'is-invalid' : '' }}">
                                    <option value="">— Choisir —</option>
                                    @foreach ($categories as $m)
                                        <option value="{{ $m->id }}"
                                            {{ old('categorie_id') == $m->id ? 'selected' : '' }}>
                                            {{ $m->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categorie_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label>Pourcentage de contribution (%)</label>
                                <input type="number" name="pourcentage_contribution"
                                    placeholder="Pourcentage de contribution" max="100"
                                    value="{{ old('pourcentage_contribution') }}"
                                    class="form-control {{ $errors->has('pourcentage_contribution') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('pourcentage_contribution')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <p>Objectif</p>
                            <input type="number" name="objectif"
                                    placeholder="Objectif"
                                    value="{{ old('objectif') }}"
                                    class="form-control {{ $errors->has('objectif') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                            @error('objectif')
                                    <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-3">
                            <p>Description</p>
                            <textarea name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" rows="4"
                                placeholder="Description du projet...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                    <button type="submit" class="btn color-bg float-btn">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <!-- content end -->
    <div class="dashbard-bg gray-bg"></div>
    </div>
@endsection
