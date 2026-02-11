@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Liste des logements</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-wrapper fl-wrap">
                <div class="dasboard-listing-box fl-wrap">
                    <div class="dasboard-opt sl-opt fl-wrap">
                        <form method="GET" action="{{ route('hoost.logements.visiteurs.index') }}">
                            <div class="dashboard-search-listing">
                                <input type="text" name="q" onclick="this.select()"
                                    placeholder="Rechercher un logement (titre, description, adresse)"
                                    value="{{ request('q') }}">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </div>

                            <div class="price-opt">
                                <span class="price-opt-title">Trier par :</span>
                                <div class="listsearch-input-item">

                                    {{-- Si tu as d'autres filtres (search, type, etc.), remets-les ici en hidden --}}
                                    <select name="sort" class="chosen-select no-search-select"
                                        onchange="this.form.submit()">
                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus
                                            récents</option>
                                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus
                                            anciens</option>
                                        {{-- <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>
                                            Meilleure note</option> --}}
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom
                                            : A-Z</option>
                                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom
                                            : Z-A</option>

                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Du
                                            moins cher au plus cher
                                        </option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                            Du plus cher au moins cher
                                        </option>
                                    </select>

                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- dashboard-listings-wrap-->
                    <div class="dashboard-listings-wrap fl-wrap">
                        <div class="row">
                            @forelse($logements as $logement)
                                <div class="col-md-6">
                                    <div class="dashboard-listings-item fl-wrap">
                                        <div class="dashboard-listings-item_img">
                                            <div class="bg-wrap">
                                                @php
                                                    $photo = $logement->photos->first()->url;

                                                @endphp
                                                <div class="bg" data-bg="{{ $photo }}"></div>
                                            </div>
                                            <div class="overlay"></div>
                                            <a href="{{ route('hoost.logements.show', $logement->id) }}"
                                                class="color-bg">Voir</a>
                                        </div>
                                        <div class="dashboard-listings-item_content">
                                            <h4>
                                                <a href="{{ route('hoost.logements.show', $logement->id) }}">
                                                    {{ $logement->titre }}
                                                </a>
                                            </h4>
                                            <div class="geodir-category-location location-column">
                                                <div class="loc-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>{{ $logement->adresse }}</span>
                                                </div>

                                                <div class="loc-item">
                                                    <i class="fal fa-money-bill-wave"></i>
                                                    <span>{{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} FCFA /
                                                        nuit</span>
                                                </div>

                                                <div class="loc-item">
                                                    <i class="fal fa-bed"></i>
                                                    <span>{{ $logement->nb_chambre }} chambre(s)</span>
                                                </div>

                                                <div class="loc-item">
                                                    <i class="fal fa-users"></i>
                                                    <span>{{ $logement->nb_voyageur_max }} voyageurs</span>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            {{-- Rating : à adapter selon ta logique --}}
                                            {{-- @php
                                                $nbAvis = $logement->avis_count ?? 0;
                                                $note = $logement->note_moyenne ? round($logement->note_moyenne, 1) : 0;
                                            @endphp

                                            @if ($nbAvis > 0)
                                                <!-- Afficher les étoiles -->
                                                <div class="listing-rating card-popup-rainingvis tolt"
                                                    data-microtip-position="right"
                                                    data-tooltip="Note : {{ $note }}/5 ({{ $nbAvis }} avis)"
                                                    data-starrating2="{{ round($note) }}">
                                                </div>
                                            @endif --}}
                                            <div class="dashboard-listings-item_opt">
                                                <span class="viewed-counter">
                                                    <i class="fas fa-eye"></i>
                                                    Vu - {{ $logement->vues ?? 0 }}
                                                </span>
                                                <ul>

                                                    <li>
                                                        <a href="#" class="tolt fav-open"
                                                            data-microtip-position="top-left"
                                                            data-tooltip="Ajouter aux favoris"
                                                            data-logement-id="{{ $logement->id }}">
                                                            <i class="fal fa-heart"></i>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        {{-- Exemple : désactiver / activer --}}
                                                        <a href="{{ route('hoost.logements.show', $logement->id) }}"
                                                            class="tolt" data-microtip-position="top-left"
                                                            data-tooltip="Détails">
                                                            <i class="far fa-eye"></i>
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p>Aucun logement pour le moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- dashboard-listings-wrap end-->
                </div>
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
            </div>
        </div>

    </div>
    <!-- content end -->






    @php
        /** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Favorite[] $listsQuick */
        $listsQuick = \App\Models\Favorite::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->take(10)
            ->get();
    @endphp

    <div id="vh-fav-modal" class="vh-fav-modal">
        <div class="vh-fav-overlay"></div>

        <div class="vh-fav-dialog">
            <div class="vh-fav-header color-bg">
                <span>Ajouter aux favoris</span>
                <button type="button" class="vh-fav-close">
                    <i class="fal fa-times"></i>
                </button>
            </div>

            <div class="vh-fav-body">
                {{-- Formulaire : créer une nouvelle liste + y ajouter le logement --}}
                <form method="POST" action="{{ route('hoost.favorites.lists.store') }}" class="vh-fav-form">
                    @csrf
                    <input type="hidden" name="logement_id" id="vhFavLogementId">

                    <p class="vh-fav-text">
                        Créez une nouvelle liste pour ce logement :
                    </p>

                    <label class="vh-fav-label">
                        Nom de la liste
                    </label>
                    <input type="text" name="libelle" maxlength="50" class="vh-fav-input"
                        placeholder="Ex : Mes logements préférés" required>

                    <button type="submit" class="vh-fav-btn-main color-bg">
                        Créer la liste et ajouter
                    </button>
                </form>

                @if ($listsQuick->count())
                    <div class="vh-fav-separator">
                        <span>Ou</span>
                    </div>

                    <p class="vh-fav-text">
                        Ajouter ce logement à une liste existante :
                    </p>

                    <div class="vh-fav-lists">
                        @foreach ($listsQuick as $fav)
                            <form method="POST"
                                action="{{ route('hoost.favorites.items.add', ['favorite' => $fav->getKey()]) }}"
                                class="vh-fav-list-form">
                                @csrf
                                <input type="hidden" name="logement_id" class="vhFavLogementIdClone">
                                <input type="hidden" name="favorite_id" value="{{ $fav->getKey() }}">

                                <button type="submit" class="vh-fav-list-btn">
                                    <i class="fal fa-heart"></i>
                                    <span>{{ $fav->libelle }}</span>
                                </button>
                            </form>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>




    <style>
        .location-column {
            display: flex;
            flex-direction: column;
            gap: 6px;
            /* espace entre chaque ligne */
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
            /* uniforme => icônes alignées */
            text-align: center;
            /* centre l’icône dans le bloc */
            color: #D1B11B;
            /* couleur propre */
            font-size: 14px;
        }

        .location-column .loc-item span {
            font-size: 14px;

        }

        /* Empêcher le scroll quand le popup est ouvert */
        .vh-no-scroll {
            overflow: hidden;
        }

        .vh-fav-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .vh-fav-modal.vh-open {
            display: flex;
        }

        .vh-fav-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
        }

        .vh-fav-dialog {
            position: relative;
            z-index: 1;
            background: #fff;
            border-radius: 16px;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            font-size: 14px;
        }

        .vh-fav-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            color: #fff;
        }

        .vh-fav-close {
            border: none;
            background: transparent;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vh-fav-body {
            padding: 14px 16px 16px;
        }

        .vh-fav-text {
            font-size: 13px;
            color: #555;
            margin-bottom: 8px;
        }

        .vh-fav-label {
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .vh-fav-input {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 8px 10px;
            font-size: 13px;
            margin-bottom: 10px;
            background: #fafafa;
        }

        .vh-fav-input:focus {
            outline: none;
            border-color: #00c683;
            background: #fff;
        }

        .vh-fav-btn-main {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 9px;
            font-size: 13px;
            cursor: pointer;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vh-fav-separator {
            text-align: center;
            margin: 16px 0 8px;
            position: relative;
            font-size: 12px;
            color: #999;
        }

        .vh-fav-separator::before,
        .vh-fav-separator::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #eee;
        }

        .vh-fav-separator::before {
            left: 0;
        }

        .vh-fav-separator::after {
            right: 0;
        }

        .vh-fav-lists {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .vh-fav-list-form {
            margin: 0;
        }

        .vh-fav-list-btn {
            border-radius: 20px;
            border: 1px solid #ddd;
            padding: 5px 10px;
            font-size: 12px;
            background: #f8f9fa;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .vh-fav-list-btn i {
            font-size: 12px;
            color: #D1B11B;
        }

        .vh-fav-list-btn:hover {
            background: #fff;
            border-color: #ccc;
        }
    </style>





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('vh-fav-modal');
            if (!modal) return;

            const overlay = modal.querySelector('.vh-fav-overlay');
            const closeBtn = modal.querySelector('.vh-fav-close');
            const mainHidden = modal.querySelector('#vhFavLogementId');
            const clones = modal.querySelectorAll('.vhFavLogementIdClone');

            function openFavModal(logementId) {
                if (mainHidden) mainHidden.value = logementId;
                clones.forEach(input => input.value = logementId);

                modal.classList.add('vh-open');
                document.body.classList.add('vh-no-scroll');
            }

            function closeFavModal() {
                modal.classList.remove('vh-open');
                document.body.classList.remove('vh-no-scroll');
            }

            // Clic sur coeur
            document.querySelectorAll('.fav-open').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const logementId = this.getAttribute('data-logement-id');
                    if (!logementId) return;
                    openFavModal(logementId);
                });
            });

            // Fermer : croix + overlay
            if (overlay) {
                overlay.addEventListener('click', closeFavModal);
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', closeFavModal);
            }

            // Échap pour fermer
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('vh-open')) {
                    closeFavModal();
                }
            });
        });
    </script>



@endsection
