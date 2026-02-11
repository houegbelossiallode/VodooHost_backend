@extends('layouts.app')

@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dashboard Menu
        </div>
        <div class="container dasboard-container">

       
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Aide & FAQ</span>
                </div>
                @include('partials.hearder2')
            </div>
            <!-- dashboard-title end -->

            <!-- col-list-wrap -->
            
            <section class="gray-bg small-padding ">
                <div class="container">
                    <div class="row">
                        {{-- COLONNE GAUCHE : NAV FAQ + lien signalement --}}
                        <div class="col-md-4">
                            <div class="box-widget fl-wrap fixed-column_menu-init">
                                <div class="box-widget-content fl-wrap">
                                    <div class="box-widget-title fl-wrap">Navigation</div>

                                    <div class="faq-nav scroll-init fl-wrap">
                                        <ul>
                                            <li><a class="act-scrlink" href="#faq1">Paiements</a></li>
                                            <li><a href="#faq2">Réservations</a></li>
                                            <li><a href="#faq3">Annonces</a></li>
                                            <li><a href="#faq4">Compte & Profil</a></li>
                                            <li><a href="#faq5">Support</a></li>
                                        </ul>
                                    </div>

                                    {{-- <div class="search-widget fns fl-wrap">
                                        <form action="#" class="fl-wrap custom-form">
                                            <input name="se" id="faq-search" type="text" class="search"
                                                   placeholder="Rechercher dans l'aide..." value="" />
                                            <button class="search-submit" id="submit_btn">
                                                <i class="far fa-search"></i>
                                            </button>
                                        </form>
                                    </div> --}}

                                    {{-- BOUTON : SIGNALER UN PROBLÈME --}}
                                    <div class="fl-wrap" style="margin-top: 20px;">
                                        <a href="{{ route('hoost.reports.create') }}"
                                           class="btn color-bg small-btn">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            Signaler un problème
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COLONNE DROITE : CONTENU FAQ --}}
                        <div class="col-md-8">
                            <div class="list-single-main-container">
                                <!--   Paiements -->
                                <div class="list-single-main-item fl-wrap" id="faq1">
                                    <div class="list-single-main-item-title big-lsmt fl-wrap">
                                        <h3>Paiements</h3>
                                    </div>

                                    <div class="accordion-lite-container fl-wrap">
                                        <div class="accordion-lite-header fl-wrap">
                                            Combien de temps prend la validation d’un paiement ?
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="accordion-lite_content fl-wrap">
                                            <p>
                                                La plupart des paiements sont confirmés en quelques minutes.
                                                Dans certains cas (vérifications bancaires, 3D Secure, etc.),
                                                cela peut prendre jusqu’à 24h.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="accordion-lite-container fl-wrap">
                                        <div class="accordion-lite-header fl-wrap">
                                            Puis-je payer en plusieurs fois ?
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="accordion-lite_content fl-wrap">
                                            <p>
                                                Pour le moment, le paiement en plusieurs fois n’est pas disponible.
                                                Vous pouvez toutefois utiliser les solutions proposées par votre banque
                                                (crédit, différé, etc.).
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!--   Réservations -->
                                <div class="list-single-main-item fl-wrap" id="faq2">
                                    <div class="list-single-main-item-title big-lsmt fl-wrap">
                                        <h3>Réservations</h3>
                                    </div>

                                    <div class="accordion-lite-container fl-wrap">
                                        <div class="accordion-lite-header fl-wrap">
                                            Comment modifier ou annuler une réservation ?
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="accordion-lite_content fl-wrap">
                                            <p>
                                                Rendez-vous dans votre espace “Mes réservations”, puis sélectionnez
                                                la réservation à modifier ou annuler. Les conditions d’annulation
                                                dépendent de chaque hôte.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="accordion-lite-container fl-wrap">
                                        <div class="accordion-lite-header fl-wrap">
                                            Que faire si l’hôte ne répond pas ?
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="accordion-lite_content fl-wrap">
                                            <p>
                                                Vous pouvez lui envoyer un message depuis la messagerie intégrée.
                                                Si l’hôte reste injoignable, contactez le support depuis cette page
                                                ou utilisez le bouton “Signaler un problème”.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!--   Annonces -->
                                <div class="list-single-main-item fl-wrap" id="faq3">
                                    <div class="list-single-main-item-title big-lsmt fl-wrap">
                                        <h3>Annonces</h3>
                                    </div>

                                    <div class="accordion-lite-container fl-wrap">
                                        <div class="accordion-lite-header fl-wrap">
                                            L’annonce ne correspond pas à la réalité, que faire ?
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="accordion-lite_content fl-wrap">
                                            <p>
                                                Utilisez le bouton “Signaler un problème” en indiquant le lien de
                                                l’annonce et décrivez précisément la situation. Notre équipe vérifiera
                                                et pourra suspendre l’annonce si nécessaire.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!--   Compte & Profil -->
                                <div class="list-single-main-item fl-wrap" id="faq4">
                                    <div class="list-single-main-item-title big-lsmt fl-wrap">
                                        <h3>Compte & Profil</h3>
                                    </div>

                                    <div class="accordion-lite-container fl-wrap">
                                        <div class="accordion-lite-header fl-wrap">
                                            Comment modifier mes informations personnelles ?
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="accordion-lite_content fl-wrap">
                                            <p>
                                                Vous pouvez modifier votre nom, numéro de téléphone ou photo de profil
                                                depuis la section “Mon profil” dans votre tableau de bord.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!--   Support -->
                                <div class="list-single-main-item fl-wrap" id="faq5">
                                    <div class="list-single-main-item-title big-lsmt fl-wrap">
                                        <h3>Support & Signalement</h3>
                                    </div>

                                    <div class="accordion-lite-container fl-wrap">
                                        <div class="accordion-lite-header fl-wrap">
                                            Comment signaler un problème sur une annonce ou une réservation ?
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="accordion-lite_content fl-wrap">
                                            <p>
                                                Cliquez sur le bouton “Signaler un problème” dans le menu de gauche.
                                                Indiquez le lien de l’annonce concernée et décrivez le problème
                                                rencontré. Notre équipe analysera votre demande au plus vite.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="accordion-lite-container fl-wrap">
                                        <div class="accordion-lite-header fl-wrap">
                                            Comment contacter directement l’équipe de support ?
                                            <i class="fas fa-plus"></i>
                                        </div>
                                        <div class="accordion-lite_content fl-wrap">
                                            <p>
                                                Vous pouvez utiliser ce centre d’aide pour nous écrire en signalant
                                                un problème, ou via les coordonnées indiquées dans le pied de page
                                                du site (email, WhatsApp, téléphone selon ce que tu ajoutes).
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="limit-box fl-wrap"></div>
            </section>
            <!-- col-list-wrap end -->
        </div>
    </div>
@endsection
