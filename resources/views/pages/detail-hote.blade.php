<!DOCTYPE HTML>
<html lang="en">

<head>
    <!--=============== basic  ===============-->
    <meta charset="UTF-8">
    <title>Voodoo hoost</title>
    <meta name="robots" content="index, follow" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <!--=============== css  ===============-->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <!--=============== favicons ===============-->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
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
                <!-- breadcrumbs-->
                {{-- <div class="breadcrumbs fw-breadcrumbs sp-brd fl-wrap   top-smpar  ">
                        <div class="container">
                            <div class="breadcrumbs-list">
                                <a href="#">Home</a><a href="#">Agency</a> <span>Agent Single</span>
                            </div>
                            <div class="share-holder hid-share">
                                <a href="#" class="share-btn showshare sfcs">  <i class="fas fa-share-alt"></i>  Share   </a>
                                <div class="share-container  isShare"></div>
                            </div>
                        </div>
                    </div> --}}
                <!-- breadcrumbs end -->
                <!-- col-list-wrap -->
                <section class="gray-bg small-padding ">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card-info smpar fl-wrap">
                                    {{-- <div class="box-widget-menu-btn smact"><i class="far fa-ellipsis-h"></i></div>
                                        <div class="show-more-snopt-tooltip bxwt">
                                            <a href="#"> <i class="fas fa-comment-alt"></i> Write a review</a>
                                            <a href="#"> <i class="fas fa-exclamation-triangle"></i> Report </a>
                                        </div> --}}
                                    <div class="bg-wrap bg-parallax-wrap-gradien">
                                        <div class="bg" data-bg="images/bg/1.jpg"></div>
                                    </div>
                                    <div class="card-info-media">
                                        <div class="bg" data-bg="{{ $hote->photo }}"></div>
                                    </div>
                                    <div class="card-info-content">
                                        <div class="agent_card-title fl-wrap">
                                            <h4> {{ $hote->nom . ' ' . $hote->prenom }} </h4>
                                            {{-- <div class="geodir-category-location fl-wrap">
                                                    <h5><a href="agency-single.html">Mavers RealEstate Agency</a></h5>
                                                    <div class="listing-rating card-popup-rainingvis" data-starrating2="4"><span class="re_stars-title">Good</span></div>
                                                </div> --}}
                                        </div>
                                        <div class="list-single-stats">
                                            <ul class="no-list-style">
                                                @php
                                                    $avgRating = $hote->averageRating(); // moyenne des notes
                                                    $reviewsCount = $hote->reviewsCount(); // nombre d'avis
                                                    $avgRatingRounded = $avgRating ? round($avgRating, 1) : null;
                                                @endphp
                                                {{-- <li><span class="viewed-counter"><i class="fas fa-eye"></i> Viewed -  156 </span></li> --}}
                                                <li><span class="bookmark-counter"><i class="fas fa-comment-alt"></i>
                                                        @if ($reviewsCount > 0)
                                                            Avis - {{ $reviewsCount }}
                                                            {{-- ({{ $avgRatingRounded }}/5) --}}
                                                        @else
                                                            Avis - Aucun avis
                                                        @endif
                                                    </span>
                                                </li>
                                                <li><span class="bookmark-counter"><i class="fas fa-sitemap"></i>
                                                        Logements - {{ $hote->logements->count() }} </span></li>
                                            </ul>
                                        </div>
                                        <div class="card-verified tolt" data-microtip-position="left"
                                            data-tooltip="Verified"><i class="fal fa-user-check"></i></div>
                                    </div>
                                </div>
                                <div class="list-single-main-container fl-wrap">
                                    <!-- list-single-main-item -->
                                    <div class="list-single-main-item fl-wrap">
                                        <div class="list-single-main-item-title">
                                            <h3>A propos de l'hôte</h3>
                                        </div>
                                        <div class="list-single-main-item_content fl-wrap">
                                            <p>{{ $hote->bio ?? 'AUCUN' }}</p>
                                            {{-- <div class="list-single-tags fl-wrap tags-stylwrap" style="margin-top: 20px;">
                                                    <span>Service Areas:</span>
                                                    <a href="#">London</a>
                                                    <a href="#">NewYork</a>
                                                    <a href="#">Rome</a>
                                                    <a href="#">Dubai</a>
                                                </div> --}}
                                        </div>
                                    </div>
                                    <!-- list-single-main-item end -->
                                </div>
                                <!-- content-tabs-wrap -->
                                <div class="content-tabs-wrap tabs-act fl-wrap">
                                    <div class="content-tabs fl-wrap">
                                        <ul class="tabs-menu fl-wrap no-list-style">
                                            <li class="current"><a href="#tab-listing"> Les logements de l'hôte </a>
                                            </li>
                                            {{-- <li><a href="#tab-reviews">Commentaires</a></li> --}}
                                        </ul>
                                    </div>
                                    <!--tabs -->
                                    <div class="tabs-container">
                                        <!--tab -->
                                        <div class="tab">
                                            <div id="tab-listing" class="tab-content first-tab">
                                                <!-- listing-item-wrap-->
                                                <div
                                                    class="listing-item-container one-column-grid-wrap  box-list_ic fl-wrap">
                                                    @foreach ($logements as $key => $logement)
                                                        @php
                                                            // Première photo du logement
                                                            $firstPhoto = optional($logement->photos->first())->url;
                                                        @endphp
                                                        <!-- listing-item -->
                                                        <div class="listing-item">
                                                            <article class="geodir-category-listing fl-wrap">
                                                                <div class="geodir-category-img fl-wrap">
                                                                    <a href="{{ route('hoost.hebergements.show', $logement->id) }}"
                                                                        class="geodir-category-img_item">
                                                                        <img src="{{ $firstPhoto }}" alt="">
                                                                        <div class="overlay"></div>
                                                                    </a>
                                                                    <div class="geodir-category-location">
                                                                        <a href="#" class="single-map-item tolt"
                                                                            data-newlatitude="40.72228267"
                                                                            data-newlongitude="-73.99246214"
                                                                            data-microtip-position="top-left"
                                                                            data-tooltip="On the map"><i
                                                                                class="fas fa-map-marker-alt"></i>
                                                                            <span>{{ $logement->adresse }}</span></a>
                                                                    </div>
                                                                    {{-- <ul class="list-single-opt_header_cat">
                                                                        <li><a href="#" class="cat-opt blue-bg">Sale</a></li>
                                                                        <li><a href="#" class="cat-opt color-bg">Apartment</a></li>
                                                                    </ul> --}}
                                                                    {{-- <a href="#" class="geodir_save-btn tolt" data-microtip-position="left" data-tooltip="Save"><span><i class="fal fa-heart"></i></span></a>
                                                                    <a href="#" class="compare-btn tolt" data-microtip-position="left" data-tooltip="Compare"><span><i class="fal fa-random"></i></span></a> --}}
                                                                    <div class="geodir-category-listing_media-list">
                                                                        <span><i
                                                                                class="fas fa-camera"></i>{{ $logement->photos->count() }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="geodir-category-content fl-wrap">
                                                                    <h3 class="title-sin_item"><a
                                                                            href="listing-single.html">{{ $logement->titre }}</a>
                                                                    </h3>
                                                                    <div class="geodir-category-content_price">FCFA
                                                                        {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }}
                                                                    </div>
                                                                    <p>
                                                                        {{ \Illuminate\Support\Str::limit($logement->description, 250) }}
                                                                    </p>
                                                                    <div class="geodir-category-content-details">
                                                                        <ul>
                                                                            <li><i
                                                                                    class="fal fa-bed"></i><span>{{ $logement->nb_chambre }}</span>
                                                                            </li>
                                                                            <li><i
                                                                                    class="fal fa-users"></i><span>{{ $logement->nb_voyageur_max }}</span>
                                                                            </li>
                                                                            {{-- <li><i class="fal fa-cube"></i><span>550 ft2</span></li> --}}
                                                                        </ul>
                                                                    </div>
                                                                    <div class="geodir-category-footer fl-wrap">
                                                                        <a href="{{ route('hoost.details.hote', $hote->id) }}"
                                                                            class="gcf-company"><img
                                                                                src="{{ $hote->photo }}"
                                                                                alt=""><span>{{ $hote->nom . ' ' . $hote->prenom }}</span></a>
                                                                        <div class="listing-rating card-popup-rainingvis tolt"
                                                                            data-microtip-position="top"
                                                                            data-tooltip="Excellent"
                                                                            data-starrating2="5"></div>
                                                                    </div>
                                                                </div>
                                                            </article>
                                                        </div>
                                                    @endforeach
                                                    <!-- listing-item end-->
                                                </div>
                                                <!-- listing-item-wrap end-->
                                                <!-- pagination-->
                                                @if ($logements->hasPages())
                                                    <div class="pagination">
                                                        {{-- Précédent --}}
                                                        @if ($logements->onFirstPage())
                                                            <a href="javascript:void(0)"
                                                                class="prevposts-link disabled">
                                                                <i class="fa fa-caret-left"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ $logements->previousPageUrl() }}"
                                                                class="prevposts-link">
                                                                <i class="fa fa-caret-left"></i>
                                                            </a>
                                                        @endif

                                                        {{-- Pages --}}
                                                        @for ($page = 1; $page <= $logements->lastPage(); $page++)
                                                            @if ($page == $logements->currentPage())
                                                                {{-- Page active : même structure que le template --}}
                                                                <a href="{{ $logements->url($page) }}"
                                                                    class="current-page">
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
                                                            <a href="{{ $logements->nextPageUrl() }}"
                                                                class="nextposts-link">
                                                                <i class="fa fa-caret-right"></i>
                                                            </a>
                                                        @else
                                                            <a href="javascript:void(0)"
                                                                class="nextposts-link disabled">
                                                                <i class="fa fa-caret-right"></i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif
                                                <!-- pagination end-->
                                            </div>
                                        </div>
                                        <!--tab  end-->
                                        <!--tab -->
                                        <div class="tab">
                                            <div id="tab-reviews" class="tab-content">
                                                <div class="list-single-main-container fl-wrap"
                                                    style="margin-top: 30px;">
                                                    <!-- list-single-main-item -->
                                                    <div class="list-single-main-item fl-wrap" id="sec6">
                                                        <div class="list-single-main-item-title">
                                                            <h3>Commentaires <span>2</span></h3>
                                                        </div>
                                                        <div class="list-single-main-item_content fl-wrap">
                                                            <div class="reviews-comments-wrap fl-wrap">
                                                                <div class="review-total">
                                                                    <span class="review-number blue-bg">5.0</span>
                                                                    <div class="listing-rating card-popup-rainingvis"
                                                                        data-starrating2="5"><span
                                                                            class="re_stars-title">Excellent</span>
                                                                    </div>
                                                                </div>
                                                                <!-- reviews-comments-item -->
                                                                <div class="reviews-comments-item">
                                                                    <div class="review-comments-avatar">
                                                                        <img src="images/avatar/1.jpg" alt="">
                                                                    </div>
                                                                    <div class="reviews-comments-item-text smpar">
                                                                        <div class="box-widget-menu-btn smact"><i
                                                                                class="far fa-ellipsis-h"></i></div>
                                                                        <div class="show-more-snopt-tooltip bxwt">
                                                                            <a href="#"> <i
                                                                                    class="fas fa-reply"></i> Reply</a>
                                                                            <a href="#"> <i
                                                                                    class="fas fa-exclamation-triangle"></i>
                                                                                Report </a>
                                                                        </div>
                                                                        <h4><a href="#">Liza Rose</a></h4>
                                                                        <div class="listing-rating card-popup-rainingvis"
                                                                            data-starrating2="5"><span
                                                                                class="re_stars-title">Excellent</span>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <p>" Donec quam felis, ultricies nec,
                                                                            pellentesque eu, pretium quis, sem. Nulla
                                                                            consequat massa quis enim. Donec pede justo,
                                                                            fringilla vel, aliquet nec, vulputate eget,
                                                                            arcu. In enim justo, rhoncus ut, imperdiet
                                                                            a, venenatis vitae, justo. Nullam dictum
                                                                            felis eu pede mollis pretium. "</p>
                                                                        <div class="reviews-comments-item-date"><span
                                                                                class="reviews-comments-item-date-item"><i
                                                                                    class="far fa-calendar-check"></i>12
                                                                                April 2018</span><a href="#"
                                                                                class="rate-review"><i
                                                                                    class="fal fa-thumbs-up"></i>
                                                                                Helpful Review <span>6</span> </a></div>
                                                                    </div>
                                                                </div>
                                                                <!--reviews-comments-item end-->
                                                                <!-- reviews-comments-item -->
                                                                <div class="reviews-comments-item">
                                                                    <div class="review-comments-avatar">
                                                                        <img src="images/avatar/1.jpg" alt="">
                                                                    </div>
                                                                    <div class="reviews-comments-item-text smpar">
                                                                        <div class="box-widget-menu-btn smact"><i
                                                                                class="far fa-ellipsis-h"></i></div>
                                                                        <div class="show-more-snopt-tooltip bxwt">
                                                                            <a href="#"> <i
                                                                                    class="fas fa-reply"></i> Reply</a>
                                                                            <a href="#"> <i
                                                                                    class="fas fa-exclamation-triangle"></i>
                                                                                Report </a>
                                                                        </div>
                                                                        <h4><a href="#">Adam Koncy</a></h4>
                                                                        <div class="listing-rating card-popup-rainingvis"
                                                                            data-starrating2="5"><span
                                                                                class="re_stars-title">Excellent</span>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <p>" Lorem ipsum dolor sit amet, consectetur
                                                                            adipiscing elit. Nunc posuere convallis
                                                                            purus non cursus. Cras metus neque, gravida
                                                                            sodales massa ut. "</p>
                                                                        <div class="reviews-comments-item-date"><span
                                                                                class="reviews-comments-item-date-item"><i
                                                                                    class="far fa-calendar-check"></i>03
                                                                                December 2017</span><a href="#"
                                                                                class="rate-review"><i
                                                                                    class="fal fa-thumbs-up"></i>
                                                                                Helpful Review <span>2</span> </a></div>
                                                                    </div>
                                                                </div>
                                                                <!--reviews-comments-item end-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- list-single-main-item end -->
                                                    <!-- list-single-main-item -->
                                                    {{-- <div class="list-single-main-item fl-wrap" id="sec5">
                                                            <div class="list-single-main-item-title fl-wrap">
                                                                <h3>Add Your Review</h3>
                                                            </div>
                                                            <!-- Add Review Box -->
                                                            <div id="add-review" class="add-review-box">
                                                                <div class="leave-rating-wrap">
                                                                    <span class="leave-rating-title">Your rating  for this listing : </span>
                                                                    <div class="leave-rating">
                                                                        <input type="radio"    data-ratingtext="Excellent"   name="rating" id="rating-1" value="1"/>
                                                                        <label for="rating-1" class="fal fa-star"></label>
                                                                        <input type="radio" data-ratingtext="Good" name="rating" id="rating-2" value="2"/>
                                                                        <label for="rating-2" class="fal fa-star"></label>
                                                                        <input type="radio" name="rating"  data-ratingtext="Average" id="rating-3" value="3"/>
                                                                        <label for="rating-3" class="fal fa-star"></label>
                                                                        <input type="radio" data-ratingtext="Fair" name="rating" id="rating-4" value="4"/>
                                                                        <label for="rating-4" class="fal fa-star"></label>
                                                                        <input type="radio" data-ratingtext="Very Bad "   name="rating" id="rating-5" value="5"/>
                                                                        <label for="rating-5"    class="fal fa-star"></label>
                                                                    </div>
                                                                    <div class="count-radio-wrapper">
                                                                        <span id="count-checked-radio">Your Rating</span>  
                                                                    </div>
                                                                </div>
                                                                <!-- Review Comment -->
                                                                <form   class="add-comment custom-form">
                                                                    <fieldset>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label>Your name* <span class="dec-icon"><i class="fas fa-user"></i></span></label>
                                                                                <input   name="phone" type="text"    onClick="this.select()" value="">
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Yourmail* <span class="dec-icon"><i class="fas fa-envelope"></i></span></label>
                                                                                <input   name="reviewwname" type="text"    onClick="this.select()" value="">
                                                                            </div>
                                                                        </div>
                                                                        <textarea cols="40" rows="3" placeholder="Your Review:"></textarea>
                                                                    </fieldset>
                                                                    <button class="btn big-btn color-bg float-btn">Submit Review <i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                                                </form>
                                                            </div>
                                                            <!-- Add Review Box / End -->
                                                        </div> --}}
                                                    <!-- list-single-main-item end -->
                                                </div>
                                            </div>
                                        </div>
                                        <!--tab end-->
                                    </div>
                                    <!--tabs end-->
                                </div>
                                <!-- content-tabs-wrap end -->
                            </div>
                            <!-- col-md 8 end -->
                            <!--  sidebar-->
                            <div class="col-md-4">
                                <!--box-widget-->
                                <div class="box-widget bwt-first fl-wrap">
                                    <div
                                        class="box-widget-title fl-wrap box-widget-title-color color-bg no-top-margin">
                                        Contact de l'hôte</div>
                                    <div class="box-widget-content fl-wrap">
                                        <div class="contats-list clm fl-wrap">
                                            <ul class="no-list-style">
                                                <li><span><i class="fal fa-phone"></i> Téléphone:</span> <a
                                                        href="tel:{{ $hote->telephone }}">{{ $hote->telephone }}</a>
                                                </li>
                                                <li><span><i class="fal fa-envelope"></i> Adresse Email:</span> <a
                                                        href="mailto:{{ $hote->email }}">{{ $hote->email }}</a>
                                                </li>
                                                {{-- <li><span><i class="fal fa-map-marker"></i> Adress :</span> <a href="#"> 70 Bright St New York, USA</a></li>
                                                    <li><span><i class="fal fa-browser"></i> Website :</span> <a href="#">themeforest.net</a></li> --}}
                                            </ul>
                                        </div>
                                        <div class="profile-widget-footer fl-wrap">
                                            <div class="card-info-content_social ">
                                                <ul>
                                                    <li><a href="#" target="_blank"><i
                                                                class="fab fa-facebook-f"></i></a></li>
                                                    {{-- <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                                        <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                                        <li><a href="#" target="_blank"><i class="fab fa-vk"></i></a></li> --}}
                                                </ul>
                                            </div>
                                            <a href="#sec-contact" class="custom-scroll-link tolt csls"
                                                data-microtip-position="left" data-tooltip="Ecrire un message"><i
                                                    class="fal fa-paper-plane"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <!--box-widget end -->
                                <!--box-widget-->
                                <div class="box-widget fl-wrap">
                                    <div class="box-widget-fixed-init fl-wrap" id="sec-contact">
                                        <div
                                            class="box-widget-title fl-wrap box-widget-title-color color-bg no-top-margin">
                                            Prendre Contact</div>
                                        <div class="box-widget-content fl-wrap">
                                            <div class="custom-form">
                                                <form method="POST"
                                                    action="{{ route('hoost.hote.contact',['host' => $hote->id]) }}"
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
                                        </div>
                                    </div>
                                </div>
                                <!--box-widget end -->
                            </div>
                            <!--   sidebar end-->
                        </div>
                    </div>
                    <div class="limit-box fl-wrap"></div>
                </section>
            </div>
            <!-- content end -->
            <!-- subscribe-wrap -->

            <!-- subscribe-wrap -->
            @include('partials.newsletter')
            <!-- subscribe-wrap end -->
            @include('partials.footer')

            <!-- footer end -->
        </div>
        <!-- wrapper end -->
        <!--register form -->
        @include('partials/register_login')
        <!--register form end -->
        <!--secondary-nav -->
        <div class="secondary-nav">
            {{-- <ul>
                    <li><a href="dashboard-add-listing.html" class="tolt" data-microtip-position="left"  data-tooltip="Sell Property"><i class="fal fa-truck-couch"></i> </a></li>
                    <li><a href="listing.html" class="tolt" data-microtip-position="left"  data-tooltip="Buy Property"> <i class="fal fa-shopping-bag"></i></a></li>
                    <li><a href="compare.html" class="tolt" data-microtip-position="left"  data-tooltip="Your Compare"><i class="fal fa-exchange"></i></a></li>
                </ul> --}}
            {{-- <div class="progress-indicator">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="-1 -1 34 34">
                        <circle cx="16" cy="16" r="15.9155"
                            class="progress-bar__background" />
                        <circle cx="16" cy="16" r="15.9155"
                            class="progress-bar__progress 
                            js-progress-bar" />
                    </svg>
                </div> --}}
        </div>
        <!--secondary-nav end -->
        <a class="to-top color-bg"><i class="fas fa-caret-up"></i></a>
    </div>
    <!-- Main end -->
    <!--=============== scripts  ===============-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

</body>

</html>
