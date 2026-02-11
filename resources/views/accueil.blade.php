<!DOCTYPE HTML>
<html lang="en">

<head>
    <!-- basic   -->
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
</head>

<body>

    <!--loader-->
    <div class="loader-wrap">
        <div class="loader-inner">
            {{-- <img src="{{ asset('assets/images/zangbeto.jpg') }}" class="loader-logo" alt="Loading..."> --}}
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
                <!--  section  -->
                <section class="hero-section hero-section_dec" data-scrollax-parent="true">
                    <div class="bg-wrap">
                        <div class="bg par-elem" data-bg="{{ asset('assets/images/voodoo/ban1.png') }}"
                            data-scrollax="properties: { translateY: '30%' }"></div>
                    </div>
                    <div class="overlay"></div>
                    <div class="container">
                        <div class="hero-title hero-title_small">
                            <h4>{{ __('messages.discover_ouidah') }}</h4>
                            <h2>
                                {!! __('messages.home_title') !!}
                            </h2>
                        </div>
                        <div class="main-search-input-wrap">
                            {{-- <div class="main-search-input fl-wrap">
                                <div class="main-search-input-item">
                                <input type="text"
                                    placeholder="{{ __('messages.search_placeholder') }}"
                                    value=""/>

                                </div>
                                <div class="main-search-input-item">
                                    <select class="chosen-select no-search-select">
                                        <option>{{ __('messages.lodging_type_label') }}</option>
                                        <option>{{ __('messages.lodging_type_traditional_house') }}</option>
                                        <option>{{ __('messages.lodging_type_guest_room') }}</option>
                                        <option>{{ __('messages.lodging_type_partner_convent') }}</option>
                                        <option>{{ __('messages.lodging_type_seafront_bungalow') }}</option>
                                    </select>
                                </div>
                                <div class="main-search-input-item">
                                    <select class="chosen-select">
                                        <option>{{ __('messages.cultural_theme_label') }}</option>
                                        <option>{{ __('messages.cultural_theme_voodoo_initiation') }}</option>
                                        <option>{{ __('messages.cultural_theme_local_crafts') }}</option>
                                        <option>{{ __('messages.cultural_theme_spiritual_discovery') }}</option>
                                        <option>{{ __('messages.cultural_theme_history_tour') }}</option>
                                    </select>
                                </div>
                                <button class="main-search-button color-bg" onclick="window.location.href='recherche.html'">
                                    {{ __('messages.explore_button') }} <i class="far fa-search"></i>
                                </button>
                            </div> --}}

                            {{-- <div class="main-search-input-wrap">
                                <div class="main-search-input fl-wrap">
                                    <div class="main-search-input-item">
                                        <input type="text" placeholder="What are you looking for?" value=""/>
                                    </div>
                                    <div class="main-search-input-item">
                                        <select data-placeholder="All Categories"  class="chosen-select no-search-select" >
                                            <option>All Statuses</option>
                                            <option>For Rent</option>
                                            <option>For Sale</option>
                                        </select>
                                    </div>
                                    <div class="main-search-input-item">
                                        <select data-placeholder="All Categories"  class="chosen-select" >
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
                                    <button class="main-search-button color-bg" onclick="window.location.href='listing.html'">  Search <i class="far fa-search"></i> </button>
                                </div>
                            </div> --}}
                            {{-- <div class="hero-notifer fl-wrap">Need more search options? <a href="listing.html">Advanced Search</a> </div>
                            <div class="scroll-down-wrap">
                                <div class="mousey">
                                    <div class="scroller"></div>
                                </div>
                                <span>Scroll Down To Discover</span>
                            </div> --}}
                        </div>
                </section>
                <!--  section  end-->
                <!-- breadcrumbs-->
                {{-- <div class="breadcrumbs fw-breadcrumbs sp-brd fl-wrap">
                        <div class="container">
                            <div class="breadcrumbs-list">
                                <a href="#">Home</a>  <span>Home Image</span>
                            </div>
                            <div class="share-holder hid-share">
                                <a href="#" class="share-btn showshare sfcs">  <i class="fas fa-share-alt"></i>  Share   </a>
                                <div class="share-container  isShare"></div>
                            </div>
                        </div>
                    </div> --}}
                <!-- breadcrumbs end -->
                <!-- section -->
                <section class="gray-bg small-padding">
                    <div class="container">
                        {{-- <div class="row">
                                <div class="col-md-4">
                                    <div class="section-title fl-wrap">
                                        <h4>Offres à ne pas manquer</h4>
                                        <h2>Derniers hébergements</h2>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="listing-filters gallery-filters">
                                        <a href="#" class="gallery-filter gallery-filter-active" data-filter="*">
                                            <span>Toutes les catégories</span>
                                        </a>
                                        <a href="#" class="gallery-filter" data-filter=".for_sale">
                                            <span>Logement entier</span>
                                        </a>
                                    </div>
                                </div>
                            </div> --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="section-title fl-wrap">
                                    <h4>{{ __('messages.offers_not_to_miss') }}</h4>
                                    <h2>{{ __('messages.latest_accommodations') }}</h2>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="listing-filters gallery-filters">
                                    <a href="#" class="gallery-filter gallery-filter-active" data-filter="*">
                                        <span>{{ __('messages.all_categories') }}</span>
                                    </a>
                                    @foreach ($typelogements as $type)
                                        @php
                                            $slug = Str::slug($type->libelle, '_'); // ex: "Maison entière" -> "maison_entière"
                                        @endphp
                                        <a href="#" class="gallery-filter"
                                            data-filter=".type-{{ $slug }}">
                                            <span>{{ $type->libelle }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <!-- grid-item-holder-->
                        <div class="grid-item-holder gallery-items gisp fl-wrap">

                            @forelse($logements as $logement)
                                @php
                                    $typeName = $logement->typelogement->libelle ?? 'autre';
                                    $typeSlug = Str::slug($typeName, '_');
                                    $firstPhoto = optional($logement->photos->first())->url;
                                    // classe pour le filtre (si tu veux t'en servir)
                                    $filterClass = $logement->typelogement === 'Maison entière' ? 'for_sale' : 'for_rent';
                                @endphp

                                <!-- gallery-item-->
                                <div class="gallery-item type-{{ $typeSlug }}">
                                    <!-- listing-item -->
                                    <div class="listing-item">
                                        <article class="geodir-category-listing fl-wrap">
                                            <div class="geodir-category-img fl-wrap">
                                                <a href="{{ route('hoost.hebergements.show', $logement->id) }}"
                                                    class="geodir-category-img_item">
                                                    <img src="{{ $firstPhoto ?? asset('assets/images/all/1.jpg') }}"
                                                        alt="{{ app(\App\Services\TranslatorService::class)->translate($logement->titre) }}"
                                                        style="height:260px;object-fit:cover;">
                                                    <div class="overlay"></div>
                                                </a>

                                                <div class="geodir-category-location">
                                                    <a href="#" class="single-map-item tolt"
                                                        data-newlatitude="40.72956781" data-newlongitude="-73.99726866"
                                                        data-microtip-position="top-left" data-tooltip="On the map"><i
                                                            class="fas fa-map-marker-alt"></i>
                                                        <span>{{ $logement->adresse }}</span></a>
                                                </div>

                                                {{-- <ul class="list-single-opt_header_cat">
                                                       <li><a href="#" class="cat-opt blue-bg">Sale</a></li>
                                                       <li><a href="#" class="cat-opt color-bg">Apartment</a></li>
                                                    </ul> --}}

                                                <div class="geodir-category-listing_media-list">
                                                    <span><i class="fas fa-camera"></i>
                                                        {{ $logement->photos->count() }}</span>
                                                </div>
                                            </div>

                                            <div class="geodir-category-content fl-wrap">
                                                <h3 class="title-sin_item">
                                                    <a href="{{ route('hoost.hebergements.show', $logement->id) }}">
                                                        {{ $logement->titre }}
                                                    </a>
                                                </h3>
                                                <div class="geodir-category-content_price">
                                                    {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} FCFA /
                                                    nuit
                                                </div>
                                                <p>{{ \Illuminate\Support\Str::limit($logement->description, 120) }}
                                                </p>

                                                <div class="geodir-category-content-details">
                                                    <ul>
                                                        <li><i
                                                                class="fal fa-bed"></i><span>{{ $logement->nb_chambre }}</span>
                                                        </li>
                                                        <li><i
                                                                class="fal fa-users"></i><span>{{ $logement->nb_voyageur_max }}</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <div class="geodir-category-footer fl-wrap">
                                                    <a href="{{ route('hoost.details.hote', $logement->user->id) }}"
                                                        class="gcf-company"><img src="{{ $logement->user->photo }}"
                                                            alt=""><span>{{ $logement->user->nom . ' ' . $logement->user->prenom }}</span></a>
                                                    {{-- <div class="listing-rating card-popup-rainingvis tolt" data-microtip-position="top" data-tooltip="Good" data-starrating2="4"></div> --}}
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    <!-- listing-item end-->
                                </div>
                                <!-- gallery-item end-->
                            @empty
                                <p>Aucun logement enregistré pour le moment.</p>
                            @endforelse

                        </div>
                        <!-- grid-item-holder-->

                        <a href="{{ route('hoost.hebergements.index') }}" class="btn float-btn small-btn color-bg">
                            {{ __('messages.view_all_listings') }}
                        </a>
                    </div>
                </section>

                <!-- section end-->
                <!-- section -->
                <section>
                    <div class="container">
                        <!--about-wrap -->
                        <div class="about-wrap">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="about-title ab-hero fl-wrap">
                                        <h2>{!! __('messages.why_choose_title') !!}</h2>
                                        <h4>{{ __('messages.why_choose_subtitle') }}</h4>
                                    </div>

                                    <div class="services-opions fl-wrap">
                                        <ul>
                                            <li>
                                                <i class="fal fa-headset"></i>
                                                <h4>{{ __('messages.benefit_support_title') }}</h4>
                                                <p>{{ __('messages.benefit_support_desc') }}</p>
                                            </li>

                                            <li>
                                                <i class="fal fa-hands-helping"></i>
                                                <h4>{{ __('messages.benefit_culture_title') }}</h4>
                                                <p>{{ __('messages.benefit_culture_desc') }}</p>
                                            </li>

                                            <li>
                                                <i class="fal fa-shield-check"></i>
                                                <h4>{{ __('messages.benefit_payment_title') }}</h4>
                                                <p>{{ __('messages.benefit_payment_desc') }}</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-1"></div>

                                <div class="col-md-6">
                                    <div class="about-img fl-wrap">
                                        <img src="{{ asset('assets/images/voodoo/why2.png') }}" class="respimg"
                                            alt="">
                                        <div class="about-img-hotifer color-bg">
                                            <p>{{ __('messages.about_quote') }}</p>
                                            <h4>{{ __('messages.about_quote_author') }}</h4>
                                            <h5>{{ __('messages.about_quote_location') }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="row">
                                    <div class="col-md-5">
                                        <div class="about-title ab-hero fl-wrap">
                                            <h2>Pourquoi choisir <span class="text-warning">Vodoo Host</span> ?</h2>
                                            <h4>Regardez notre présentation pour découvrir comment nous facilitons votre séjour pendant la Fête du Vodoun.</h4>
                                        </div>
                                        <div class="services-opions fl-wrap">
                                            <ul>
                                                <li>
                                                    <i class="fal fa-headset"></i>
                                                    <h4>Assistance 24/7 pendant le festival</h4>
                                                    <p>Support WhatsApp / téléphone pour l’arrivée, l’orientation et les urgences liées aux déplacements.</p>
                                                </li>
                                                <li>
                                                    <i class="fal fa-hands-helping"></i>
                                                    <h4>Médiation culturelle</h4>
                                                    <p>Conseils de respect des rituels et accompagnement par des référents locaux pour une immersion sereine.</p>
                                                </li>
                                                <li>
                                                    <i class="fal fa-shield-check"></i>
                                                    <h4>Paiements sécurisés</h4>
                                                    <p>Réservations et acomptes protégés. Confirmation instantanée et reçus clairs pour voyageurs et hôtes.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="col-md-6">
                                        <div class="about-img fl-wrap">
                                            <img src="{{asset('assets/images/ban.png')}}" class="respimg" alt="">
                                            <div class="about-img-hotifer color-bg">
                                                <p>“Notre priorité : un accueil respectueux des traditions et une logistique fluide pour vivre le Vodoun en toute sérénité.”</p>
                                                <h4>Coordination Vodoo Host</h4>
                                                <h5>Ouidah, Bénin</h5>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div> --}}
                        </div>
                        <!-- about-wrap end  -->
                    </div>
                </section>
                <!-- section end-->
                <!-- section  -->
                {{-- <section class="hidden-section no-padding-section">
                        <div class="half-carousel-wrap">
                            <div class="half-carousel-title color-bg">
                                <div class="half-carousel-title-item fl-wrap">
                                    <h2>Rituels & Divinités vodoun</h2>
                                    <h5>
                                        Plongez au cœur des traditions vodoun : cérémonies, danses, offrandes et rencontres avec les divinités.
                                    </h5>
                                </div>
                                <div class="pwh_bg"></div>
                            </div>
                            <div class="half-carousel-conatiner">
                                <div class="half-carousel fl-wrap full-height">
                                    <!--slick-item -->
                                    <div class="slick-item">
                                        <div class="half-carousel-item fl-wrap">
                                            <div class="bg-wrap bg-parallax-wrap-gradien">
                                                <div class="bg"  data-bg="{{asset('assets/images/voodoo/ban1.png')}}"></div>
                                            </div>
                                            <div class="half-carousel-content">
                                                <div class="hc-counter color-bg">26 Properties</div>
                                                <h3><a href="listing.html">Explore NewYork</a></h3>
                                                <p>Constant care and attention to the patients makes good record</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--slick-item end -->
                                    <!--slick-item -->
                                    <div class="slick-item">
                                        <div class="half-carousel-item fl-wrap">
                                            <div class="bg-wrap bg-parallax-wrap-gradien">
                                                <div class="bg"  data-bg="{{asset('assets/images/voodoo/ban2.png')}}"></div>
                                            </div>
                                            <div class="half-carousel-content">
                                                <div class="hc-counter color-bg">89 Properties</div>
                                                <h3><a href="listing.html">Awesome London</a></h3>
                                                <p>Constant care and attention to the patients makes good record</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--slick-item end -->									
                                    <!--slick-item -->
                                    <div class="slick-item">
                                        <div class="half-carousel-item fl-wrap">
                                            <div class="bg-wrap bg-parallax-wrap-gradien">
                                                <div class="bg"  data-bg="{{asset('assets/images/voodoo/ban3.png')}}"></div>
                                            </div>
                                            <div class="half-carousel-content">
                                                <div class="hc-counter color-bg">102 Properties</div>
                                                <h3><a href="listing.html">Find Dream in Paris</a></h3>
                                                <p>Constant care and attention to the patients makes good record</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--slick-item end -->
                                    <!--slick-item -->
                                    <div class="slick-item">
                                        <div class="half-carousel-item fl-wrap">
                                            <div class="bg-wrap bg-parallax-wrap-gradien">
                                                <div class="bg"  data-bg="{{asset('assets/images/voodoo/ban4.png')}}"></div>
                                            </div>
                                            <div class="half-carousel-content">
                                                <div class="hc-counter color-bg">51 Properties</div>
                                                <h3><a href="listing.html">Elite Houses in Dubai</a></h3>
                                                <p>Constant care and attention to the patients makes good record</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--slick-item end -->									
                                </div>
                            </div>
                        </div>
                    </section> --}}
                <!--section end-->
                <!-- section -->
                <section>
                    <div class="container">
                        <!-- section-title -->
                        <div class="section-title st-center fl-wrap">
                            <h4>Ambassadeurs du Vodoun</h4>
                            <h2>Les hôtes et guides qui vous ouvrent leurs portes</h2>
                        </div>
                        <!-- section-title end -->
                        <div class="clearfix"></div>
                        <div class="listing-carousel-wrapper lc_hero carousel-wrap fl-wrap">
                            <div class="listing-carousel carousel ">
                                <!-- slick-slide-item -->
                                @foreach ($hotes as $hote)
                                    <div class="slick-slide-item">
                                        <!--  agent card item -->
                                        <div class="listing-item">
                                            <article class="geodir-category-listing fl-wrap">
                                                <div class="geodir-category-img fl-wrap  agent_card">
                                                    <a href="{{ route('hoost.details.hote', $hote->id) }}"
                                                        class="geodir-category-img_item">
                                                        <img src="{{ $hote->photo }}" alt="">
                                                        <ul class="list-single-opt_header_cat">
                                                            <li><span
                                                                    class="cat-opt color-bg">{{ $hote->logements_count }}
                                                                    logements</span></li>
                                                        </ul>
                                                    </a>
                                                    {{-- <div class="agent-card-social fl-wrap">
                                                        <ul>
                                                            <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                                            <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                            <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                                        </ul>
                                                    </div> --}}
                                                    {{-- <div class="listing-rating card-popup-rainingvis" data-starrating2="4"><span class="re_stars-title">Good</span></div> --}}
                                                </div>
                                                <div class="geodir-category-content fl-wrap">
                                                    <div class="card-verified tolt" data-microtip-position="left"
                                                        data-tooltip="Verified"><i class="fal fa-user-check"></i>
                                                    </div>
                                                    <div class="agent_card-title fl-wrap">
                                                        <h4><a
                                                                href="{{ route('hoost.details.hote', $hote->id) }}">{{ $hote->nom . ' ' . $hote->prenom }}</a>
                                                        </h4>
                                                        {{-- <h5><a href="agency-single.html">Mavers RealEstate agency</a></h5> --}}
                                                    </div>

                                                    <p>{{ $hote->email ?? 'Biographie non renseignée.' }}</p>
                                                    <div class="geodir-category-footer fl-wrap">
                                                        <a href="{{ route('hoost.details.hote', $hote->id) }}"
                                                            class="btn float-btn color-bg small-btn">Voir profil</a>
                                                        <a href="mailto:yourmail@email.com" class="tolt ftr-btn"
                                                            data-microtip-position="left"
                                                            data-tooltip="Ecrire un message"><i
                                                                class="fal fa-envelope"></i></a>
                                                        <a href="tel:123-456-7890" class="tolt ftr-btn"
                                                            data-microtip-position="left"
                                                            data-tooltip="Appelez maintenant"><i
                                                                class="fal fa-phone"></i></a>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <!--  agent card item end -->
                                    </div>
                                    <!-- slick-slide-item end-->
                                @endforeach
                            </div>
                            <div class="swiper-button-prev lc-wbtn lc-wbtn_prev"><i class="far fa-angle-left"></i>
                            </div>
                            <div class="swiper-button-next lc-wbtn lc-wbtn_next"><i class="far fa-angle-right"></i>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- section end-->
                <!-- section -->
                {{-- <section class="color-bg small-padding">
                        <div class="container">
                            <div class="main-facts fl-wrap">
                                <!-- inline-facts  -->
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="578">0</div>
                                            </div>
                                        </div>
                                        <h6>Agents and Agencys</h6>
                                    </div>
                                </div>
                                <!-- inline-facts end -->
                                <!-- inline-facts  -->
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="12168">0</div>
                                            </div>
                                        </div>
                                        <h6>Happy Customers Every Year</h6>
                                    </div>
                                </div>
                                <!-- inline-facts end -->
                                <!-- inline-facts  -->
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="2172">0</div>
                                            </div>
                                        </div>
                                        <h6>Won Awards</h6>
                                    </div>
                                </div>
                                <!-- inline-facts end -->
                                <!-- inline-facts  -->
                                <div class="inline-facts-wrap">
                                    <div class="inline-facts">
                                        <div class="milestone-counter">
                                            <div class="stats animaper">
                                                <div class="num" data-content="0" data-num="732">0</div>
                                            </div>
                                        </div>
                                        <h6>New Listing Every Week</h6>
                                    </div>
                                </div>
                                <!-- inline-facts end -->
                            </div>
                        </div>
                        <div class="svg-bg">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="100%"
                                height="100%" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMax slice">
                                <defs>
                                    <lineargradient id="bg">
                                        <stop offset="0%" style="stop-color:rgba(255, 255, 255, 0.6)"></stop>
                                        <stop offset="50%" style="stop-color:rgba(255, 255, 255, 0.1)"></stop>
                                        <stop offset="100%" style="stop-color:rgba(255, 255, 255, 0.6)"></stop>
                                    </lineargradient>
                                    <path id="wave" stroke="url(#bg)" fill="none" d="M-363.852,502.589c0,0,236.988-41.997,505.475,0
                                        s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
                                </defs>
                                <g>
                                    <use xlink:href="#wave">
                                        <animatetransform attributeName="transform" attributeType="XML" type="translate" dur="10s" calcMode="spline"
                                            values="270 230; -334 180; 270 230" keyTimes="0; .5; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                                            repeatCount="indefinite" />
                                    </use>
                                    <use xlink:href="#wave">
                                        <animatetransform attributeName="transform" attributeType="XML" type="translate" dur="8s" calcMode="spline"
                                            values="-270 230;243 220;-270 230" keyTimes="0; .6; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                                            repeatCount="indefinite" />
                                    </use>
                                    <use xlink:href="#wave">
                                        <animatetransform attributeName="transform" attributeType="XML" type="translate" dur="6s" calcMode="spline"
                                            values="0 230;-140 200;0 230" keyTimes="0; .4; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                                            repeatCount="indefinite" />
                                    </use>
                                    <use xlink:href="#wave">
                                        <animatetransform attributeName="transform" attributeType="XML" type="translate" dur="12s" calcMode="spline" values="0 240;140 200;0 230"
                                            keyTimes="0; .4; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0" repeatCount="indefinite" />
                                    </use>
                                </g>
                            </svg>
                        </div>
                    </section> --}}
                {{-- <section class="color-bg small-padding" style="position:relative; overflow:hidden;">
                    <div class="container">
                        <div class="main-facts fl-wrap">
                            <!-- inline-facts : Hôtes inscrits -->
                            <div class="inline-facts-wrap">
                                <div class="inline-facts" aria-label="Hôtes inscrits">
                                    <div class="milestone-counter">
                                        <div class="stats animaper">
                                            <div class="num" data-content="0" data-num="">0</div>
                                        </div>
                                    </div>
                                    <h6>Hôtes inscrits</h6>
                                </div>
                            </div>
                            <!-- inline-facts : Voyageurs accueillis -->
                            <div class="inline-facts-wrap">
                                <div class="inline-facts" aria-label="Voyageurs accueillis">
                                    <div class="milestone-counter">
                                        <div class="stats animaper">
                                            <div class="num" data-content="0" data-num="">0</div>
                                        </div>
                                    </div>
                                    <h6>Voyageurs accueillis (cette année)</h6>
                                </div>
                            </div>
                            <!-- inline-facts : Réservations confirmées -->
                            <div class="inline-facts-wrap">
                                <div class="inline-facts" aria-label="Réservations confirmées">
                                    <div class="milestone-counter">
                                        <div class="stats animaper">
                                            <div class="num" data-content="0" data-num="">0</div>
                                        </div>
                                    </div>
                                    <h6>Réservations confirmées</h6>
                                </div>
                            </div>
                            <!-- inline-facts : Expériences & rituels -->
                            <div class="inline-facts-wrap">
                                <div class="inline-facts" aria-label="Expériences et rituels">
                                    <div class="milestone-counter">
                                        <div class="stats animaper">
                                            <div class="num" data-content="0" data-num="">0</div>
                                        </div>
                                    </div>
                                    <h6>Expériences & rituels disponibles</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fond SVG conservé -->
                    <div class="svg-bg" aria-hidden="true">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100%"
                            height="100%" viewBox="0 0 1600 900" preserveAspectRatio="xMidYMax slice">
                            <defs>
                                <linearGradient id="bg">
                                    <stop offset="0%" style="stop-color:rgba(255, 255, 255, 0.6)"></stop>
                                    <stop offset="50%" style="stop-color:rgba(255, 255, 255, 0.1)"></stop>
                                    <stop offset="100%" style="stop-color:rgba(255, 255, 255, 0.6)"></stop>
                                </linearGradient>
                                <path id="wave" stroke="url(#bg)" fill="none"
                                    d="M-363.852,502.589c0,0,236.988-41.997,505.475,0
                            s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v560.106H-363.852V502.589z" />
                            </defs>
                            <g>
                                <use xlink:href="#wave">
                                    <animateTransform attributeName="transform" attributeType="XML" type="translate"
                                        dur="10s" calcMode="spline" values="270 230; -334 180; 270 230"
                                        keyTimes="0; .5; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                                        repeatCount="indefinite" />
                                </use>
                                <use xlink:href="#wave">
                                    <animateTransform attributeName="transform" attributeType="XML" type="translate"
                                        dur="8s" calcMode="spline" values="-270 230;243 220;-270 230"
                                        keyTimes="0; .6; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                                        repeatCount="indefinite" />
                                </use>
                                <use xlink:href="#wave">
                                    <animateTransform attributeName="transform" attributeType="XML" type="translate"
                                        dur="6s" calcMode="spline" values="0 230;-140 200;0 230"
                                        keyTimes="0; .4; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                                        repeatCount="indefinite" />
                                </use>
                                <use xlink:href="#wave">
                                    <animateTransform attributeName="transform" attributeType="XML" type="translate"
                                        dur="12s" calcMode="spline" values="0 240;140 200;0 230"
                                        keyTimes="0; .4; 1" keySplines="0.42, 0, 0.58, 1.0;0.42, 0, 0.58, 1.0"
                                        repeatCount="indefinite" />
                                </use>
                            </g>
                        </svg>
                    </div>
                </section> --}}

                <!-- section end-->
                <!-- section -->
                <section class="gray-bg ">
                    <div class="container">
                        <div class="section-title st-center fl-wrap">
                            <h4>Témoignages</h4>
                            <h2>Ce que disent nos voyageurs</h2>
                        </div>
                    </div>

                    <div class="testimonials-slider-wrap">
                        <div class="testimonials-slider">

                            @foreach ($avis as $t)
                                <div class="slick-item">
                                    <div class="text-carousel-item fl-wrap">

                                        <div class="text-carousel-item-header fl-wrap">

                                            {{-- Avatar utilisateur ou image par défaut --}}
                                            <div class="popup-avatar">
                                                <img src="{{ $t->user->photo ?? asset('assets/images/avatar/1.jpg') }}"
                                                    alt="{{ $t->user->nom }}">
                                            </div>

                                            {{-- Nom utilisateur --}}
                                            <div class="review-owner fl-wrap">
                                                {{ $t->user->nom }}
                                            </div>

                                            {{-- Note dynamique (étoiles) --}}
                                            <div class="listing-rating card-popup-rainingvis"
                                                data-starrating2="{{ $t->notes }}">
                                            </div>

                                        </div>

                                        <div class="text-carousel-content fl-wrap">
                                            <p>"{{ \Illuminate\Support\Str::limit($t->commentaire, 140) }}"</p>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>


            </div>
            <!-- content end -->
            <!-- subscribe-wrap -->
            @include('partials.newsletter')
            <!-- subscribe-wrap end -->
            @include('partials.footer')
        </div>
        <!-- wrapper end -->
        <!--register form -->
        @include('partials/register_login')
        <!--register form end -->
        <!--secondary-nav -->
        <div class="secondary-nav">
            <ul>
                <li><a href="{{ route('hoost.hebergements.index') }}" class="tolt" data-microtip-position="left"
                        data-tooltip="Voir tous les logements"> <i class="fal fa-shopping-bag"></i></a></li>
            </ul>
            <div class="progress-indicator">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34">
                    <circle cx="16" cy="16" r="15.9155" class="progress-bar__background" />
                    <circle cx="16" cy="16" r="15.9155"
                        class="progress-bar__progress 
                            js-progress-bar" />
                </svg>
            </div>
        </div>
        <!--secondary-nav end -->
        <a class="to-top color-bg"><i class="fas fa-caret-up"></i></a>
        <!--map-modal -->
        <div class="map-modal-wrap">
            <div class="map-modal-wrap-overlay"></div>
            <div class="map-modal-item">
                <div class="map-modal-container fl-wrap">
                    <h3> <span>Listing Title </span></h3>
                    <div class="map-modal-close"><i class="far fa-times"></i></div>
                    <div class="map-modal fl-wrap">
                        <div id="singleMap" data-latitude="40.7" data-longitude="-73.1"></div>
                        <div class="scrollContorl"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--map-modal end -->
    </div>
    <!-- Main end -->
    <!--=============== scripts  ===============-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOU_API_KEY_HERE&libraries=places"></script>
    <script src="{{ asset('assets/js/map-single.js') }}"></script>
</body>

</html>
