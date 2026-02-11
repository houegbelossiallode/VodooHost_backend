@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dasboard Menu
        </div>

        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Liste des quartiers</span>
                </div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->

            <div class="dasboard-wrapper fl-wrap">
                <div class="dasboard-listing-box fl-wrap">
                    <div class="dasboard-opt sl-opt fl-wrap">
                        <form method="GET" action="{{ route('hoost.quartiers.index') }}">
                            <div class="dashboard-search-listing">
                                <input type="text" name="q" onclick="this.select()"
                                    placeholder="Rechercher un quartier" value="{{ request('q') }}">
                                <button type="submit">
                                    <i class="far fa-search"></i>
                                </button>
                            </div>

                            <div class="price-opt">
                                <a href="{{ route('hoost.quartiers.create') }}" class="btn color-bg float-btn"
                                    style="margin-top:-8px;">
                                    <i class="fas fa-plus"></i> Ajouter un quartier
                                </a>
                            </div>
                        </form>
                    </div>

                    <!-- dashboard-listings-wrap-->
                    <div class="dashboard-listings-wrap fl-wrap">
                        <div class="row">
                            @forelse($quartiers as $quartier)
                                <div class="col-md-6">
                                    <div class="dashboard-listings-item fl-wrap">
                                        {{-- Pas d'image pour l’instant, on met une icône --}}
                                        <div class="dashboard-listings-item_img">
                                            @if ($quartier->latitude && $quartier->longitude)
                                                <div id="map-quartier-{{ $quartier->id }}" class="quartier-map"
                                                    data-lat="{{ $quartier->latitude }}"
                                                    data-lng="{{ $quartier->longitude }}">
                                                </div>
                                            @else
                                                {{-- Fallback si pas de coordonnées : on garde ton placeholder --}}
                                                <div class="bg-wrap">
                                                    <div class="bg"
                                                        data-bg="{{ asset('images/bg/quartier-placeholder.jpg') }}">
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="overlay"></div>
                                        </div>

                                        <div class="dashboard-listings-item_content">
                                            <h4>
                                                <a href="#">
                                                    {{ ucfirst($quartier->libelle) }}
                                                </a>
                                            </h4>

                                            <div class="geodir-category-location location-column">
                                                <div class="loc-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>
                                                        Latitude :
                                                        {{ $quartier->latitude ?? '-' }}
                                                    </span>
                                                </div>

                                                <div class="loc-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>
                                                        Longitude :
                                                        {{ $quartier->longitude ?? '-' }}
                                                    </span>
                                                </div>

                                                <div class="loc-item">
                                                    <i class="fal fa-calendar-alt"></i>
                                                    <span>
                                                        Créé le :
                                                        {{ optional($quartier->created_at)->format('d/m/Y H:i') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="clearfix"></div>

                                            <div class="dashboard-listings-item_opt">
                                                <span class="viewed-counter">
                                                    {{-- Tu peux afficher autre chose ici (ex: nombre de logements liés) --}}
                                                    <i class="fas fa-map"></i>
                                                    ID : {{ $quartier->id }}
                                                </span>
                                                <ul>
                                                    <li>
                                                        <a href="{{ route('hoost.quartiers.points.edit', $quartier) }}" class="tolt"
                                                            data-microtip-position="top-left" data-tooltip="Affecter points forts">
                                                            <i class="far fa-bezier-curve"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form id="delete-quartier-{{ $quartier->id }}"
                                                            action="{{ route('hoost.quartiers.destroy', $quartier) }}"
                                                            method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                        <a href="#" class="tolt" data-microtip-position="top-left"
                                                            data-tooltip="Supprimer"
                                                            onclick="event.preventDefault();
                                                                    if(confirm('Supprimer ce quartier ?')) {
                                                                        document.getElementById('delete-quartier-{{ $quartier->id }}').submit();
                                                                    }">
                                                            <i class="far fa-trash"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('hoost.quartiers.edit', $quartier) }}" class="tolt"
                                                            data-microtip-position="top-left" data-tooltip="Éditer">
                                                            <i class="far fa-edit"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p>Aucun quartier pour le moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- dashboard-listings-wrap end-->
                </div>

                <!-- pagination-->
                @if ($quartiers->hasPages())
                    <div class="pagination">
                        {{-- Précédent --}}
                        @if ($quartiers->onFirstPage())
                            <a href="javascript:void(0)" class="prevposts-link disabled">
                                <i class="fa fa-caret-left"></i>
                            </a>
                        @else
                            <a href="{{ $quartiers->previousPageUrl() }}" class="prevposts-link">
                                <i class="fa fa-caret-left"></i>
                            </a>
                        @endif

                        {{-- Pages --}}
                        @for ($page = 1; $page <= $quartiers->lastPage(); $page++)
                            @if ($page == $quartiers->currentPage())
                                {{-- Page active : même structure que le template --}}
                                <a href="{{ $quartiers->url($page) }}" class="current-page">
                                    {{ $page }}
                                </a>
                            @else
                                <a href="{{ $quartiers->url($page) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endfor

                        {{-- Suivant --}}
                        @if ($quartiers->hasMorePages())
                            <a href="{{ $quartiers->nextPageUrl() }}" class="nextposts-link">
                                <i class="fa fa-caret-right"></i>
                            </a>
                        @else
                            <a href="javascript:void(0)" class="nextposts-link disabled">
                                <i class="fa fa-caret-right"></i>
                            </a>
                        @endif
                    </div>
                @endif
                <!-- pagination end-->
            </div>
        </div>
    </div>

    <style>
        .location-column {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 10px;
            color: #999;
        }

        .location-column .loc-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .location-column .loc-item i {
            width: 20px;
            text-align: center;
            color: #D1B11B;
            font-size: 14px;
        }

        .location-column .loc-item span {
            font-size: 14px;
        }

        /* Carte quartier dans la card */
        .quartier-map {
            width: 100%;
            height: 220px;
            /* ajuste la hauteur si tu veux */
            border-radius: 8px;
            overflow: hidden;
        }

        /***.dashboard-listings-item_img {
            position: relative;
        }  **/

        .dashboard-listings-item_img .overlay {
            pointer-events: none;
            /* pour que la carte reste cliquable */
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapElements = document.querySelectorAll('.quartier-map');

            mapElements.forEach(function(el) {
                const lat = parseFloat(el.dataset.lat);
                const lng = parseFloat(el.dataset.lng);

                if (isNaN(lat) || isNaN(lng)) return;

                // Création de la carte
                const map = L.map(el, {
                    zoomControl: true,
                    scrollWheelZoom: true,
                    dragging: true,
                    attributionControl: false,
                }).setView([lat, lng], 14); // niveau de zoom initial

                // Fond de carte OpenStreetMap
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);

                // Marqueur sur le quartier
                L.marker([lat, lng]).addTo(map);
            });
        });
    </script>
@endsection
