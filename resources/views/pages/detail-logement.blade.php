<!DOCTYPE HTML>
<html lang="en">

<head>
    <!--=============== basic  ===============-->
    <meta charset="UTF-8">
    <title>Voodoo hoost</title>
    <meta name="robots" content="index, follow" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <!-- css   -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <!--  favicons  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
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
                <div class="gray-bg small-padding fl-wrap">
                    <div class="container">
                        <div class="row">
                            <!--  listing-single content -->
                            <div class="col-md-8">
                                <div class="list-single-main-wrapper fl-wrap">
                                    <!--  scroll-nav-wrap -->
                                    <div class="scroll-nav-wrap">
                                        <nav class="scroll-nav scroll-init fixed-column_menu-init">
                                            <ul class="no-list-style">
                                                <li><a class="act-scrlink" href="#sec1"><i
                                                            class="fal fa-home-lg-alt"></i></a><span>Main</span></li>
                                                <li><a href="#sec2"><i
                                                            class="fal fa-image"></i></a><span>Galerie</span></li>
                                                <li><a href="#sec3"><i class="fal fa-info"></i>
                                                    </a><span>Details</span></li>
                                                <li><a href="#sec4"><i
                                                            class="fal fa-bed"></i></a><span>Chambres</span></li>
                                                <li><a href="#sec7"><i
                                                            class="fal fa-comment-alt-lines"></i></a><span>Commentaires</span>
                                                </li>
                                            </ul>
                                            <div class="progress-indicator">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34">
                                                    <circle cx="16" cy="16" r="15.9155"
                                                        class="progress-bar__background" />
                                                    <circle cx="16" cy="16" r="15.9155"
                                                        class="progress-bar__progress
                                                            js-progress-bar" />
                                                </svg>
                                            </div>
                                        </nav>
                                    </div>

                                    <div class="list-single-main-media fl-wrap" id="sec2">
                                        @php
                                            $photos = $logement->photos;
                                        @endphp

                                        @if ($photos->isNotEmpty())
                                            <div class="airbnb-photos-wrapper lightgallery">
                                                {{-- Grande photo à gauche --}}
                                                <div class="airbnb-main-photo">
                                                    @php $first = $photos->first(); @endphp
                                                    <a href="{{ $first->url }}" class="popup-image">
                                                        <img src="{{ $first->url }}" alt="Photo principale"
                                                            class="airbnb-photo-img">
                                                    </a>
                                                </div>

                                                {{-- 4 petites à droite --}}
                                                <div class="airbnb-side-photos">
                                                    @foreach ($photos->slice(1, 4) as $index => $photo)
                                                        @php
                                                            $isLastVisible = $loop->last && $photos->count() > 5;
                                                            $remaining = $photos->count() - 5;
                                                        @endphp

                                                        <div class="airbnb-side-item">
                                                            <a href="{{ $photo->url }}" class="popup-image">
                                                                <img src="{{ $photo->url }}" alt="Photo logement"
                                                                    class="airbnb-photo-img">
                                                            </a>

                                                            @if ($isLastVisible)
                                                                <div class="airbnb-more-overlay">
                                                                    <span>+ {{ $remaining }} photos</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="list-single-facts fl-wrap">
                                        <!-- inline-facts -->
                                        <div class="inline-facts-wrap">
                                            <div class="inline-facts">
                                                <i class="fal fa-home-lg"></i>
                                                <h6>Type</h6>
                                                <span>{{ $logement->typelogement->libelle }}</span>
                                            </div>
                                        </div>
                                        <!-- inline-facts end -->
                                        <!-- inline-facts  -->
                                        <div class="inline-facts-wrap">
                                            <div class="inline-facts">
                                                <i class="fal fa-users"></i>
                                                <h6>Capacité d’accueil</h6>
                                                <span>{{ $logement->nb_voyageur_max }}</span>
                                            </div>
                                        </div>
                                        <!-- inline-facts end -->
                                        <!-- inline-facts -->
                                        <div class="inline-facts-wrap">
                                            <div class="inline-facts">
                                                <i class="fal fa-bed"></i>
                                                <h6>Chambres</h6>
                                                <span>{{ $logement->nb_chambre }}</span>
                                            </div>
                                        </div>
                                        <!-- inline-facts end -->
                                        <!-- inline-facts -->
                                        <div class="inline-facts-wrap">
                                            <div class="inline-facts">
                                                <i class="fal fa-tag"></i>
                                                <h6>Prix par nuit</h6>
                                                <span>{{ number_format($logement->prix_par_nuit, 0, ',', ' ') }}
                                                    FCFA</span>
                                            </div>
                                        </div>
                                        <!-- inline-facts end -->
                                    </div>

                                    <div class="list-single-main-container fl-wrap" id="sec3">
                                        <!-- list-single-main-item -->
                                        <div class="list-single-main-item fl-wrap">
                                            <div class="list-single-main-item-title">
                                                <h3>A propos de ce logement</h3>
                                            </div>
                                            <div class="list-single-main-item_content fl-wrap">
                                                <p>{{ $logement->description }}
                                                </p>
                                            </div>
                                        </div>
                                        <!-- list-single-main-item end -->

                                        <!-- Expériences culturelles -->
                                        <div class="list-single-main-item fl-wrap" id="sec4">
                                            <div class="list-single-main-item-title fl-wrap">
                                                <h3>Expériences culturelles</h3>
                                            </div>

                                            @if ($logement->rituels->isEmpty())
                                                <p>Aucun rituel n’est encore associé à ce logement.</p>
                                            @else
                                                <div class="rooms-container fl-wrap">
                                                    @foreach ($logement->rituels as $rituel)
                                                        <div class="rooms-item fl-wrap">
                                                            {{-- <div class="rooms-media">
                                                                <img src="{{ $rituel->symbole }}"
                                                                    alt="{{ $rituel->titre }}">
                                                                <div class="dynamic-gal more-photos-button color-bg"
                                                                    data-dynamicPath="[{'src': '{{ $rituel->symbole }}'}, {'src': '{{ $rituel->symbole }}'}]">
                                                                    <i class="fas fa-camera"></i>
                                                                    <span>{{ $rituel->photos_count ?? 1 }}
                                                                        photos</span>
                                                                </div>
                                                            </div> --}}


                                                            <div class="rooms-media">
                                                                <a href="javascript:void(0)"
                                                                    class="rituel-popup-trigger"
                                                                    data-title="{{ e($rituel->titre) }}"
                                                                    data-img="{{ $rituel->symbole }}"
                                                                    data-desc="{{ e($rituel->description) }}"
                                                                    data-prec="{{ e($rituel->precautions) }}"
                                                                    data-duree="{{ e($rituel->duree) }}">
                                                                    <img src="{{ $rituel->symbole }}"
                                                                        alt="{{ $rituel->titre }}">
                                                                </a>

                                                                <div class="more-photos-button color-bg rituel-popup-trigger"
                                                                    data-title="{{ e($rituel->titre) }}"
                                                                    data-img="{{ $rituel->symbole }}"
                                                                    data-desc="{{ e($rituel->description) }}"
                                                                    data-prec="{{ e($rituel->precautions) }}"
                                                                    data-duree="{{ e($rituel->duree) }}">
                                                                    <i class="fas fa-info-circle"></i>
                                                                    <span>Détails</span>
                                                                </div>
                                                            </div>


                                                            <div class="rooms-details">
                                                                <div class="rooms-details-header fl-wrap">
                                                                    <h3>{{ $rituel->titre }}</h3>
                                                                    <h5>Précautions <span>
                                                                            {{ \Illuminate\Support\Str::limit($rituel->precautions, 100) }}</span>
                                                                    </h5>
                                                                </div>
                                                                <p>
                                                                    {{ \Illuminate\Support\Str::limit($rituel->description, 210) }}
                                                                </p>

                                                                <div class="facilities-list fl-wrap">
                                                                    <ul>
                                                                        @if (!empty($rituel->duree))
                                                                            <li class="tolt"
                                                                                data-microtip-position="top"
                                                                                data-tooltip="Horaire : {{ $rituel->duree }}">
                                                                                <i class="fal fa-clock"></i>
                                                                                {{ $rituel->duree }} minutes
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Equipements -->
                                        @if ($logement->dejeuners->count() > 0)
                                            <div class="list-single-main-item fl-wrap">
                                                <div class="list-single-main-item-title">
                                                    <h3>Petits déjeuners offerts</h3>
                                                </div>
                                                <div class="list-single-main-item_content fl-wrap">
                                                    <div class="listing-features">
                                                        <ul>
                                                            @forelse($logement->dejeuners as $dejeuner)
                                                                <li>
                                                                    <a href="javascript:void(0)">
                                                                        <i
                                                                            class="fal {{ $dejeuner->icon ?? 'fa-check' }}"></i>
                                                                        <p>{{ $dejeuner->libelle }}</p>
                                                                    </a>
                                                                </li>
                                                            @empty
                                                                <p>Aucun petit dejeuné renseigné pour ce logement.</p>
                                                            @endforelse
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Equipements -->
                                        <div class="list-single-main-item fl-wrap">
                                            <div class="list-single-main-item-title">
                                                <h3>Equipements</h3>
                                            </div>
                                            <div class="list-single-main-item_content fl-wrap">
                                                <div class="listing-features">
                                                    <ul>
                                                        @forelse($logement->equipements as $equipement)
                                                            <li>
                                                                <a href="javascript:void(0)">
                                                                    <i
                                                                        class="fal {{ $equipement->icon ?? 'fa-check' }}"></i>
                                                                    <p>{{ $equipement->libelle }}</p>
                                                                </a>
                                                            </li>
                                                        @empty
                                                            <p>Aucun équipement renseigné pour ce logement.</p>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Règlement intérieur --}}
                                        <div class="list-single-main-item fl-wrap">
                                            <div class="list-single-main-item-title">
                                                <h3>Points forts du quartier</h3>
                                            </div>

                                            <div class="list-single-main-item_content fl-wrap">
                                                <div class="listing-features">
                                                    <ul>
                                                        @forelse($logement->quartier->pointforts as $point)
                                                            <li>
                                                                <a href="javascript:void(0)">
                                                                    <i
                                                                        class="fal {{ $reglement->icon ?? 'fa-check' }}"></i>
                                                                    <p>{{ $point->titre }}</p>
                                                                </a>
                                                            </li>
                                                        @empty
                                                            <p>Aucun point fort n'est renseigné sur le quartier dans
                                                                lequel se trouve le logement.</p>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- Règlement intérieur --}}
                                        <div class="list-single-main-item fl-wrap">
                                            <div class="list-single-main-item-title">
                                                <h3>Règlements</h3>
                                            </div>
                                            <div class="list-single-main-item_content fl-wrap">
                                                <div class="listing-features">
                                                    <ul>
                                                        @forelse($logement->reglements as $reglement)
                                                            <li>
                                                                <a href="javascript:void(0)">
                                                                    <i
                                                                        class="fal {{ $reglement->icon ?? 'fa-check' }}"></i>
                                                                    <p>{{ $reglement->libelle }}</p>
                                                                </a>
                                                            </li>
                                                        @empty
                                                            <li>
                                                                <p>Aucun règlement renseigné pour ce logement.</p>
                                                            </li>
                                                        @endforelse
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Commentaires -->
                                        <!-- Commentaires -->
                                        <div class="list-single-main-item fl-wrap" id="sec7">
                                            <div class="list-single-main-item-title">
                                                <h3>Commentaires <span>{{ $totalAvis }}</span></h3>
                                            </div>

                                            <div class="list-single-main-item_content fl-wrap">
                                                <div class="reviews-comments-wrap fl-wrap">
                                                    {{-- Stat globales --}}
                                                    <div class="review-total">
                                                        @if ($totalAvis > 0)
                                                            @php
                                                                $avgNote = $avgNoteGlobal;
                                                            @endphp

                                                            <span class="review-number blue-bg">
                                                                {{ number_format($avgNote, 1, ',', ' ') }}
                                                            </span>

                                                            <div class="listing-rating card-popup-rainingvis"
                                                                data-starrating2="{{ floor($avgNote) }}">
                                                                <span class="re_stars-title">
                                                                    @if ($avgNote >= 4.5)
                                                                        Excellent
                                                                    @elseif($avgNote >= 3.5)
                                                                        Très bien
                                                                    @elseif($avgNote >= 2.5)
                                                                        Bien
                                                                    @elseif($avgNote > 0)
                                                                        Moyen
                                                                    @else
                                                                        Aucun avis
                                                                    @endif
                                                                    {{-- — {{ $totalAvis }} avis --}}
                                                                </span>
                                                            </div>
                                                        @else
                                                            <p>Aucun avis pour ce logement pour le moment.</p>
                                                        @endif
                                                    </div>

                                                    @if ($totalAvis > 0)
                                                        {{-- Barre de recherche + tri --}}
                                                        <div class="reviews-filter-bar fl-wrap"
                                                            style="margin-top:20px;">
                                                            <form method="GET"
                                                                action="{{ route('hoost.hebergements.show', $logement->id) }}#sec7"
                                                                class="reviews-filter-form">

                                                                <div class="row">
                                                                    {{-- <div class="col-md-6">
                                <label>Rechercher dans les commentaires</label>
                                <div class="dashboard-search-listing">
                                    <input type="text"
                                           name="q"
                                           placeholder="Mot-clé (propreté, accueil...)"
                                           value="{{ $search }}">
                                    <button type="submit"><i class="far fa-search"></i></button>
                                </div>
                            </div> --}}

                                                                    {{-- <div class="col-md-4">
                                <label>Trier par</label>
                                <div class="listsearch-input-item">
                                    <select name="sort"
                                            class="chosen-select no-search-select"
                                            onchange="this.form.submit()">
                                        <option value="relevance" {{ $sort === 'relevance' ? 'selected' : '' }}>
                                            Pertinence
                                        </option>
                                        <option value="recent" {{ $sort === 'recent' ? 'selected' : '' }}>
                                            Plus récents
                                        </option>
                                        <option value="best" {{ $sort === 'best' ? 'selected' : '' }}>
                                            Mieux notés
                                        </option>
                                        <option value="worst" {{ $sort === 'worst' ? 'selected' : '' }}>
                                            Moins bien notés
                                        </option>
                                    </select>
                                </div>
                            </div> --}}

                                                                    {{-- Si tu veux conserver d'autres paramètres (dates, nb voyageurs, etc.),
                                 tu peux rajouter des hidden ici --}}
                                                                    {{-- <input type="hidden" name="date_debut" value="{{ request('date_debut') }}"> --}}
                                                                </div>
                                                            </form>
                                                        </div>
                                                    @endif

                                                    {{-- Liste des commentaires (limités ou paginés selon ?all=1) --}}
                                                    @forelse($avis as $avisItem)
                                                        <div class="reviews-comments-item">
                                                            <div class="review-comments-avatar">
                                                                <img src="{{ $avisItem->user->photo ?? asset('images/avatar/1.jpg') }}"
                                                                    alt="">
                                                            </div>

                                                            <div class="reviews-comments-item-text smpar">
                                                                {{-- <div class="box-widget-menu-btn smact">
                            <i class="far fa-ellipsis-h"></i>
                        </div> --}}
                                                                {{-- <div class="show-more-snopt-tooltip bxwt">
                            <a href="#"><i class="fas fa-reply"></i> Répondre</a>
                            <a href="#"><i class="fas fa-exclamation-triangle"></i> Signaler</a>
                        </div> --}}

                                                                <h4>
                                                                    <a href="#">
                                                                        {{ $avisItem->user->nom ?? 'Utilisateur' }}
                                                                    </a>
                                                                </h4>

                                                                <div class="listing-rating card-popup-rainingvis"
                                                                    data-starrating2="{{ $avisItem->notes }}">
                                                                    <span class="re_stars-title">
                                                                        @if ($avisItem->notes >= 4.5)
                                                                            Excellent
                                                                        @elseif($avisItem->notes >= 3.5)
                                                                            Très bien
                                                                        @elseif($avisItem->notes >= 2.5)
                                                                            Bien
                                                                        @elseif($avisItem->notes > 0)
                                                                            Moyen
                                                                        @else
                                                                            Passable
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <p>" {{ $avisItem->commentaire }} "</p>

                                                                <div class="reviews-comments-item-date">
                                                                    <span class="reviews-comments-item-date-item">
                                                                        <i class="far fa-calendar-check"></i>
                                                                        {{ $avisItem->created_at->format('d/m/Y') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p>Aucun commentaire</p>
                                                    @endforelse

                                                    @if ($totalAvis > 0)
                                                        {{-- Bouton "Afficher tous les commentaires" si on n’est pas déjà en mode all --}}
                                                        @if (!$showAll && $totalAvis > $avis->count())
                                                            <div class="load-more-comments fl-wrap"
                                                                style="margin-top:20px;">
                                                                <a href="{{ route('hoost.hebergements.show', $logement->id) }}?all=1#sec7"
                                                                    class="btn color-bg">
                                                                    Afficher tous les commentaires
                                                                </a>
                                                            </div>
                                                        @endif

                                                        {{-- Pagination seulement en mode all --}}
                                                        @if ($showAll && $avis instanceof \Illuminate\Pagination\AbstractPaginator)
                                                            <div class="pagination">
                                                                {{ $avis->links() }}
                                                            </div>
                                                        @endif
                                                    @endif

                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="list-single-main-item fl-wrap" id="sec7">
                                            <div class="list-single-main-item-title">
                                                <h3>Commentaires <span>{{ $logement->avis->count() }}</span></h3>
                                            </div>

                                            <div class="list-single-main-item_content fl-wrap">
                                                <div class="reviews-comments-wrap fl-wrap">
                                                    @php
                                                        $avgNote = $logement->avis->avg('notes');
                                                    @endphp

                                                    <div class="review-total">
                                                        <span class="review-number blue-bg">{{ $avgNote }}</span>
                                                        <div class="listing-rating card-popup-rainingvis"
                                                            data-starrating2="{{ floor($avgNote) }}">
                                                            <span class="re_stars-title">
                                                                @if ($avgNote >= 4.5)
                                                                    Excellent
                                                                @elseif($avgNote >= 3.5)
                                                                    Bien
                                                                @elseif($avgNote > 0)
                                                                    Moyen
                                                                @else
                                                                    Aucun avis
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>

                                                    @forelse($logement->avis as $avis)
                                                        <div class="reviews-comments-item">
                                                            <div class="review-comments-avatar">
                                                                <img src="{{ $avis->user->photo ?? asset('images/avatar/1.jpg') }}"
                                                                    alt="">
                                                            </div>
                                                            <div class="reviews-comments-item-text smpar">
                                                                <div class="box-widget-menu-btn smact">
                                                                    <i class="far fa-ellipsis-h"></i>
                                                                </div>
                                                                <div class="show-more-snopt-tooltip bxwt">
                                                                    <a href="#"><i class="fas fa-reply"></i>
                                                                        Répondre</a>
                                                                    <a href="#"><i
                                                                            class="fas fa-exclamation-triangle"></i>
                                                                        Signaler</a>
                                                                </div>

                                                                <h4>
                                                                    <a href="#">
                                                                        {{ $avis->user->nom ?? 'Utilisateur' }}
                                                                    </a>
                                                                </h4>

                                                                <div class="listing-rating card-popup-rainingvis"
                                                                    data-starrating2="{{ $avis->notes }}">
                                                                    <span class="re_stars-title">
                                                                        @if ($avis->notes >= 4.5)
                                                                            Excellent
                                                                        @elseif($avis->notes >= 3.5)
                                                                            Bien
                                                                        @elseif($avis->notes >= 2.5)
                                                                            Moyen
                                                                        @else
                                                                            Passable
                                                                        @endif
                                                                    </span>
                                                                </div>

                                                                <div class="clearfix"></div>

                                                                <p>" {{ $avis->commentaire }} "</p>

                                                                <div class="reviews-comments-item-date">
                                                                    <span class="reviews-comments-item-date-item">
                                                                        <i class="far fa-calendar-check"></i>
                                                                        {{ $avis->created_at->format('d/m/Y') }}
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <p>Aucun commentaire pour ce logement pour le moment.</p>
                                                    @endforelse

                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <!-- listing-single content end-->

                            <!-- sidebar -->
                            <div class="col-md-4">
                                <!--box-widget hôte-->
                                <div class="box-widget fl-wrap">
                                    <div class="profile-widget">
                                        <div class="profile-widget-header color-bg smpar fl-wrap">
                                            <div class="pwh_bg"></div>
                                            <div class="call-btn">
                                                <a href="tel:{{ $logement->user->telephone }}" class="tolt color-bg"
                                                    data-microtip-position="right" data-tooltip="Appelez maintenant">
                                                    <i class="fas fa-phone-alt"></i>
                                                </a>
                                            </div>
                                            <div class="profile-widget-card">
                                                <div class="profile-widget-image">
                                                    <img src="{{ $logement->user->photo }}" alt="">
                                                </div>
                                                <div class="profile-widget-header-title">
                                                    <h4><a href="#">{{ $logement->user->nom }}</a></h4>
                                                    <div class="clearfix"></div>
                                                    <div class="pwh_counter">
                                                        <span>{{ $logement->user->logements->count() }}</span>Logements
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="profile-widget-content fl-wrap">
                                            <div class="contats-list fl-wrap">
                                                <ul class="no-list-style">
                                                    <li><span><i class="fal fa-phone"></i>Téléphone:</span> <a
                                                            href="tel:{{ $logement->user->telephone }}">{{ $logement->user->telephone }}</a>
                                                    </li>
                                                    <li><span><i class="fal fa-envelope"></i> Email :</span> <a
                                                            href="mailto:{{ $logement->user->email }}">{{ $logement->user->email }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="profile-widget-footer fl-wrap">
                                                <a href="{{ route('hoost.details.hote', $logement->user->id) }}"
                                                    class="btn float-btn color-bg small-btn">Voir profil</a>
                                                <a href="#sec-contact" class="custom-scroll-link tolt"
                                                    data-microtip-position="left" data-tooltip="Contactez l'hôte"><i
                                                        class="fal fa-paper-plane"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--box-widget end -->

                                <!--box-widget prix + réservation-->
                                <div class="box-widget fl-wrap hidden-section" style="margin-top: 30px">
                                    <div id="price-summary"
                                        class="box-widget-title fl-wrap box-widget-title-color color-bg">
                                        {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} F CFA pour 1 nuit
                                    </div>

                                    <div id="contribution-summary"
                                        class="box-widget-title fl-wrap box-widget-title-color color-bg">
                                        Contribution au projet : 0 F CFA
                                    </div>

                                    <div class="box-widget-content fl-wrap">
                                        <div class="custom-form">
                                            {{-- ICI ta future route vers la page checkout --}}
                                            <form id="reservation-form"
                                                action="{{ route('hoost.reservations.checkout', $logement) }}"
                                                method="GET" name="reservation-form"
                                                onsubmit="return validateReservation(event)">
                                                <label>Projets Communautaires</label>
                                                <div class="listsearch-input-item">
                                                    <select name="projet_id" class="chosen-select on-radius">
                                                        <option value="">— Choisir —</option>
                                                        @foreach ($projets as $projet)
                                                            <option value="{{ $projet->id }}"
                                                                data-pourcentage="{{ $projet->pourcentage_contribution }}">
                                                                {{ $projet->titre }}
                                                                ({{ $projet->pourcentage_contribution }}%)
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p>Date d'arrivée</p>
                                                        <div class="date-container fl-wrap">
                                                            <input type="text" id="date_debut"
                                                                placeholder="Date d'arrivée"
                                                                style="padding-left: 16px;" name="date_debut"
                                                                value="{{ request('date_debut') }}" required />
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <p>Date de départ</p>
                                                        <div class="date-container fl-wrap">
                                                            <input type="text" id="date_fin"
                                                                placeholder="Date de fin" name="date_fin"
                                                                value="{{ request('date_fin') }}"
                                                                style="padding-left: 16px;" required />
                                                        </div>
                                                    </div>

                                                    {{-- Champs cachés pour le backend --}}
                                                    <input type="hidden" name="nb_nuits" id="nb_nuits">
                                                    <input type="hidden" name="total_prix" id="total_prix">
                                                    <input type="hidden" name="pourcentage_contribution"
                                                        id="pourcentage_contribution">
                                                    <input type="hidden" name="montant_contribution"
                                                        id="montant_contribution">
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p>Nombre de voyageurs</p>
                                                        <input type="number" name="nb_voyageur" min="1"
                                                            placeholder="Ex: 2" style="padding-left:16px;"
                                                            value="{{ request('nb_voyageur') }}" required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        {{-- Sélecteur de devise --}}
                                                        <p>Devise d'affichage</p>
                                                        <select id="devise" class="chosen-select on-radius"
                                                            required>
                                                            <option value="XOF" selected>FCFA (XOF)</option>
                                                            <option value="EUR">Euro (EUR)</option>
                                                            <option value="USD">Dollar US (USD)</option>
                                                            <option value="GBP">Livre (GBP)</option>
                                                            <option value="NGN">Naira (NGN)</option>
                                                            <option value="GHS">Cedi (GHS)</option>
                                                            <option value="XAF">FCFA CEMAC (XAF)</option>
                                                            <option value="CAD">Dollar CA (CAD)</option>
                                                            <option value="CHF">Franc suisse (CHF)</option>
                                                            <option value="JPY">Yen (JPY)</option>
                                                            <option value="MAD">Dirham Marocain (MAD)</option>
                                                            <option value="BHD">Dinar de Bahreïn (BHD)</option>
                                                            <option value="AED">Dirham des Émirats arabes unis (AED)
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <button type="submit"
                                                    class="btn float-btn color-bg fw-btn">Réserver</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--box-widget end -->

                                <!--box-widget contact hôte -->
                                <div class="box-widget fl-wrap">
                                    <div class="box-widget-fixed-init fl-wrap" id="sec-contact">
                                        <div class="box-widget-title fl-wrap box-widget-title-color color-bg">Contacter
                                            l’hôte</div>
                                        <div class="box-widget-content fl-wrap">
                                            <div class="custom-form">
                                                <form method="POST"
                                                    action="{{ route('hoost.logements.contact', [$logement->user->id, $logement->id]) }}"
                                                    name="contact-property-form">
                                                    @csrf
                                                    <label>Vôtre Nom* <span class="dec-icon"><i
                                                                class="fas fa-user"></i></span></label>
                                                    <input name="nom" type="text" value="" required>
                                                    <label>Vôtre Prénom* <span class="dec-icon"><i
                                                                class="fas fa-user"></i></span></label>
                                                    <input name="prenom" type="text" value="" required>
                                                    <label>Vôtre Adresse Email* <span class="dec-icon"><i
                                                                class="fas fa-envelope"></i></span></label>
                                                    <input name="email" type="email" value="" required>
                                                    <textarea cols="40" rows="3" name="message" placeholder="Vôtre Message:" style="height: 150px" required></textarea>
                                                    <button type="submit"
                                                        class="btn float-btn color-bg fw-btn">Envoyer</button>
                                                </form>
                                            </div>
                                            <div id="contactResult" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--box-widget end -->
                            </div>
                            <!--  sidebar end-->
                        </div>

                        {{-- Logements similaires --}}
                        <div class="fl-wrap limit-box"></div>
                        <div class="listing-carousel-wrapper carousel-wrap fl-wrap">
                            <div class="list-single-main-item-title">
                                <h3>Logements similaires</h3>
                            </div>

                            <div class="listing-carousel carousel">
                                @forelse($similaires as $sim)
                                    <div class="slick-slide-item">
                                        <div class="listing-item listing-item-similaire">
                                            <article class="geodir-category-listing fl-wrap">

                                                <div class="geodir-category-img fl-wrap">
                                                    <a href="{{ route('hoost.hebergements.show', $sim->id) }}"
                                                        class="geodir-category-img_item">
                                                        <img src="{{ $sim->photos->first()->url }}" alt="">
                                                        <div class="overlay"></div>
                                                    </a>

                                                    <div class="geodir-category-location">
                                                        <a class="map-item">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            {{ $sim->adresse }}
                                                        </a>
                                                    </div>

                                                    <ul class="list-single-opt_header_cat">
                                                        <li>
                                                            <a class="cat-opt color-bg">
                                                                {{ $sim->typelogement->libelle }}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="geodir-category-listing_media-list">
                                                        <span><i class="fas fa-camera"></i>
                                                            {{ $sim->photos->count() }}</span>
                                                    </div>
                                                </div>

                                                <div
                                                    class="geodir-category-content fl-wrap geodir-category-content-similaire">
                                                    <h3>
                                                        <a href="{{ route('hoost.hebergements.show', $sim->id) }}">
                                                            {{ $sim->titre }}
                                                        </a>
                                                    </h3>

                                                    <div class="geodir-category-content_price">
                                                        {{ number_format($sim->prix_par_nuit, 0, ',', ' ') }} FCFA /
                                                        nuit
                                                    </div>

                                                    <p>{{ Str::limit($sim->description, 90) }}</p>

                                                    <div class="geodir-category-content-details sim-details">
                                                        <ul>
                                                            <li><i
                                                                    class="fal fa-bath"></i><span>{{ $sim->nb_voyageur_max ?? 0 }}</span>
                                                            </li>
                                                            <li><i
                                                                    class="fal fa-home"></i><span>{{ $sim->nb_chambre ?? 0 }}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </article>
                                        </div>
                                    </div>
                                @empty
                                    <p>Aucun logement similaire trouvé.</p>
                                @endforelse

                            </div>

                            <div class="swiper-button-prev lc-wbtn lc-wbtn_prev"><i class="far fa-angle-left"></i>
                            </div>
                            <div class="swiper-button-next lc-wbtn lc-wbtn_next"><i class="far fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content end -->
            @include('partials.newsletter')
            @include('partials.footer')
        </div>
        <!-- wrapper end -->
        @include('partials/register_login')
        <a class="to-top color-bg"><i class="fas fa-caret-up"></i></a>
    </div>
    <!-- Main end -->
    <!--=============== scripts  ===============-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOU_API_KEY_HERE&libraries=places"></script>
    <script src="{{ asset('assets/js/map-single.js') }}"></script>
    <script src="{{ asset('assets/js/contacthost.js') }}"></script>

    {{-- Script prix + devise dynamique (API FX) --}}

    {{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    const inputDebut      = document.querySelector('#date_debut');
    const inputFin        = document.querySelector('#date_fin');
    const selectProjet    = document.querySelector('select[name="projet_id"]');

    const priceSummary        = document.getElementById('price-summary');
    const contributionSummary = document.getElementById('contribution-summary');
    const currencySelect = document.getElementById('devise');
    console.log('Sélecteur de devise trouvé:', currencySelect);

    // Champs cachés
    const inputNbNuits             = document.getElementById('nb_nuits');
    const inputTotalPrix           = document.getElementById('total_prix');
    const inputPctContribution     = document.getElementById('pourcentage_contribution');
    const inputMontantContribution = document.getElementById('montant_contribution');

    const pricePerNightBase = {{ $logement->prix_par_nuit }}; // toujours en XOF
    const baseCurrency      = 'XOF';

    const formatter = new Intl.NumberFormat('fr-FR');
    let lastTotalBase   = 0;        // total en XOF
    let currentCurrency = 'XOF';    // devise affichée
    let fxRates         = {};       // { 'EUR': ..., 'USD': ..., ... }

    // 1) Récupérer les taux de change depuis open.er-api.com
    async function fetchFxRates() {
        try {
            const url = 'https://open.er-api.com/v6/latest/' + baseCurrency;
            const response = await fetch(url);
            const data = await response.json();
            console.log('Réponse API de change:', data);

            // Vérifier d'abord data.conversion_rates, puis data.rates pour la rétrocompatibilité
            if (data && (data.conversion_rates || data.rates)) {
                fxRates = data.conversion_rates || data.rates;
                // sécurité pour la devise de base
                console.log('Taux de change reçus:', fxRates);
                fxRates[baseCurrency] = 1;
            } else {
                console.warn('Réponse FX invalide, fallback sur XOF uniquement');
                fxRates = { [baseCurrency]: 1 };
            }
        } catch (e) {
            console.error('Erreur API FX', e);
            fxRates = { [baseCurrency]: 1 };
        }
    }

    function convertFromBase(amountBase, toCurrency) {
        console.log('Conversion de', amountBase, 'XOF vers', toCurrency);
        console.log('Taux disponibles:', fxRates);

        // Si c'est la même devise ou si le montant est 0, pas de conversion nécessaire
        if (toCurrency === baseCurrency || amountBase === 0) {
            return amountBase;
        }

        if (!fxRates || !fxRates[toCurrency]) {
            console.warn('Taux non trouvé pour', toCurrency, '- Utilisation de la valeur de base');
            return amountBase;
        }

        const rate = fxRates[toCurrency];
        console.log('Taux utilisé pour', toCurrency + ':', rate);
        const converted = amountBase * rate;
        console.log('Résultat de la conversion:', converted);
        return converted;
    }

    function getCurrencyLabel(code) {
        return code === 'XOF' ? 'F CFA' : code;
    }

    function updateContribution(totalBase) {
        if (!selectProjet) return;

        let pct = 0;
        if (selectProjet.value) {
            const selectedOption = selectProjet.options[selectProjet.selectedIndex];
            pct = parseFloat(selectedOption.dataset.pourcentage || 0);
        }

        const contributionBase    = totalBase > 0 ? Math.round(totalBase * pct / 100) : 0;
        const contributionDisplay = convertFromBase(contributionBase, currentCurrency);
        const currencyLabel       = getCurrencyLabel(currentCurrency);

        if (contributionSummary) {
            if (pct > 0 && totalBase > 0) {
                contributionSummary.textContent =
                    'Contribution au projet : ' +
                    formatter.format(Math.round(contributionDisplay)) + ' ' + currencyLabel +
                    ' (' + pct + ' % du séjour)';
            } else {
                contributionSummary.textContent =
                    'Contribution au projet : 0 ' + currencyLabel;
            }
        }

        // On garde en base XOF pour le backend
        if (inputPctContribution)      inputPctContribution.value = pct || '';
        if (inputMontantContribution)  inputMontantContribution.value = contributionBase || '';
    }

    function updatePrice() {
        const startValue = inputDebut.value;
        const endValue   = inputFin.value;

        const label = getCurrencyLabel(currentCurrency);

        // Pas de dates complètes -> on affiche juste 1 nuit
        if (!startValue || !endValue) {
            lastTotalBase = 0;
            const oneNightDisplay = convertFromBase(pricePerNightBase, currentCurrency);

            priceSummary.textContent =
                formatter.format(Math.round(oneNightDisplay)) + ' ' + label + ' pour 1 nuit';

            if (inputNbNuits)   inputNbNuits.value = '';
            if (inputTotalPrix) inputTotalPrix.value = '';

            updateContribution(0);
            return;
        }

        const startDate = new Date(startValue);
        const endDate   = new Date(endValue);

        const diffMs   = endDate - startDate;
        const oneDayMs = 1000 * 60 * 60 * 24;

        // Si date fin <= date début, on ignore
        if (diffMs <= 0) {
            lastTotalBase = 0;
            const oneNightDisplay = convertFromBase(pricePerNightBase, currentCurrency);

            priceSummary.textContent =
                formatter.format(Math.round(oneNightDisplay)) + ' ' + label + ' pour 1 nuit';

            if (inputNbNuits)   inputNbNuits.value = '';
            if (inputTotalPrix) inputTotalPrix.value = '';

            updateContribution(0);
            return;
        }

        const nights     = diffMs / oneDayMs;
        const totalBase  = nights * pricePerNightBase; // toujours XOF
        lastTotalBase    = totalBase;

        const totalDisplay = convertFromBase(totalBase, currentCurrency);

        priceSummary.textContent =
            formatter.format(Math.round(totalDisplay)) + ' ' + label +
            ' pour ' + nights + ' nuit' + (nights > 1 ? 's' : '');

        if (inputNbNuits)   inputNbNuits.value = nights;
        if (inputTotalPrix) inputTotalPrix.value = totalBase; // on stocke en XOF

        updateContribution(totalBase);
    }

    // Fonction pour mettre à jour l'affichage avec la devise sélectionnée
    function updateDisplayWithCurrency(currency) {
        console.log('Mise à jour de l\'affichage avec la devise:', currency);
        currentCurrency = currency;

        // Mettre à jour le sélecteur visuellement
        if (currencySelect) {
            console.log('Mise à jour du sélecteur avec la devise:', currency);
            currencySelect.value = currency;

            // Forcer la mise à jour de l'interface utilisateur de chosen
            if (currencySelect._chosen) {
                $(currencySelect).trigger('chosen:updated');
            }
        }

        // Mettre à jour les prix affichés
        if (!inputDebut?.value || !inputFin?.value) {
            const oneNightDisplay = convertFromBase(pricePerNightBase, currency);
            const label = getCurrencyLabel(currency);
            if (priceSummary) {
                priceSummary.textContent =
                    formatter.format(Math.round(oneNightDisplay)) + ' ' + label + ' pour 1 nuit';
            }
            updateContribution(0);
        } else {
            updatePrice();
        }
    }

    // Fonction de gestion du changement de devise
    function handleCurrencyChange() {
        const newCurrency = this.value || baseCurrency;
        console.log('Changement de devise détecté vers:', newCurrency);
        updateDisplayWithCurrency(newCurrency);
    }

    // Initialisation du sélecteur de devise
    if (currencySelect) {
        console.log('Initialisation du sélecteur de devise:', currencySelect);

        // Supprimer les anciens écouteurs pour éviter les doublons
        currencySelect.removeEventListener('change', handleCurrencyChange);

        // Ajouter le nouvel écouteur
        currencySelect.addEventListener('change', handleCurrencyChange);

        // Initialiser l'affichage avec la devise par défaut
        updateDisplayWithCurrency(currencySelect.value || baseCurrency);
    }

    // Changements sur les dates
    if (inputDebut) inputDebut.addEventListener('change', updatePrice);
    if (inputFin)   inputFin.addEventListener('change', updatePrice);

    // Changement de projet : on recalcule la contribution à partir du total en base
    if (selectProjet) {
        selectProjet.addEventListener('change', function () {
            updateContribution(lastTotalBase);
        });
    }

    // Initialisation du système de prix
    async function initPricing() {
        console.log('Initialisation des prix...');

        // Charger les taux de change
        await fetchFxRates();

        // Mettre à jour l'affichage avec la devise actuelle
        if (currencySelect) {
            updateDisplayWithCurrency(currencySelect.value || baseCurrency);
        } else {
            console.warn('Le sélecteur de devise n\'a pas été trouvé');
            updateDisplayWithCurrency(baseCurrency);
        }
    }

    // Démarrer l'initialisation
    initPricing().catch(e => console.error('Erreur lors de l\'initialisation des prix:', e));
});
</script> --}}


    {{-- Script prix + devise dynamique (API FX via open.er-api.com) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Init pricing + FX');

            // ------------------ Sélecteurs ------------------
            const inputDebut = document.getElementById('date_debut');
            const inputFin = document.getElementById('date_fin');
            const selectProjet = document.querySelector('select[name="projet_id"]');

            const priceSummary = document.getElementById('price-summary');
            const contributionSummary = document.getElementById('contribution-summary');
            const currencySelect = document.getElementById('devise');

            const inputNbNuits = document.getElementById('nb_nuits');
            const inputTotalPrix = document.getElementById('total_prix');
            const inputPctContribution = document.getElementById('pourcentage_contribution');
            const inputMontantContribution = document.getElementById('montant_contribution');

            // ------------------ Constantes ------------------
            const pricePerNightBase = {{ $logement->prix_par_nuit }}; // toujours en XOF (FCFA)
            const baseCurrency = 'XOF';
            const API_URL = 'https://open.er-api.com/v6/latest/' + baseCurrency;

            const formatter = new Intl.NumberFormat('fr-FR');

            // ------------------ Variables dynamiques ------------------
            let fxRates = {
                [baseCurrency]: 1
            }; // { 'EUR': 0.0015, ... }
            let currentCurrency = baseCurrency;
            let lastTotalBase = 0; // total du séjour en XOF

            // ------------------ Utilitaires ------------------
            function getCurrencyLabel(code) {
                return code === 'XOF' ? 'F CFA' : code;
            }

            function convertFromBase(amountBase, toCurrency) {
                if (!amountBase) return 0;

                if (toCurrency === baseCurrency) {
                    return amountBase;
                }

                const rate = fxRates[toCurrency];
                if (!rate) {
                    console.warn('Taux introuvable pour', toCurrency, '- on garde le montant en XOF');
                    return amountBase;
                }

                return amountBase * rate;
            }

            function computeNights() {
                const startValue = inputDebut?.value;
                const endValue = inputFin?.value;
                if (!startValue || !endValue) return 0;

                const startDate = new Date(startValue);
                const endDate = new Date(endValue);

                const diffMs = endDate - startDate;
                const oneDayMs = 1000 * 60 * 60 * 24;

                if (diffMs <= 0) return 0;

                return diffMs / oneDayMs;
            }

            function updateContribution(totalBase) {
                if (!selectProjet || !contributionSummary) return;

                let pct = 0;
                if (selectProjet.value) {
                    const opt = selectProjet.options[selectProjet.selectedIndex];
                    pct = parseFloat(opt.dataset.pourcentage || 0);
                }

                const contributionBase = totalBase > 0 ? Math.round(totalBase * pct / 100) : 0;
                const contributionDisplay = convertFromBase(contributionBase, currentCurrency);
                const label = getCurrencyLabel(currentCurrency);

                if (pct > 0 && totalBase > 0) {
                    contributionSummary.textContent =
                        'Contribution au projet : ' +
                        formatter.format(Math.round(contributionDisplay)) + ' ' + label +
                        ' (' + pct + ' % du séjour)';
                } else {
                    contributionSummary.textContent =
                        'Contribution au projet : 0 ' + label;
                }

                // Backend : on garde tout en XOF
                if (inputPctContribution) inputPctContribution.value = pct || '';
                if (inputMontantContribution) inputMontantContribution.value = contributionBase || '';
            }

            function refreshDisplay() {
                const label = getCurrencyLabel(currentCurrency);
                const nights = computeNights();

                // Pas de période correcte => affichage "1 nuit"
                if (!nights || nights <= 0) {
                    lastTotalBase = 0;

                    const oneNightDisplay = convertFromBase(pricePerNightBase, currentCurrency);

                    if (priceSummary) {
                        priceSummary.textContent =
                            formatter.format(Math.round(oneNightDisplay)) + ' ' + label +
                            ' pour 1 nuit';
                    }

                    if (inputNbNuits) inputNbNuits.value = '';
                    if (inputTotalPrix) inputTotalPrix.value = '';

                    updateContribution(0);
                    return;
                }

                // Période valide
                const totalBase = nights * pricePerNightBase; // toujours XOF
                lastTotalBase = totalBase;

                const totalDisplay = convertFromBase(totalBase, currentCurrency);

                if (priceSummary) {
                    priceSummary.textContent =
                        formatter.format(Math.round(totalDisplay)) + ' ' + label +
                        ' pour ' + nights + ' nuit' + (nights > 1 ? 's' : '');
                }

                if (inputNbNuits) inputNbNuits.value = nights;
                if (inputTotalPrix) inputTotalPrix.value = totalBase; // XOF pour le backend

                updateContribution(totalBase);
            }

            // ------------------ Chargement des taux FX ------------------
            function loadFxRates() {
                console.log('Appel FX:', API_URL);

                fetch(API_URL)
                    .then(res => res.json())
                    .then(data => {
                        console.log('Réponse brute FX :', data);

                        if (data && data.result === 'success' && data.rates) {
                            fxRates = data.rates;
                            fxRates[baseCurrency] = 1;
                            console.log('Taux chargés :', fxRates);
                        } else {
                            console.warn('Réponse FX invalide, on reste en XOF uniquement');
                            fxRates = {
                                [baseCurrency]: 1
                            };
                        }

                        // Après chargement des taux, on met à jour l'affichage
                        refreshDisplay();
                    })
                    .catch(err => {
                        console.error('Erreur API FX :', err);
                        fxRates = {
                            [baseCurrency]: 1
                        };
                        refreshDisplay();
                    });
            }

            // ------------------ Événements ------------------

            // Changement de devise (on utilise jQuery pour être sûr avec chosen)
            if (currencySelect) {
                // Si chosen est actif, il déclenche bien un "change" sur le <select> original
                if (window.jQuery) {
                    jQuery(document).on('change', '#devise', function(e) {
                        const newCurrency = this.value || baseCurrency;
                        console.log('Changement devise ->', newCurrency);
                        currentCurrency = newCurrency;
                        refreshDisplay();
                    });
                } else {
                    currencySelect.addEventListener('change', function(e) {
                        const newCurrency = this.value || baseCurrency;
                        console.log('Changement devise ->', newCurrency);
                        currentCurrency = newCurrency;
                        refreshDisplay();
                    });
                }
            }

            // Changement de dates
            if (inputDebut) inputDebut.addEventListener('change', refreshDisplay);
            if (inputFin) inputFin.addEventListener('change', refreshDisplay);

            // Changement de projet (recalcule juste la contribution avec le total actuel)
            if (selectProjet) {
                selectProjet.addEventListener('change', function() {
                    updateContribution(lastTotalBase);
                });
            }

            // ------------------ Initialisation ------------------
            // Devise initiale
            if (currencySelect) {
                currentCurrency = currencySelect.value || baseCurrency;
            } else {
                currentCurrency = baseCurrency;
            }

            // On charge les taux puis on affiche
            loadFxRates();
        });
    </script>





    {{-- Script flatpickr + blocage de périodes --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ranges désactivés : indisponible + réserver
            const blockedRanges = @json($blockedRanges ?? []);
            // Ranges disponibles : statut = "disponible"
            const availableRanges = @json($availableRanges ?? []);

            function parseYmd(str) {
                const [y, m, d] = str.split('-').map(Number);
                return new Date(y, m - 1, d);
            }

            // Vérifie si l’intervalle [startStr, endStr] chevauche un des ranges BLOQUÉS
            function hasOverlap(startStr, endStr) {
                if (!startStr || !endStr) return false;

                const start = parseYmd(startStr);
                const end = parseYmd(endStr);

                for (const r of blockedRanges) {
                    const bStart = parseYmd(r.from);
                    const bEnd = parseYmd(r.to);

                    // Chevauchement réel
                    if (bStart <= end && bEnd >= start) {
                        return true;
                    }
                }
                return false;
            }

            let endPicker = null;

            const startPicker = flatpickr("#date_debut", {
                dateFormat: "Y-m-d",
                minDate: "today",

                //On n'autorise que les jours avec statut "disponible"
                enable: availableRanges,

                //Et on bloque explicitement les périodes "indisponible" / "reserver"
                disable: blockedRanges,

                onChange: function(selectedDates, dateStr) {
                    if (endPicker) {
                        endPicker.set('minDate', dateStr || "today");

                        const endVal = document.querySelector('#date_fin').value;

                        if (dateStr && endVal && hasOverlap(dateStr, endVal)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Période non disponible',
                                text: 'La période que vous avez choisie contient des jours indisponibles.',
                                confirmButtonColor: '#d33'
                            });

                            document.querySelector('#date_fin').value = '';
                            endPicker.clear();
                        }
                    }
                }
            });

            endPicker = flatpickr("#date_fin", {
                dateFormat: "Y-m-d",
                minDate: "today",

                // Même logique pour la date de fin
                enable: availableRanges,
                disable: blockedRanges,

                onChange: function(selectedDates, dateStr) {
                    const startVal = document.querySelector('#date_debut').value;

                    if (!startVal || !dateStr) return;

                    if (hasOverlap(startVal, dateStr)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Période impossible',
                            text: 'La période sélectionnée traverse une période indisponible.',
                            confirmButtonColor: '#d33'
                        });

                        this.clear();
                        document.querySelector('#date_fin').value = '';
                    }
                }
            });

            // Sécurité supplémentaire lors du submit
            const form = document.querySelector('form[action*="reservations"]');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const d1 = document.querySelector('#date_debut').value;
                    const d2 = document.querySelector('#date_fin').value;

                    if (hasOverlap(d1, d2)) {
                        e.preventDefault();

                        Swal.fire({
                            icon: 'error',
                            title: 'Impossible de réserver',
                            text: 'Votre période traverse une indisponibilité ou une réservation en cours.',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    </script> --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ranges désactivés (indisponible + réservé) envoyés par le backend
            const blockedRaw = @json($blockedRanges ?? []);
            const availableRanges = @json($availableRanges ?? []);

            // Normalisation des blockedRanges → toujours {from: 'Y-m-d', to: 'Y-m-d'}
            const blockedRanges = (blockedRaw || []).map(r => {
                if (!r) return null;

                if (typeof r === 'string') {
                    return {
                        from: r,
                        to: r
                    };
                }

                if (Array.isArray(r) && r.length) {
                    if (r.length === 1) {
                        return {
                            from: r[0],
                            to: r[0]
                        };
                    }
                    if (r.length >= 2) {
                        return {
                            from: r[0],
                            to: r[1]
                        };
                    }
                }

                if (typeof r === 'object' && r.from && r.to) {
                    return {
                        from: r.from,
                        to: r.to
                    };
                }

                return null;
            }).filter(Boolean);

            function parseYmd(str) {
                const [y, m, d] = String(str).split('-').map(Number);
                return new Date(y, m - 1, d);
            }

            function hasOverlap(startStr, endStr) {
                if (!startStr || !endStr) return false;

                const start = parseYmd(startStr);
                const end = parseYmd(endStr);

                if (isNaN(start.getTime()) || isNaN(end.getTime())) {
                    return false;
                }

                for (const r of blockedRanges) {
                    const bStart = parseYmd(r.from);
                    const bEnd = parseYmd(r.to);

                    if (isNaN(bStart.getTime()) || isNaN(bEnd.getTime())) {
                        continue;
                    }

                    // Intersection réelle [start, end] ∩ [bStart, bEnd] non vide
                    if (bStart <= end && bEnd >= start) {
                        return true;
                    }
                }
                return false;
            }

            // Flatpickr date début
            const startPicker = flatpickr("#date_debut", {
                dateFormat: "Y-m-d",
                minDate: "today",
                enable: availableRanges,
                disable: blockedRaw,
                onChange: function(selectedDates, dateStr) {
                    if (endPicker) {
                        endPicker.set('minDate', dateStr || "today");
                    }
                }
            });

            // Flatpickr date fin
            let endPicker = flatpickr("#date_fin", {
                dateFormat: "Y-m-d",
                minDate: "today",
                enable: availableRanges,
                disable: blockedRaw,
            });

            // 🔑 Fonction appelée au submit du formulaire
            window.validateReservation = function(e) {
                const d1 = document.querySelector('#date_debut').value;
                const d2 = document.querySelector('#date_fin').value;

                // 1) Dates obligatoires
                if (!d1 || !d2) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Dates manquantes',
                        text: 'Merci de choisir une date d’arrivée et une date de départ avant de réserver.',
                        confirmButtonColor: '#d33'
                    });
                    return false;
                }

                // 2) Cohérence des dates
                if (d2 < d1) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Période invalide',
                        text: 'La date de départ doit être postérieure à la date d’arrivée.',
                        confirmButtonColor: '#d33'
                    });
                    return false;
                }

                // 3) Chevauchement avec une période bloquée
                if (hasOverlap(d1, d2)) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Impossible de réserver',
                        text: 'Votre période traverse une indisponibilité ou une réservation en cours.',
                        confirmButtonColor: '#d33'
                    });
                    return false;
                }

                // ✅ Tout est OK → on laisse Laravel gérer (et là, s’il y a auth, il peut dire "vous devez être connecté")
                return true;
            };
        });
    </script>




    <style>
        .house-rule-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: flex-start;
        }

        .house-rule-item i {
            font-size: 28px;
            color: #fff;
        }

        .house-rule-item h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
        }

        .house-rule-item p {
            margin: 0;
            color: #f1f1f1;
            font-size: 14px;
        }

        .airbnb-photos-wrapper {
            display: grid;
            grid-template-columns: 2fr 1.4fr;
            gap: 6px;
            border-radius: 12px;
            overflow: hidden;
        }

        .airbnb-main-photo {
            position: relative;
            height: 320px;
        }

        .airbnb-main-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .airbnb-side-photos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: repeat(2, 1fr);
            gap: 6px;
            height: 320px;
        }

        .airbnb-side-item {
            position: relative;
        }

        .airbnb-side-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .airbnb-more-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            font-size: 18px;
        }

        @media (max-width: 768px) {
            .airbnb-photos-wrapper {
                grid-template-columns: 1fr;
            }

            .airbnb-main-photo,
            .airbnb-side-photos {
                height: 220px;
            }
        }

        .listing-carousel .slick-slide-item {
            height: 100%;
        }

        .listing-item-similaire {
            height: 100%;
        }

        .listing-item-similaire .geodir-category-listing {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .geodir-category-content-similaire {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .geodir-category-content-similaire p {
            margin-top: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .geodir-category-content-similaire .sim-details {
            margin-top: auto;
        }


        /* ✅ Uniformiser les items dans listing-features (évite les décalages) */
        .listing-features ul {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 12px;
        }

        .listing-features ul li {
            margin: 0 !important;
            width: 100% !important;
        }

        .listing-features ul li a {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 14px;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #e9ecef;
            height: 100%;
            transition: .2s ease;
        }

        .listing-features ul li a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .05);
            border-color: rgba(209, 177, 27, .5);
        }

        .listing-features ul li a i {
            flex: 0 0 18px;
            margin-top: 2px;
        }

        /*Texte long : pas de décalage */
        .listing-features ul li a p {
            margin: 0;
            flex: 1;
            line-height: 1.35;
            word-break: break-word;
            /* casse proprement les mots trop longs */
            overflow-wrap: anywhere;
        }


        .rooms-details-header h3 {
            word-break: break-word;
            overflow-wrap: anywhere;
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.rituel-popup-trigger').forEach(el => {
                el.addEventListener('click', function(e) {
                    e.preventDefault();

                    const title = this.dataset.title || 'Rituel';
                    const img = this.dataset.img || '';
                    const desc = this.dataset.desc || '';
                    const prec = this.dataset.prec || '';
                    const duree = this.dataset.duree || '';

                    const html = `
                <div style="text-align:left;">
                    
                    ${img ? `
              <div style="background:#0b0b0b;border-radius:12px;overflow:hidden;margin-bottom:12px;display:flex;align-items:center;justify-content:center;">
                <img src="${img}" alt="${title}"
                     style="max-width:100%;max-height:70vh;width:auto;height:auto;object-fit:contain;display:block;">
              </div>
            ` : ''}


                    ${duree ? `<div style="margin-bottom:10px;font-size:13px;">
                                    <i class="fal fa-clock"></i> <strong>Durée :</strong> ${duree}
                                </div>` : ''}

                    ${desc ? `<div style="margin-bottom:10px;">
                                    <div style="font-weight:800;margin-bottom:6px;">Description</div>
                                    <div style="font-size:13px;line-height:1.5;color:#4b5563;">${desc}</div>
                                </div>` : ''}

                    ${prec ? `<div style="margin-bottom:0;">
                                    <div style="font-weight:800;margin-bottom:6px;">Précautions</div>
                                    <div style="font-size:13px;line-height:1.5;color:#4b5563;">${prec}</div>
                                </div>` : ''}
                </div>
            `;

                    Swal.fire({
                        title: title,
                        html: html,
                        width: 720,
                        showCloseButton: true,
                        confirmButtonText: 'Fermer',
                        confirmButtonColor: '#D1B11B'
                    });
                });
            });
        });
    </script>




</body>

</html>
