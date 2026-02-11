@extends('layouts.app')
@section('section')
<!-- content -->	
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
    <div class="container dasboard-container">
        <!-- dashboard-title -->	
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item"><span>Formulaire de modification de divinité</span></div>
             @include('partials/hearder2')
        </div>
        <!-- dashboard-title end -->		

        <div class="dasboard-wrapper fl-wrap no-pag">
            <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec6">
                <h5>Modifier la divinité</h5>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('hoost.divinites.update', $divinite->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form add_room-item-wrap">
                        <div class="add_room-container fl-wrap">

                            <div class="add_room-item fl-wrap">
                                <div class="row">
                                    <!-- Nom & Description -->
                                    <div class="col-sm-7">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label>Nom:</label>
                                                <input 
                                                    type="text" 
                                                    name="nom" 
                                                    placeholder="Nom de la divinité" 
                                                    value="{{ old('nom', $divinite->nom) }}" 
                                                    class="{{ $errors->has('nom') ? 'is-invalid' : '' }}"
                                                    style="text-align:left;padding-left:15px;"
                                                />
                                                @error('nom')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <label>Description</label>
                                        <div class="listsearch-input-item">
                                            <textarea 
                                                name="description" 
                                                cols="40" 
                                                rows="3" 
                                                style="height:85px;" 
                                                placeholder="Détails"
                                            >{{ old('description', $divinite->description) }}</textarea>
                                            @error('description')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        {{-- Aperçu de l'image actuelle --}}
                                        {{-- <div class="mb-2">
                                            @php
                                                // Si tu enregistres le chemin "divinites/xxx.jpg" -> asset('storage/...')
                                                $imgSrc = $divinite->image 
                                                    ? (Str::startsWith($divinite->image, ['http://','https://']) 
                                                        ? $divinite->image 
                                                        : asset('storage/'.$divinite->image))
                                                    : asset('images/all/1.jpg');
                                            @endphp
                                            <img src="{{ $imgSrc }}" alt="Image actuelle" style="width:72px;height:72px;object-fit:cover;border-radius:8px;">
                                            <span class="text-muted small">Image actuelle</span>
                                        </div> --}}
                                    </div>

                                    <!-- Image -->
                                    <div class="col-sm-5">
                                        <label>Image</label>
                                        <div class="listsearch-input-item fl-wrap">
                                            <div class="fuzone">
                                                <div class="fu-text">
                                                    <span>
                                                        <i class="far fa-cloud-upload-alt"></i> 
                                                        Déposez une nouvelle image ici (facultatif)
                                                    </span>
                                                    <div class="photoUpload-files fl-wrap"></div>
                                                </div>
                                                <input 
                                                    type="file" 
                                                    name="image" 
                                                    class="upload {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                                >
                                                @error('image')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                {{-- <p class="small text-muted" style="margin-top:6px;">
                                                    Formats: jpg, jpeg, png, webp, gif. Taille max 4 Mo.
                                                </p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- add_room-item -->
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

<div class="dashbard-bg gray-bg"></div>
@endsection
