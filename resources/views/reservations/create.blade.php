<!DOCTYPE HTML>
<html lang="fr">
<head>
    <!--=============== basic  ===============-->
    <meta charset="UTF-8">
    <title>Voodoo Hoost - Confirmation de réservation</title>
    <meta name="robots" content="noindex, follow"/>
    <meta name="keywords" content=""/>
    <meta name="description" content="Confirmation de réservation Voodoo Hoost"/>
    <!-- css   -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/plugins.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/color.css')}}">
    <!--  favicons  -->
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
</head>
<body>
<!--loader-->
<div class="loader-wrap">
    <div class="loader-inner">
        <svg>
            <defs>
                <filter id="goo">
                    <fegaussianblur in="SourceGraphic" stdDeviation="2" result="blur"/>
                    <fecolormatrix in="blur"
                                   values="1 0 0 0 0  
                                           0 1 0 0 0  
                                           0 0 1 0 0  
                                           0 0 0 5 -2"
                                   result="gooey"/>
                    <fecomposite in="SourceGraphic" in2="gooey" operator="atop"/>
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
            <section class="parallax-section single-par color-bg">
                <div class="container">
                    <div class="section-title center-align big-title">
                        <h2><span>Confirmation de votre séjour</span></h2>
                        <h4>Vérifiez les détails de votre réservation et choisissez votre mode de paiement.</h4>
                    </div>
                    <div class="clearfix" style="margin-top:15px;">
                        <div class="booking-steps fl-wrap">
                            <ul class="no-list-style">
                                <li class="current">
                                    <span>Étape 1</span>
                                    <h5>Détails du séjour</h5>
                                </li>
                                <li class="current">
                                    <span>Étape 2</span>
                                    <h5>Paiement sécurisé</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="pwh_bg"></div>
                <div class="mrb_pin vis_mr mrb_pin3 "></div>
                <div class="mrb_pin vis_mr mrb_pin4 "></div>
            </section>
            <!--  section  end-->

            <section class="gray-bg small-padding">
                <div class="container">
                    <div class="row">
                        <!-- Col gauche : résumé -->
                        <div class="col-md-8">
                            <div class="box-widget fl-wrap">
                                <div class="box-widget-title fl-wrap box-widget-title-color color-bg">
                                    Résumé de votre séjour
                                </div>
                                <div class="box-widget-content fl-wrap">
                                    <div class="list-single-main-item fl-wrap">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="booking-summary-img fl-wrap">
                                                    @php
                                                        $firstPhoto = optional($logement->photos->first())->url;
                                                    @endphp
                                                    <img src="{{ $firstPhoto ?? asset('assets/images/all/no-image.jpg') }}"
                                                         alt="{{ $logement->titre }}"
                                                         style="width:100%;border-radius:8px;object-fit:cover;">
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <h3 class="title-sin_item" style="margin-bottom:8px;">
                                                    {{ $logement->titre }}
                                                </h3>
                                                <div class="geodir-category-location" style="margin-bottom:10px;">
                                                    <a href="#" class="single-map-item">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <span>{{ $logement->adresse }}</span>
                                                    </a>
                                                </div>
                                                <div class="geodir-category-content-details">
                                                    <ul>
                                                        <li><i class="fal fa-bed"></i><span>{{ $logement->nb_chambre }} chambres</span></li>
                                                        <li><i class="fal fa-users"></i><span>{{ $nbVoyageurs }} voyageur(s)</span></li>
                                                    </ul>
                                                </div>
                                                <div class="clearfix" style="margin-top:10px;">
                                                    <span class="geodir-category-content_price">
                                                        {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} FCFA / nuit
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix" style="margin-top:20px;border-top:1px solid #eee;padding-top:15px;">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <h5>Dates du séjour</h5>
                                                    <ul class="no-list-style">
                                                        <li>
                                                            <i class="fal fa-calendar-check"></i>
                                                            <span>Arrivée : {{\Carbon\Carbon::parse($debut)->format('d/m/Y') }}</span>
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-calendar-alt"></i>
                                                            <span>Départ : {{\Carbon\Carbon::parse($fin)->format('d/m/Y') }}</span>
                                                        </li>
                                                        <li>
                                                            <i class="fal fa-moon"></i>
                                                            <span>{{ $nbNuits }} nuit{{ $nbNuits > 1 ? 's' : '' }}</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h5>Projet communautaire</h5>
                                                    @if($projet)
                                                        <p style="margin-bottom:5px;">
                                                            <strong></strong>
                                                        </p>
                                                        <p style="font-size:13px;">
                                                            Contribution :  % du montant du séjour<br>
                                                            Montant estimé : 
                                                            <strong> FCFA</strong>
                                                        </p>
                                                    @else
                                                        <p style="font-size:13px;">
                                                            Aucun projet sélectionné. Une partie de votre séjour pourra soutenir
                                                            un projet communautaire local.
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Détail des montants -->
                                    <div class="cart-total fl-wrap" style="margin-top:10px;">
                                        <h4>Détail du montant</h4>
                                        <ul class="no-list-style">
                                            <li>
                                                <span>Sous-total ({{ $nbNuits }} nuit{{ $nbNuits > 1 ? 's' : '' }})</span>
                                                <strong>{{ number_format($prixTotal, 0, ',', ' ') }} FCFA</strong>
                                            </li>
                                            @if($contribution > 0)
                                                <li>
                                                    <span>Contribution projet </span>
                                                    <strong>150 FCFA</strong>
                                                </li>
                                            @endif
                                            <li>
                                                <span>Frais de service Voodoo Hoost</span>
                                                <strong> FCFA</strong>
                                            </li>
                                            <li class="cart-total-item">
                                                <span>Total à payer</span>
                                                <strong> FCFA</strong>
                                            </li>
                                        </ul>
                                        <p style="font-size:12px;color:#777;margin-top:5px;">
                                            En confirmant, vous acceptez les conditions générales de Voodoo Hoost et les règles
                                            de l’hébergement.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Col droite : paiement -->
                        <div class="col-md-4">
                            <form action="{{ route('hoost.reservations.store', $logement) }}" method="POST">
                                @csrf
                                {{-- <input type="hidden" name="date_debut" value="{{ $dateDebut->toDateString() }}">
                                <input type="hidden" name="date_fin" value="{{ $dateFin->toDateString() }}">
                                <input type="hidden" name="nb_voyageur" value="{{ $nbVoyageurs }}">
                                <input type="hidden" name="projet_id" value="{{ $projet->id ?? '' }}">
                                <input type="hidden" name="nb_nuits" value="{{ $nbNuits }}">
                                <input type="hidden" name="montant_contribution" value="{{ $montantContribution }}">
                                <input type="hidden" name="frais_service" value="{{ $fraisService }}">
                                <input type="hidden" name="total" value="{{ $total }}"> --}}

                                <div class="box-widget fl-wrap">
                                    <div class="box-widget-title fl-wrap box-widget-title-color color-bg">
                                        Paiement sécurisé
                                    </div>
                                    <div class="box-widget-content fl-wrap">
                                        <div class="listsearch-input-item">
                                            <label>Choisissez un mode de paiement</label>

                                            <div class="payment-method-card fl-wrap">
                                                <label class="payment-option">
                                                    <input type="radio" name="payment_method" value="carte" checked>
                                                    <span class="payment-option-inner">
                                                        <i class="fal fa-credit-card"></i>
                                                        <span>
                                                            <strong>Carte bancaire (Visa / Mastercard)</strong><br>
                                                            <small>Paiement instantané et sécurisé.</small>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="payment-method-card fl-wrap">
                                                <label class="payment-option">
                                                    <input type="radio" name="payment_method" value="mobile_money">
                                                    <span class="payment-option-inner">
                                                        <i class="fal fa-mobile-alt"></i>
                                                        <span>
                                                            <strong>Mobile Money (MTN / Moov)</strong><br>
                                                            <small>Vous serez redirigé vers votre opérateur.</small>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>

                                            <div class="payment-method-card fl-wrap">
                                                <label class="payment-option">
                                                    <input type="radio" name="payment_method" value="virement">
                                                    <span class="payment-option-inner">
                                                        <i class="fal fa-university"></i>
                                                        <span>
                                                            <strong>Virement bancaire</strong><br>
                                                            <small>Les instructions vous seront envoyées par e-mail.</small>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Récap final -->
                                <div class="box-widget fl-wrap">
                                    <div class="box-widget-title fl-wrap">
                                        Récapitulatif du paiement
                                    </div>
                                    <div class="box-widget-content fl-wrap">
                                        <div class="cart-total fl-wrap" style="margin-bottom:10px;">
                                            <ul class="no-list-style">
                                                <li class="cart-total-item">
                                                    <span>Total à payer maintenant</span>
                                                    <strong style="font-size:20px;">
                                                        {{ number_format($prixTotal, 0, ',', ' ') }} FCFA
                                                    </strong>
                                                </li>
                                            </ul>
                                        </div>
                                        <button type="submit" class="btn float-btn color-bg fw-btn"
                                                style="width:100%;text-align:center;">
                                            Confirmer et payer
                                        </button>
                                        <a href="{{ url()->previous() }}"
                                           class="btn flat-btn color2-bg"
                                           style="width:100%;margin-top:10px;text-align:center;">
                                            <i class="fal fa-arrow-left"></i> Modifier ma recherche
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Col droite end -->
                    </div>
                </div>
            </section>

            <div class="limit-box fl-wrap"></div>
        </div>
        <!-- content end -->

        @include('partials.newsletter')
        @include('partials.footer')
    </div>
    <!-- wrapper end -->

    @include('partials/register_login')

    <!--secondary-nav -->
    <div class="secondary-nav">
        <ul>
            <li><a href="dashboard-add-listing.html" class="tolt"
                   data-microtip-position="left" data-tooltip="Sell Property">
                    <i class="fal fa-truck-couch"></i>
                </a></li>
            <li><a href="listing.html" class="tolt"
                   data-microtip-position="left" data-tooltip="Buy Property">
                    <i class="fal fa-shopping-bag"></i>
                </a></li>
            <li><a href="compare.html" class="tolt"
                   data-microtip-position="left" data-tooltip="Your Compare">
                    <i class="fal fa-exchange"></i>
                </a></li>
        </ul>
        <div class="progress-indicator">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34">
                <circle cx="16" cy="16" r="15.9155" class="progress-bar__background"/>
                <circle cx="16" cy="16" r="15.9155"
                        class="progress-bar__progress js-progress-bar"/>
            </svg>
        </div>
    </div>
    <!--secondary-nav end -->
    <a class="to-top color-bg"><i class="fas fa-caret-up"></i></a>
</div>
<!-- Main end -->

<!--=============== scripts  ===============-->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/plugins.js')}}"></script>
<script src="{{asset('assets/js/scripts.js')}}"></script>
</body>
</html>
