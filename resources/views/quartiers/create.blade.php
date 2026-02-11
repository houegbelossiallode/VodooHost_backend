@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dashboard Menu
        </div>
        <div class="container dasboard-container">
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Formulaire de création de quartier</span>
                </div>
                @include('partials/hearder2')
            </div>

            <div class="dasboard-wrapper fl-wrap no-pag">
                <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec6">
                    <h5>Ajouter un quartier</h5>
                </div>

                <form action="{{ route('hoost.quartiers.store') }}" method="POST">
                    @csrf
                    <div class="dasboard-widget-box fl-wrap">
                        <div class="custom-form add_room-item-wrap">
                            <div class="add_room-container fl-wrap">
                                <div class="add_room-item fl-wrap">
                                    <div class="row">
                                        {{-- Libellé du quartier + autocomplétion --}}

                                        <div class="col-sm-12">
                                            <label for="zone_name">Nom du quartier <span class="dec-icon"><i
                                                        class="fas fa-home"></i></span></label>
                                            <div class="zone-autocomplete">
                                                <input type="text" id="name" name="libelle"
                                                    class="form-control {{ $errors->has('libelle') ? 'is-invalid' : '' }}"
                                                    placeholder="Nom du quartier" value="{{ old('libelle') }}"
                                                    autocomplete="off">
                                                @error('libelle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                {{-- Suggestions sous le champ --}}
                                                <ul id="suggestions" class="zone-suggestions"></ul>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <label>Longitude <span class="dec-icon"><i
                                                        class="fas fa-globe"></i></span></label>
                                            <input type="text" id="longitude" name="longitude" class="form-control"
                                                value="{{ old('longitude') }}">
                                        </div>

                                        <div class="col-sm-6">
                                            <label>Latitude <span class="dec-icon"><i
                                                        class="fas fa-globe"></i></span></label>
                                            <input type="text" id="latitude" name="latitude" class="form-control"
                                                value="{{ old('latitude') }}">
                                        </div>

                                    </div>
                                </div>
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


    <style>
        .zone-autocomplete{
    position: relative !important;
}

/* Suggestions toujours sous l'input */
.zone-suggestions{
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    width: 100% !important;

    margin-top: 4px;

    z-index: 999999 !important; /* plus haut que tout le dashboard */

    background: #ffffff;
    border: 1px solid #dcdfe6;
    border-radius: 0 0 10px 10px;
    max-height: 240px;
    overflow-y: auto;

    box-shadow: 0 15px 35px rgba(0,0,0,.15);
    display: none;
}

/* Items */
.zone-suggestions li{
    padding: 10px 14px;
    font-size: 13px;
    cursor: pointer;
    line-height: 1.3;
}

.zone-suggestions li:hover{
    background: #f5f7fb;
}

.dashboard-content,
.dasboard-wrapper,
.dasboard-widget-box{
    overflow: visible !important;
}

    </style>



    <!-- Mapbox JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
    <script defer src="https://api.mapbox.com/search-js/v1.0.0-beta.22/web.js" id="search-js"></script>
 
    <script type="text/javascript">
        mapboxgl.accessToken = "{{ config('services.mapbox.token') }}";
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = $('#name');
            const longitudeInput = $('#longitude');
            const latitudeInput = $('#latitude');
            const suggestionsList = $('#suggestions');

            nameInput.on('input', function () {
    const query = nameInput.val().trim();

    if (query.length > 2) {
        fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(query)}.json?country=BJ,TG&access_token=${mapboxgl.accessToken}`)
            .then(res => res.json())
            .then(data => {
                suggestionsList.empty();

                if (data.features?.length) {
                    data.features.forEach(feature => {
                        const li = $('<li></li>').text(feature.place_name);

                        li.on('click', function () {
                            nameInput.val(feature.place_name);
                            longitudeInput.val(feature.geometry.coordinates[0]);
                            latitudeInput.val(feature.geometry.coordinates[1]);
                            suggestionsList.hide().empty();
                        });

                        suggestionsList.append(li);
                    });

                    suggestionsList.show();
                } else {
                    suggestionsList.hide();
                }
            });
    } else {
        suggestionsList.hide();
    }
});


            // Cacher les suggestions si clic en dehors
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.zone-autocomplete').length) {
                    suggestionsList.empty().hide();
                }
            });
        });
    </script>
@endsection
