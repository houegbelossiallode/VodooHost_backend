@extends('layouts.app')
@section('section')
<!-- content -->
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
    <div class="container dasboard-container">
        <!-- dashboard-title -->
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item"><span>Formulaire de création de logement</span></div>
            @include('partials/hearder2')
        </div>
        <!-- dashboard-title end -->

        <div class="dasboard-wrapper fl-wrap no-pag">
            <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec6">
                <h5>Ajouter un logement</h5>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('hoost.logements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form add_room-item-wrap">
                        <div class="add_room-container fl-wrap">

                            <div class="add_room-item fl-wrap">
                                    <div class="row">
                                        {{-- Titre du logement --}}
                                        <div class="col-sm-6">
                                            <label>Titre du logement</label>
                                            <input
                                                type="text"
                                                name="titre"
                                                placeholder="Titre du logement"
                                                value="{{ old('titre') }}"
                                                class="{{ $errors->has('titre') ? 'is-invalid' : '' }}"
                                                style="text-align:left;padding-left:15px;"
                                            />
                                            @error('titre')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Prix par nuit --}}
                                        <div class="col-sm-6">
                                            <label>Prix par nuit (FCFA)</label>
                                            <input
                                                type="number"
                                                name="prix_par_nuit"
                                                placeholder="Ex : 25000"
                                                value="{{ old('prix_par_nuit') }}"
                                                class="{{ $errors->has('prix_par_nuit') ? 'is-invalid' : '' }}"
                                                style="text-align:left;padding-left:15px;"
                                            />
                                            @error('prix_par_nuit')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- Adresse --}}
                                        <div class="col-sm-6">
                                            <label>Adresse</label>
                                            <input
                                                type="text"
                                                name="adresse"
                                                placeholder="Adresse du logement"
                                                value="{{ old('adresse') }}"
                                                class="{{ $errors->has('adresse') ? 'is-invalid' : '' }}"
                                                style="text-align:left;padding-left:15px;"
                                            />
                                            @error('adresse')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Nombre de chambres --}}
                                        <div class="col-sm-6">
                                            <label>Nombre de chambres</label>
                                            <input
                                                type="number"
                                                name="nb_chambre"
                                                placeholder="Ex : 2"
                                                value="{{ old('nb_chambre') }}"
                                                class="{{ $errors->has('nb_chambre') ? 'is-invalid' : '' }}"
                                                style="text-align:left;padding-left:15px;"
                                            />
                                            @error('nb_chambre')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="row">
                                        {{-- Voyageurs maximum --}}
                                        <div class="col-sm-6">
                                            <label>Voyageurs maximum</label>
                                            <input
                                                type="number"
                                                name="nb_voyageur_max"
                                                placeholder="Ex : 4"
                                                value="{{ old('nb_voyageur_max') }}"
                                                class="{{ $errors->has('nb_voyageur_max') ? 'is-invalid' : '' }}"
                                                style="text-align:left;padding-left:15px;"
                                            />
                                            @error('nb_voyageur_max')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Type de logement --}}
                                        <div class="col-sm-6">
                                            <label>Type de logement</label>
                                            <div class="listsearch-input-item">
                                                <select
                                                    name="type_logement_id"
                                                    data-placeholder="Sélectionnez un type de logement"
                                                    class="chosen-select on-radius {{ $errors->has('type_logement_id') ? 'is-invalid' : '' }}">
                                                    <option value="">— Choisir —</option>
                                                    @foreach($typelogements as $m)
                                                        <option value="{{ $m->id }}" {{ old('type_logement_id') == $m->id ? 'selected' : '' }}>
                                                            {{ $m->libelle}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('type_logement_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">

                                    {{-- Quartiers (select) --}}
                                        <div class="col-sm-12">
                                            <label>Quartiers</label>
                                            <div class="listsearch-input-item">
                                                <select
                                                    name="quartier_id"
                                                    data-placeholder="Sélectionnez un quartier"
                                                    class="chosen-select on-radius {{ $errors->has('quartier_id') ? 'is-invalid' : '' }}">
                                                    <option value="">— Choisir —</option>
                                                    @foreach($quartiers as $m)
                                                        <option value="{{ $m->id }}" {{ old('quartier_id') == $m->id ? 'selected' : '' }}>
                                                            {{ $m->libelle}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('quartier_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- Description (pleine largeur) --}}
                                        <div class="col-sm-12">
                                            <p>Description</p>
                                            <div class="listsearch-input-item">
                                                <textarea
                                                    name="description"
                                                    rows="4"
                                                    style="height:120px;"
                                                    class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                                                    placeholder="Décrivez le logement"
                                                >{{ old('description') }}</textarea>
                                            </div>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- Dropzone pour les photos --}}
                                        <div class="col-sm-12">
                                            <p>Photos du logement</p>
                                            <div class="listsearch-input-item fl-wrap">
                                                <div class="fuzone">
                                                    <div class="fu-text">
                                                        <span>
                                                            <i class="far fa-cloud-upload-alt"></i>
                                                            Déposez vos images ici ou cliquez pour sélectionner
                                                        </span>
                                                        <div class="photoUpload-files fl-wrap"></div>
                                                    </div>

                                                    <input
                                                        type="file"
                                                        name="photos[]"
                                                        accept="image/*"
                                                        multiple
                                                        id="photosInput"
                                                        class="upload {{ $errors->has('photos') || $errors->has('photos.*') ? 'is-invalid' : '' }}"
                                                    >

                                                    @error('photos')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                    @error('photos.*')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror

                                                    <small class="text-muted">
                                                        Sélectionnez plusieurs images (.jpg, .png, .jpeg)
                                                    </small>
                                                </div>
                                            </div>


                                            {{-- Aperçu des images sélectionnées --}}
                                            <div class="col-sm-12 mt-3">
                                                <div id="previewWrapper"
                                                    class="p-3"
                                                    style="
                                                        border: 2px dashed #ccc;
                                                        border-radius: 15px;
                                                        background: #fafafa;
                                                        min-height: 140px;">
                                                    <h6 class="mb-3" style="font-weight:bold; color:#333;">Aperçu des photos sélectionnées</h6>

                                                    <div id="previewContainer"
                                                        class="row g-3"
                                                        style="display:flex; flex-wrap:wrap;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                                                    <div class="row mt-4">
    <div class="col-sm-12">
        <label>Localisation sur la carte <span style="color:red">*</span></label>

        <div id="map" style="
            height: 380px;
            width: 100%;
            border-radius: 12px;
            border: 2px solid #ccc;
            margin-bottom: 15px;">
        </div>

        <!-- Champs cachés pour latitude / longitude -->
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        @error('latitude')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        @error('longitude')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>


                                </div><!-- /.row -->
                            </div><!-- /.add_room-item -->
                        </div><!-- /.add_room-container -->
                    </div><!-- /.custom-form -->

                    <!-- Boutons -->
                    <div class="mt-3">
                        <button type="submit" class="btn color-bg float-btn">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="dashbard-bg gray-bg"></div>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById('photosInput');
    const previewContainer = document.getElementById('previewContainer');

    let filesArray = [];

    input.addEventListener('change', function (event) {
        const files = Array.from(event.target.files);

        files.forEach(file => {
            filesArray.push(file);

            // Création du reader
            const reader = new FileReader();

            reader.onload = function (e) {
                const col = document.createElement('div');
                col.classList.add('col-md-3');

                col.innerHTML = `
    <div class="card shadow-sm"
        style="border-radius:12px; overflow:hidden;">

        <img src="${e.target.result}"
             class="card-img-top"
             style="height:140px; object-fit:cover;">

        <button type="button"
            class="btn btn-sm vh-btn-delete-photo"
            style="border-radius:0; width:100%;">
            Supprimer
        </button>
    </div>
`;


                previewContainer.appendChild(col);

                // Gestion du bouton supprimer
                col.querySelector(".vh-btn-delete-photo").addEventListener("click", function () {
                    col.remove();
                    filesArray = filesArray.filter(f => f !== file);
                    recreateFileList();
                });
            };

            reader.readAsDataURL(file);
        });

        recreateFileList();
    });

    function recreateFileList() {
        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;
    }
});
</script>



