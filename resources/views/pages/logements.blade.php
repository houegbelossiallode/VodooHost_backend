<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Voodoo Hoost</title>
    <meta name="robots" content="index, follow" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <!-- css   -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <!--  favicons  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        #map-main {
            height: 100%;
            min-height: 400px;
            /* pour être sûr qu’on voit bien la carte */
        }

        .listing-item.highlight-card {
            box-shadow: 0 0 0 3px #D1B11B;
            border-radius: 8px;
            transition: box-shadow 0.3s ease;
        }
    </style>

    {{-- CSS / JS Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body>
    <!--loader-->
    <div class="loader-wrap">
        <div class="loader-inner">
            <svg>
                <defs>
                    <filter id="goo">
                        <fegaussianblur in="SourceGraphic" stdDeviation="2" result="blur" />
                        <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 5 -2"
                            result="gooey" />
                        <fecomposite in="SourceGraphic" in2="gooey" operator="atop" />
                    </filter>
                </defs>
            </svg>
        </div>
    </div>
    <!--loader end-->
    <!-- main -->
    <div id="main">
        @include('partials.naviguation')
        <!-- wrapper  -->
        <div id="wrapper">
            <!-- content -->
            <div class="content">
                <!-- categoties-column -->
                <div class="categoties-column cc-right cc-top">
                    <div class="categoties-column_container cat-list">
                        {{-- <ul>
                            <li><a href="#" class="act-category"><i
                                        class="fal fa-city"></i><span>Apartments</span></a></li>
                            <li><a href="#"><i class="fal fa-car-building"></i><span>Offices</span></a></li>
                            <li><a href="#"><i class="fal fa-home"></i><span>House</span></a></li>
                            <li><a href="#"><i class="fal fa-hotel"></i><span>Hotel</span></a></li>
                            <li><a href="#"><i class="fal fa-warehouse-alt"></i><span>Villa</span></a></li>
                        </ul> --}}
                    </div>
                    <div class="progress-indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34">
                            <circle cx="16" cy="16" r="15.9155" class="progress-bar__background" />
                            <circle cx="16" cy="16" r="15.9155"
                                class="progress-bar__progress 
                                    js-progress-bar" />
                        </svg>
                    </div>
                </div>
                <!-- categoties-column end -->
                <!-- Map -->
                <div class="map-container column-map right-position-map no-top_search   hid-mob-map">
                    <div id="map-main"></div>
                    <ul class="mapnavigation no-list-style">
                        <li><a href="#" class="prevmap-nav mapnavbtn"><span><i
                                        class="fas fa-caret-left"></i></span></a></li>
                        <li><a href="#" class="nextmap-nav mapnavbtn"><span><i
                                        class="fas fa-caret-right"></i></span></a></li>
                    </ul>
                    <div class="scrollContorl mapnavbtn tolt" data-microtip-position="top-left"
                        data-tooltip="Enable Scrolling"><span><i class="fal fa-unlock"></i></span></div>
                    <div class="location-btn geoLocation tolt" data-microtip-position="top-left"
                        data-tooltip="Your location"><span><i class="fal fa-location"></i></span></div>
                    <div class="map-close"><i class="fas fa-times"></i></div>
                </div>
                <!-- Map end -->
                <!-- col-list-wrap -->
                <div class="col-list-wrap col-list-wrap_left no-top-pad gray-bg ">
                    <div class="col-list-wrap_opt col-list-wrap_opt2 fl-wrap">
                        <div class="show-hidden-filter2 col-list-wrap_opt_btn color-bg">Afficher les filtres</div>
                        <div class="show-hidden-map not-vis_lap col-list-wrap_opt_btn color-bg">Afficher la carte</div>
                    </div>
                    <!-- list-searh-input-wrap-->
                    <div class="list-searh-input-wrap fl-wrap">
                        <div class="container">
                            <div class="list-searh-input-wrap-title fl-wrap"><i
                                    class="far fa-sliders-h"></i><span>Filtres de recherche</span></div>
                            <div class="custom-form fl-wrap">
                                <form method="GET" action="{{ route('hoost.hebergements.index') }}">
                                    <div class="row">
                                        <!-- listsearch-input-item -->
                                        <div class="col-sm-6">
                                            <div class="listsearch-input-item  ">
                                                <p>Destination</p>
                                                <input type="text" name="q" onClick="this.select()"
                                                    placeholder="Adresse,quartier..." value="{{ request('q') }}" />

                                            </div>
                                        </div>
                                        <!-- listsearch-input-item -->
                                        <!-- listsearch-input-item -->
                                        <div class="col-sm-6">
                                            <div class="listsearch-input-item">
                                                <p>Langues parlées par l'hôte</p>
                                                <select name="langues[]" class="chosen-select on-radius" multiple>
                                                    <option value="fr" @selected(collect(request('langues'))->contains('fr'))>Français
                                                    </option>
                                                    <option value="fon" @selected(collect(request('langues'))->contains('fon'))>Fon
                                                    </option>
                                                    <option value="dendi" @selected(collect(request('langues'))->contains('dendi'))>Dendi
                                                    </option>
                                                    <option value="yoruba" @selected(collect(request('langues'))->contains('yoruba'))>Yoruba
                                                    </option>
                                                    <option value="de" @selected(collect(request('langues'))->contains('de'))>Allemand
                                                    </option>

                                                    <option value="mina" @selected(collect(request('langues'))->contains('mina'))>Mina
                                                    </option>

                                                    <option value="en" @selected(collect(request('langues'))->contains('en'))>Anglais
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- listsearch-input-item -->
                                        <!-- listsearch-input-item -->
                                        {{-- <div class="col-sm-3">
                                            <div class="listsearch-input-item">
                                                <select data-placeholder="All Cities" class="chosen-select on-radius no-search-select" >
                                                    <option>All Cities</option>
                                                    <option>New York</option>
                                                    <option>London</option>
                                                    <option>Paris</option>
                                                    <option>Kiev</option>
                                                    <option>Moscow</option>
                                                    <option>Dubai</option>
                                                    <option>Rome</option>
                                                    <option>Beijing</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <!-- listsearch-input-item -->
                                        <div class="clearfix"></div>
                                        <!-- listsearch-input-item -->
                                        <div class="col-sm-4">
                                            <div class="listsearch-input-item">
                                                <select name="type_logement_id" class="chosen-select on-radius">
                                                    <option value="">Toutes les catégories</option>
                                                    @foreach ($typelogements as $typelogement)
                                                        <option value="{{ $typelogement->id }}"
                                                            @selected(request('type_logement_id') == $typelogement->id)>
                                                            {{ $typelogement->libelle }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                        <!-- listsearch-input-item -->
                                        <!-- listsearch-input-item -->
                                        <div class="col-sm-5">
                                            <div class="listsearch-input-item">
                                                <div class="price-rage-item fl-wrap">
                                                    <span class="pr_title">Prix:</span>
                                                    <input type="text" class="price-range-double" data-min="100"
                                                        data-max="1000000" name="price" data-step="100"
                                                        value="{{ request('price') }}" data-prefix="F">

                                                </div>
                                            </div>
                                        </div>
                                        <!-- listsearch-input-item -->
                                        <!-- listsearch-input-item -->
                                        <div class="col-sm-3">
                                            <div class="listsearch-input-item">
                                                <button type="submit" class="btn small-btn float-btn color-bg">
                                                    Rechercher
                                                </button>

                                            </div>
                                        </div>
                                        <!-- listsearch-input-item -->
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="hidden-listing-filter fl-wrap">
                                        <div class="row">
                                            <!-- listsearch-input-item -->
                                            {{-- <div class="col-sm-2">
                                                <div class="listsearch-input-item">
                                                    <label>Bedrooms</label>
                                                    <select data-placeholder="Bedrooms" class="chosen-select on-radius no-search-select" >
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            <!-- listsearch-input-item end-->
                                            <!-- listsearch-input-item -->
                                            {{-- <div class="col-sm-2">
                                                <div class="listsearch-input-item">
                                                    <label>Bathrooms</label>
                                                    <select data-placeholder="Bathrooms" class="chosen-select on-radius no-search-select" >
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            <!-- listsearch-input-item end-->
                                            <!-- listsearch-input-item -->
                                            {{-- <div class="col-sm-2">
                                                <div class="listsearch-input-item">
                                                    <label>Floors</label>
                                                    <select data-placeholder="Bathrooms" class="chosen-select on-radius no-search-select" >
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            <!-- listsearch-input-item end-->
                                            <!-- listsearch-input-item -->
                                            {{-- <div class="col-sm-2">
                                                <div class="listsearch-input-item">
                                                    <label>Property Id</label>
                                                    <input type="text" onClick="this.select()" placeholder="Id" value=""/>
                                                </div>
                                            </div> --}}
                                            <!-- listsearch-input-item end-->
                                            <!-- listsearch-input-item -->
                                            {{-- <div class="col-sm-4">
                                                <div class="listsearch-input-item">
                                                    <label>Area Sq/ft</label>
                                                    <div class="price-rage-item pr-nopad fl-wrap">
                                                        <input type="text" class="price-range-double" data-min="1" data-max="1000"  name="price-range2"  data-step="1" value="1" data-prefix="">
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <!-- listsearch-input-item -->
                                        </div>
                                        <div class="clearfix"></div>
                                        <!-- listsearch-input-item-->
                                        <div class="listsearch-input-item">
                                            <label>Equipements</label>
                                            <div class=" fl-wrap filter-tags">
                                                <ul class="no-list-style">
                                                    @foreach ($equipements as $equipement)
                                                        <li>
                                                            <input id="eq-{{ $equipement->id }}" type="checkbox"
                                                                name="equipements[]" value="{{ $equipement->id }}"
                                                                @checked(collect(request('equipements'))->contains($equipement->id))>
                                                            <label for="eq-{{ $equipement->id }}">
                                                                {{ $equipement->libelle }}
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>

                                            </div>
                                        </div>
                                        <!-- listsearch-input-item end-->
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="more-filter-option-wrap">
                            <div class="more-filter-option-btn more-filter-option act-hiddenpanel"> <span>Recherche
                                    Avancée</span> <i class="fas fa-caret-down"></i></div>
                            {{-- <div class="reset-form reset-btn"> <i class="far fa-sync-alt"></i> Réinitialiser les filtres</div> --}}
                        </div>
                    </div>
                    <!-- list-searh-input-wrap end-->
                    <!-- list-main-wrap-header-->
                    <div class="list-main-wrap-header fl-wrap fixed-listing-header">
                        <div class="container">
                            <!-- list-main-wrap-title-->
                            {{-- <div class="list-main-wrap-title">
                                <h2>Results For : <span>New York </span><strong>8</strong></h2>
                            </div> --}}
                            <!-- list-main-wrap-title end-->
                            <!-- list-main-wrap-opt-->
                            <div class="list-main-wrap-opt">
                                <!-- price-opt-->
                                <div class="price-opt">
                                    <form method="GET" action="{{ route('hoost.hebergements.index') }}">
                                        <span class="price-opt-title">Trier par :</span>
                                        <div class="listsearch-input-item">
                                            <select data-placeholder="Popularité"
                                                class="chosen-select no-search-select" name="sort"
                                                onchange="this.form.submit()">
                                                <option value="">Trier par</option>
                                                <option value="price_desc"
                                                    {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                                    Prix décroissant</option>
                                                <option value="price_asc"
                                                    {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                                    Prix croissant</option>
                                            </select>
                                        </div>
                                    </form>

                                </div>
                                <!-- price-opt end-->
                                <!-- price-opt-->
                                <div class="grid-opt">
                                    <ul class="no-list-style">
                                        <li class="grid-opt_act"><span class="two-col-grid   tolt"
                                                data-microtip-position="bottom" data-tooltip="Grid View"><i
                                                    class="far fa-th"></i></span></li>
                                        <li class="grid-opt_act"><span class="one-col-grid act-grid-opt tolt"
                                                data-microtip-position="bottom" data-tooltip="List View"><i
                                                    class="far fa-list"></i></span></li>
                                    </ul>
                                </div>
                                <!-- price-opt end-->
                            </div>
                            <!-- list-main-wrap-opt end-->
                        </div>
                    </div>
                    <!-- list-main-wrap-header end-->
                    <!-- listing-item-wrap-->
                    <div class="listing-item-container one-column-grid-wrap fl-wrap">
                        @forelse ($logements as $logement)
                            @php
                                $firstPhoto = optional($logement->photos->first())->url;
                            @endphp

                            <!-- listing-item -->
                            <div class="listing-item" data-logement-id="{{ $logement->id }}">
                                <article class="geodir-category-listing fl-wrap">
                                    <div class="geodir-category-img fl-wrap">
                                        <a href="{{ route('hoost.hebergements.show', $logement->id) }}"
                                            class="geodir-category-img_item">
                                            <img src="{{ $firstPhoto ?? asset('assets/images/all/no-image.jpg') }}"
                                                alt="{{ $logement->titre }}" style="height:230px;object-fit:cover;">
                                            <div class="overlay"></div>
                                        </a>

                                        <!-- Localisation -->
                                        <div class="geodir-category-location">
                                            <a href="javascript:void(0);" class="map-item tolt"
                                                data-microtip-position="top-left" data-tooltip="Voir sur la carte">
                                                <i class="fas fa-map-marker-alt"></i>
                                                {{ $logement->adresse }}
                                            </a>
                                        </div>

                                        <!-- Nombre de photos -->
                                        <div class="geodir-category-listing_media-list">
                                            <span>
                                                <i class="fas fa-camera"></i>
                                                {{ $logement->photos->count() }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="geodir-category-content fl-wrap">
                                        <!-- Titre -->
                                        <h3>
                                            <a href="{{ route('hoost.hebergements.show', $logement->id) }}">
                                                {{ $logement->titre }}
                                            </a>
                                        </h3>

                                        <!-- Prix -->
                                        <div class="geodir-category-content_price">
                                            {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} FCFA / nuit
                                        </div>

                                        <!-- Description courte -->
                                        <p>
                                            {{ \Illuminate\Support\Str::limit($logement->description, 140) }}
                                        </p>

                                        <!-- Détails (chambres, voyageurs) -->
                                        <div class="geodir-category-content-details">
                                            <ul>
                                                <li>
                                                    <i class="fal fa-bed"></i>
                                                    <span>{{ $logement->nb_chambre }}</span>
                                                </li>
                                                <li>
                                                    <i class="fal fa-users"></i>
                                                    <span>{{ $logement->nb_voyageur_max }}</span>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Footer : hôte -->
                                        <div class="geodir-category-footer fl-wrap">
                                            @if ($logement->user)
                                                <a href="{{ route('hoost.details.hote', $logement->user->id) }}"
                                                    class="gcf-company">
                                                    <img src="{{ $logement->user->photo }}" alt="">
                                                    <span>{{ $logement->user->nom . ' ' . $logement->user->prenom }}</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <!-- listing-item end-->
                        @empty
                            <p class="text-center" style="padding: 20px;">
                                Aucun logement trouvé pour ces critères.
                            </p>
                        @endforelse
                    </div>

                    <!-- listing-item-wrap end-->
                    <!-- pagination-->
                    @if ($logements->hasPages())
                        <div class="pagination">
                            {{-- Précédent --}}
                            @if ($logements->onFirstPage())
                                <a href="javascript:void(0)" class="prevposts-link disabled">
                                    <i class="fa fa-caret-left"></i>
                                </a>
                            @else
                                <a href="{{ $logements->previousPageUrl() }}" class="prevposts-link">
                                    <i class="fa fa-caret-left"></i>
                                </a>
                            @endif

                            {{-- Pages --}}
                            @for ($page = 1; $page <= $logements->lastPage(); $page++)
                                @if ($page == $logements->currentPage())
                                    {{-- Page active : même structure que le template --}}
                                    <a href="{{ $logements->url($page) }}" class="current-page">
                                        {{ $page }}
                                    </a>
                                @else
                                    <a href="{{ $logements->url($page) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endfor

                            {{-- Suivant --}}
                            @if ($logements->hasMorePages())
                                <a href="{{ $logements->nextPageUrl() }}" class="nextposts-link">
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
                    <div class="small-footer fl-wrap">
                        <div class="copyright"> © Voodoo hoost 2025 . Tous droits réservés.</div>
                        <a class="custom-to-top color-bg custom-scroll-link" href="#main"><i
                                class="fas fa-caret-up"></i></a>
                    </div>
                </div>
                <!-- col-list-wrap end -->
            </div>
            <!-- content end -->
        </div>
        <!-- wrapper end -->
        @include('partials/register_login')
        <a class="to-top color-bg"><i class="fas fa-caret-up"></i></a>
    </div>
    <!-- Main end -->
    <!--=============== scripts  ===============-->
    <!--=============== scripts  ===============-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/contacthost.js') }}"></script>

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


    <script>
        // Variable globale accessible partout dans la page
        window.LOGEMENTS_MAP_DATA = @json($logementsMapData ?? []);
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapEl = document.getElementById('map-main');
            if (!mapEl) {
                console.warn('Élément #map-main introuvable');
                return;
            }

            const logements = Array.isArray(window.LOGEMENTS_MAP_DATA) ?
                window.LOGEMENTS_MAP_DATA : [];

            // Centre par défaut : Ouidah
            let center = [6.3612, 2.0851];
            const firstWithCoords = logements.find(l => l.lat && l.lng);
            if (firstWithCoords) {
                center = [firstWithCoords.lat, firstWithCoords.lng];
            }

            // ⚠️ UNE SEULE initialisation
            const map = L.map('map-main').setView(center, 13);

            // Fond de carte
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            const bounds = [];
            const markersById = {};

            // Ajout des markers
            logements.forEach(l => {
                if (!l.lat || !l.lng) return;
                
                
                const marker = L.marker([l.lat, l.lng]).addTo(map);
                markersById[l.id] = marker;
                bounds.push([l.lat, l.lng]);

                const photoUrl = l.photo || "{{ asset('assets/images/all/no-image.jpg') }}";

                const popupHtml = `
                <div style="max-width: 240px;">
                    <a href="${l.url}" style="text-decoration:none; color:inherit;">
                        <div style="margin-bottom:8px;">
                            <img src="${photoUrl}"
                                 alt="${l.titre}"
                                 style="width:100%; height:130px; object-fit:cover; border-radius:6px;">
                        </div>
                        <h4 style="font-size:14px; margin:0 0 4px;">${l.titre}</h4>
                        <div style="font-weight:bold; margin-bottom:4px;">
                            ${Number(l.prix).toLocaleString('fr-FR')} FCFA / nuit
                        </div>
                        <div style="font-size:12px; color:#D1B11B;">
                            <i class="fas fa-map-marker-alt"></i> ${l.adresse ?? ''}
                        </div>
                    </a>
                </div>
            `;

                marker.bindPopup(popupHtml);

                // Quand on clique sur un marker, on met en surbrillance la carte correspondante
                marker.on('click', () => {
                    const card = document.querySelector(
                        `.listing-item[data-logement-id="${l.id}"]`);
                    if (!card) return;

                    document
                        .querySelectorAll('.listing-item.highlight-card')
                        .forEach(el => el.classList.remove('highlight-card'));

                    card.classList.add('highlight-card');
                    card.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                });
            });

            // Ajuste le zoom sur tous les logements
            if (bounds.length > 1) {
                map.fitBounds(bounds, {
                    padding: [40, 40]
                });
            }

            // 🔗 Clic "Voir sur la carte" -> centrer sur le marker
            const cards = document.querySelectorAll('.listing-item');

            cards.forEach(card => {
                const logementId = card.dataset.logementId;
                if (!logementId) return;

                const link = card.querySelector('.map-item');
                if (!link) return;

                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const marker = markersById[logementId];
                    const data = logements.find(l => String(l.id) === String(logementId));

                    if (!marker || !data) return;

                    map.setView([data.lat, data.lng], 35);
                    marker.openPopup();

                    // Highlight carte
                    document.querySelectorAll('.listing-item').forEach(c => {
                        c.classList.remove('highlight-card');
                    });
                    card.classList.add('highlight-card');
                });
            });
        });
    </script>

</body>

</html>
