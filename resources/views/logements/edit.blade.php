@extends('layouts.app')
@section('section')
<!-- content --> 
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
    <div class="container dasboard-container">

        <!-- dashboard-title --> 
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item"><span>Formulaire d’édition de logement</span></div>
            @include('partials/hearder2')
        </div>
        <!-- dashboard-title end -->      

        <div class="dasboard-wrapper fl-wrap no-pag">
            <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec6">
                <h5>Modifier un logement</h5>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('hoost.logements.update', $logement->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form add_room-item-wrap">
                        <div class="add_room-container fl-wrap">

                            <div class="add_room-item fl-wrap">
                                <div class="row">

                                    <!-- Titre -->
                                    <div class="col-sm-6">
                                        <label>Titre du logement</label>
                                        <input 
                                            type="text" 
                                            name="titre"
                                            placeholder="Titre du logement"
                                            value="{{ old('titre', $logement->titre) }}"
                                            class="{{ $errors->has('titre') ? 'is-invalid' : '' }}"
                                            style="text-align:left;padding-left:15px;"
                                        />
                                        @error('titre')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Prix -->
                                    <div class="col-sm-6">
                                        <label>Prix par nuit (FCFA)</label>
                                        <input 
                                            type="number" 
                                            name="prix_par_nuit"
                                            placeholder="Ex : 25000"
                                            value="{{ old('prix_par_nuit', $logement->prix_par_nuit) }}"
                                            class="{{ $errors->has('prix_par_nuit') ? 'is-invalid' : '' }}"
                                            style="text-align:left;padding-left:15px;"
                                        />
                                        @error('prix_par_nuit')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Adresse -->
                                    <div class="col-sm-6">
                                        <label>Adresse</label>
                                        <input 
                                            type="text" 
                                            name="adresse"
                                            placeholder="Adresse du logement"
                                            value="{{ old('adresse', $logement->adresse) }}"
                                            class="{{ $errors->has('adresse') ? 'is-invalid' : '' }}"
                                            style="text-align:left;padding-left:15px;"
                                        />
                                        @error('adresse')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Chambres -->
                                    <div class="col-sm-6">
                                        <label>Nombre de chambres</label>
                                        <input 
                                            type="number" 
                                            name="nb_chambre"
                                            placeholder="Ex : 2"
                                            value="{{ old('nb_chambre', $logement->nb_chambre) }}"
                                            class="{{ $errors->has('nb_chambre') ? 'is-invalid' : '' }}"
                                            style="text-align:left;padding-left:15px;"
                                        />
                                        @error('nb_chambre')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
    
                                </div>

                                <div class="row">
                                    <!-- Voyageurs -->
                                    <div class="col-sm-6">
                                        <label>Voyageurs maximum</label>
                                        <input 
                                            type="number" 
                                            name="nb_voyageur_max"
                                            placeholder="Ex : 4"
                                            value="{{ old('nb_voyageur_max', $logement->nb_voyageur_max) }}"
                                            class="{{ $errors->has('nb_voyageur_max') ? 'is-invalid' : '' }}"
                                            style="text-align:left;padding-left:15px;"
                                        />
                                        @error('nb_voyageur_max')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Type -->
                                    <div class="col-sm-6">
                                        <label>Type de logement</label>
                                        <div class="listsearch-input-item">
                                            <select 
                                                name="type_logement_id" 
                                                data-placeholder="Sélectionnez un type de logement"
                                                class="chosen-select on-radius {{ $errors->has('type_logement_id') ? 'is-invalid' : '' }}">
                                                <option value="">— Choisir —</option>
                                                @foreach($typelogements as $m)
                                                    <option 
                                                        value="{{ $m->id }}" 
                                                        {{ old('type_logement_id', $logement->type_logement_id) == $m->id ? 'selected' : '' }}>
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
                                
                                <div class="col-sm-12">
                                        <label>Quartier</label>
                                        <div class="listsearch-input-item">
                                            <select 
                                                name="quartier_id" 
                                                data-placeholder="Sélectionnez un type de logement"
                                                class="chosen-select on-radius {{ $errors->has('quartier_id') ? 'is-invalid' : '' }}">
                                                <option value="">— Choisir —</option>
                                                @foreach($quartiers as $m)
                                                    <option 
                                                        value="{{ $m->id }}" 
                                                        {{ old('quartier_id', $logement->quartier_id) == $m->id ? 'selected' : '' }}>
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
                                    <!-- Description -->
                                    <div class="col-sm-12">
                                        <p>Description</p>
                                        <textarea 
                                            name="description" 
                                            rows="4"
                                            style="height:120px;"
                                            class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                                        >{{ old('description', $logement->description) }}</textarea>

                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Dropzone -->
                                    <div class="col-sm-12">
                                        <label>Ajouter de nouvelles photos</label>

                                        <div class="fuzone">
                                            <div class="fu-text">
                                                <span><i class="far fa-cloud-upload-alt"></i> Déposez vos images ici ou cliquez</span>
                                                <div class="photoUpload-files fl-wrap"></div>
                                            </div>

                                            <input 
                                                type="file" 
                                                name="photos[]" 
                                                accept="image/*"
                                                multiple
                                                id="photosInput"
                                                class="upload"
                                            >
                                        </div>

                                        <small class="text-muted">Vous pouvez sélectionner plusieurs images.</small>

                                        <!-- Aperçu des nouvelles images -->
                                        <div class="col-sm-12 mt-3">
                                            <div id="previewWrapper" class="p-3" 
                                                style="border:2px dashed #ccc;border-radius:15px;background:#fafafa;">
                                                <h6 class="mb-3">Aperçu des photos sélectionnées</h6>
                                                <div id="previewContainer" class="row g-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Photos existantes -->
                                <div class="row mt-4">
                                    <div class="col-sm-12">
                                        <h6>Photos existantes</h6>
                                        <div class="row g-3">

                                           @foreach($logement->photos as $photo)
                                            <div class="col-md-3 photo-card-{{ $photo->id }}">
                                                <div class="card shadow-sm" style="border-radius:12px; overflow:hidden;">
                                                    <img src="{{ asset($photo->url) }}" 
                                                        style="height:140px;object-fit:cover;width:100%;border-radius:12px 12px 0 0">

                                                    <button 
                                                        type="button"
                                                        class="btn btn-danger btn-sm delete-photo-btn"
                                                        data-id="{{ $photo->id }}"
                                                        data-url="{{ route('hoost.logements.photos.destroy', ['logement'=>$logement->id, 'photo'=>$photo->id]) }}"
                                                        style="width:100%;border-radius:0;padding:10px 0;font-weight:bold;">
                                                        Supprimer
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach


                                        </div>
                                    </div>
                                </div>

                                {{-- Carte + coords --}}
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
                                        <input type="hidden" name="latitude" id="latitude"
                                               value="{{ old('latitude', $logement->latitude) }}">
                                        <input type="hidden" name="longitude" id="longitude"
                                               value="{{ old('longitude', $logement->longitude) }}">

                                        @error('latitude')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        @error('longitude')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div> 
                        </div>
                    </div>
                    <!-- Bouton -->
                    <div class="mt-3">
                        <button type="submit" class="btn color-bg float-btn">Mettre à jour</button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<div class="dashbard-bg gray-bg"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ----------------------------
    // 1) Aperçu des nouvelles images
    // ----------------------------
    const input = document.getElementById('photosInput');
    const previewContainer = document.getElementById('previewContainer');
    let filesArray = [];

    if (input) {
        input.addEventListener('change', function (event) {
            const files = Array.from(event.target.files);

            files.forEach(file => {
                filesArray.push(file);

                const reader = new FileReader();
                reader.onload = function (e) {
                    const col = document.createElement('div');
                    col.classList.add('col-md-3');

                    col.innerHTML = `
                    <div class="card shadow-sm" 
                        style="border-radius:12px; overflow:hidden;">
                        
                        <img src="${e.target.result}" 
                            style="height:140px;object-fit:cover;width:100%;">
                            
                        <button type="button" 
                                class="btn btn-danger btn-sm delete-preview-btn"
                                style="width:100%;border-radius:0;padding:10px 0;font-weight:bold;">
                            Supprimer
                        </button>
                    </div>
                `;

                    previewContainer.appendChild(col);

                    col.querySelector(".btn-danger").addEventListener("click", function () {
                        col.remove();
                        filesArray = filesArray.filter(f => f !== file);
                        recreateFileList();
                    });
                };

                reader.readAsDataURL(file);
            });

            recreateFileList();
        });
    }

    function recreateFileList() {
        const dataTransfer = new DataTransfer();
        filesArray.forEach(file => dataTransfer.items.add(file));
        if (input) {
            input.files = dataTransfer.files;
        }
    }

    // ----------------------------
    // 2) Suppression AJAX des photos existantes
    // ----------------------------
    document.querySelectorAll('.delete-photo-btn').forEach(function(btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const url = this.dataset.url;
            const photoId = this.dataset.id;
            const card = document.querySelector('.photo-card-' + photoId);

            // Optionnel : désactiver le bouton pendant le traitement
            this.disabled = true;
            this.innerText = 'Suppression...';

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur serveur');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Petite animation avant suppression
                    card.style.transition = 'opacity 0.3s, transform 0.3s';
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';

                    setTimeout(() => {
                        card.remove();
                    }, 300);
                } else {
                    this.disabled = false;
                    this.innerText = 'Supprimer';
                    alert('Une erreur est survenue.');
                }
            })
            .catch(error => {
                console.error(error);
                this.disabled = false;
                this.innerText = 'Supprimer';
                alert('Impossible de supprimer la photo pour le moment.');
            });
        });
    });

});
</script>


{{-- JS Leaflet carte édition --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Coordonnées initiales (si déjà enregistrées)
    const initLat = {{ $logement->latitude ?? 'null' }};
    const initLng = {{ $logement->longitude ?? 'null' }};

    // Si le logement a déjà une position => on centre dessus, sinon Bénin
    let mapCenter = [9.3077, 2.3158];
    let zoomLevel = 7;

    if (initLat && initLng) {
        mapCenter = [initLat, initLng];
        zoomLevel = 14;
    }

    var map = L.map('map').setView(mapCenter, zoomLevel);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 25,
    }).addTo(map);

    let marker = null;

    // Si le logement possède déjà une position, on affiche un marker
    if (initLat && initLng) {
        marker = L.marker([initLat, initLng]).addTo(map);
        marker.bindPopup("Emplacement actuel du logement").openPopup();
    }

    // Clic sur la carte pour changer l’emplacement
    map.on('click', function (e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;

        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;

        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup("Nouvel emplacement du logement").openPopup();
    });
});
</script>


@endsection