<script>
document.addEventListener("DOMContentLoaded", function () {

    // 1) Carte centrée par défaut sur le Bénin
    var map = L.map('map').setView([9.3077, 2.3158], 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 25,
    }).addTo(map);

    let marker;

    // 2) Option : on recentre sur la position ACTUELLE de l'hôte (juste pour l'aider à se situer)
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                // On zoome sur lui (mais on NE RENSEIGNE PAS encore les champs)
                map.setView([lat, lng], 13);

                // Petit cercle pour indiquer "vous êtes ici" (facultatif)
                L.circle([lat, lng], {
                    radius: 100,
                    color: '#D1B11B',
                    fillColor: '#D1B11B',
                    fillOpacity: 0.15
                }).addTo(map).bindPopup("Vous êtes ici (position actuelle)").openPopup();
            },
            function (error) {
                console.warn("Géolocalisation refusée ou impossible :", error.message);
                // On reste sur le centrage par défaut
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    // 3) L'HÔTE choisit réellement l'emplacement de SON LOGEMENT en cliquant sur la carte
    map.on('click', function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        // On met les valeurs dans les champs cachés
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;

        // On remplace l’éventuel ancien marker
        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup("Emplacement du logement sélectionné").openPopup();
    });

});
</script>

<style>
    .vh-btn-delete-photo {
        background: #D1B11B;   /* remplace par ta couleur "color-bg" si besoin */
        color: #fff;
        border: none;
        font-size: 13px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .vh-btn-delete-photo:hover {
        background: #D1B11B;   /* variante un peu plus foncée au hover */
        color: #fff;
    }
</style>



@endsection
