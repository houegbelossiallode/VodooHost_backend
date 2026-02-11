@extends('layouts.app')
@section('section')
<!-- content -->	
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
    <div class="container dasboard-container">
        <!-- dashboard-title -->	
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item"><span>Formulaire d’édition de rituel</span></div>
            @include('partials/hearder2')
        </div>
        <!-- dashboard-title end -->		

        <div class="dasboard-wrapper fl-wrap no-pag">
            <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec6">
                <h5>Modifier un rituel</h5>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('hoost.rituels.update', $rituel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form add_room-item-wrap">
                        <div class="add_room-container fl-wrap">
                            <div class="add_room-item fl-wrap">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Titre :</label>
                                        <input 
                                            type="text" 
                                            name="titre" 
                                            placeholder="Titre du rituel" 
                                            value="{{ old('titre', $rituel->titre) }}" 
                                            class="{{ $errors->has('titre') ? 'is-invalid' : '' }}"
                                            style="text-align:left;padding-left:15px;"
                                        />
                                        @error('titre')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Durée (minutes)</label>
                                        <input 
                                            type="text" 
                                            name="duree" 
                                            min="1" 
                                            max="1440"
                                            placeholder="ex : 90"
                                            value="{{ old('duree', $rituel->duree) }}" 
                                            style="text-align:left;padding-left:15px;"
                                        />
                                        @error('duree')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Description</label>
                                        <div class="listsearch-input-item">
                                            <textarea 
                                                name="description" 
                                                cols="40" 
                                                rows="3" 
                                                style="height:85px;" 
                                                placeholder="Décrivez le rituel"
                                            >{{ old('description', $rituel->description) }}</textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label>Précautions</label>
                                        <div class="listsearch-input-item">
                                            <textarea 
                                                name="precautions" 
                                                cols="40" 
                                                rows="3" 
                                                style="height:85px;" 
                                                placeholder="Ex : éviter le jeûne, vêtements blancs, etc."
                                            >{{ old('precautions', $rituel->precautions) }}</textarea>
                                            @error('precautions')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Colonne symbole -->
                                    <div class="col-sm-12">
                                        <label>Symbole (image)</label>
                                        <div class="listsearch-input-item fl-wrap">
                                            <div class="fuzone">
                                                <div class="fu-text">
                                                    <span><i class="far fa-cloud-upload-alt"></i> Déposez l'image ici</span>
                                                    <div class="photoUpload-files fl-wrap"></div>
                                                </div>
                                                <input 
                                                    type="file" 
                                                    name="symbole" 
                                                    accept="image/*"
                                                    class="upload {{ $errors->has('symbole') ? 'is-invalid' : '' }}"
                                                >
                                                @error('symbole')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.row -->
                            </div><!-- /.add_room-item -->
                        </div><!-- /.add_room-container -->
                    </div><!-- /.custom-form -->

                    <!-- Boutons -->
                    <div class="mt-3">
                        <button type="submit" class="btn color-bg float-btn">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="dashbard-bg gray-bg"></div>
@endsection
