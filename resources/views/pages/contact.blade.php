
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <!--=============== basic  ===============-->
        <meta charset="UTF-8">
        <title>Voodoo hoost</title>
        <meta name="robots" content="index, follow"/>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <!--=============== css  ===============-->	
        <link type="text/css" rel="stylesheet" href="{{asset('assets/css/plugins.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        <link type="text/css" rel="stylesheet" href="{{asset('assets/css/color.css')}}">
        <!--=============== favicons ===============-->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    </head>
    <body>
        <!--loader-->
        <div class="loader-wrap">
            <div class="loader-inner">
                <svg>
                    <defs>
                        <filter id="goo">
                            <fegaussianblur in="SourceGraphic" stdDeviation="2" result="blur" />
                            <fecolormatrix in="blur"   values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 5 -2" result="gooey" />
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
                    <section class="hidden-section single-par2  " data-scrollax-parent="true">
                        <div class="bg-wrap bg-parallax-wrap-gradien">
                            <div class="bg par-elem "  data-bg="{{asset('assets/images/voodoo/ban4.png')}}" data-scrollax="properties: { translateY: '30%' }"></div>
                        </div>
                        <div class="container">
                            <div class="section-title center-align big-title">
                                <h2><span>Nos Contacts</span></h2>
                                <h4>
                                    Pour toute demande d’information ou d’assistance, n’hésitez pas à nous écrire. 
                                    Notre équipe se tient à votre disposition pour vous accompagner.
                                </h4>
                            </div>
                            {{-- <div class="scroll-down-wrap">
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
                                <a href="#">Home</a> <a href="#">Pages</a><span>Contacts</span>
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
                            <div class="row">
                                <!-- services-item -->
                                <div class="col-md-4">
                                    <div class="services-item fl-wrap">
                                        <i class="fal fa-envelope"></i>
                                        <h4>Notre e-mail</h4>
                                        <p>Support réservations et hôtes, 7j/7 pendant la période du festival.</p>
                                        <a href="mailto:contact@vodoohost.com" class="serv-link sl-b">contact@vodoohost.com</a>
                                    </div>
                                </div>
                                <!-- services-item  end-->
                                <!-- services-item -->
                                <div class="col-md-4">
                                    <div class="services-item fl-wrap">
                                        <i class="fal fa-phone-rotary"></i>
                                        <h4>Nos téléphones</h4>
                                        <p>Assistance en français / fon. Horaires élargis durant la fête du Vodoun.</p>
                                        <a href="tel:+22997000000" class="serv-link sl-b">+229 97 00 00 00</a>
                                        {{-- <div class="mt-2">
                                        <a href="https://wa.me/22991713761" class="serv-link">WhatsApp direct</a>
                                      </div> --}}
                                    </div>
                                </div>
                                <!-- services-item  end-->
                                <!-- services-item -->
                                <div class="col-md-4">
                                    <div class="services-item fl-wrap">
                                        <i class="fal fa-map-marked"></i>
                                        <h4>Notre adresse</h4>
                                        <p>Point d’accueil et d’orientation pendant le festival à Ouidah.</p>
                                        <a href="https://maps.google.com/?q=Ouidah,B%C3%A9nin" target="_blank" class="serv-link sl-b">
                                        Ouidah, Bénin
                                      </a>
                                    </div>
                                </div>
                                <!-- services-item  end-->								
                            </div>
                            <div class="clearfix"></div>
                            <div class="contacts-opt fl-wrap">
                                {{-- <div class="contact-social">
                                    <span class="cs-title">Suivez-nous : </span>
                                    <ul>
                                        <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                        <li><a href="#" target="_blank"><i class="fab fa-vk"></i></a></li>
                                    </ul>
                                </div> --}}
                                <a href="#" class="btn small-btn float-btn color-bg cf_btn">Écrire un message</a></a>
                                {{-- <div class="contact-notifer">Or visit our <a href="help.html">  help page</a></div> --}}
                            </div>
                            <!--box-widget  -->			
                            <div class="box-widget">
                                <div class="box-widget-title single_bwt fl-wrap">Localisation</div>
                                <p> <strong>Vodoo Host</strong> accompagne voyageurs et hôtes pour des séjours chez l’habitant lors
                                de la <em>Fête du Vodoun</em> à Ouidah. Retrouvez ici notre point d’accueil et les zones
                                principales d’hébergement afin de faciliter votre arrivée.
                                </p>
                                <!--box-widget end-->
                            </div>
                            <!--box-widget-->
                            {{-- <div class="box-widget fl-wrap">
                                <div class="map-widget contacts-map fl-wrap">
                                    <div
                                      id="singleMap"
                                      data-latitude="6.36"
                                      data-longitude="2.09"
                                      data-infotitle="Vodoo Host – Ouidah"
                                      data-infotext="Point d’accueil — Ouidah, Bénin"
                                    ></div>
                                    <div class="scrollContorl"></div>
                                </div>
                            </div> --}}
                            <!--box-widget end --> 									
                        </div>
                    </section>
                    <!-- section end-->	
                </div>
                <!-- content end -->	
                <!-- subscribe-wrap -->	
                <div class="subscribe-wrap fl-wrap">
                    <div class="container">
                        <div class="subscribe-container fl-wrap color-bg">
                            <div class="pwh_bg"></div>
                            <div class="mrb_dec mrb_dec3"></div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="subscribe-header">
                                        <h4>Newsletter Vodoo Host</h4>
                                        <h3>Recevez les dernières nouvelles sur la Fête du Vodoun et les hébergements disponibles à Ouidah</h3>
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-5">
                                    <div class="footer-widget fl-wrap">
                                        <div class="subscribe-widget fl-wrap">
                                            <div class="subcribe-form">
                                                <form id="subscribe">
                                                    <input class="enteremail fl-wrap" name="email" id="subscribe-email" placeholder="Entrez votre adresse e-mail" spellcheck="false" type="text">
                                                    <button type="submit" id="subscribe-button" class="subscribe-button color-bg">S'abonner</button>
                                                    <label for="subscribe-email" class="subscribe-message"></label>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    <li><a href="dashboard-add-listing.html" class="tolt" data-microtip-position="left"  data-tooltip="Sell Property"><i class="fal fa-truck-couch"></i> </a></li>
                    <li><a href="listing.html" class="tolt" data-microtip-position="left"  data-tooltip="Buy Property"> <i class="fal fa-shopping-bag"></i></a></li>
                    <li><a href="compare.html" class="tolt" data-microtip-position="left"  data-tooltip="Your Compare"><i class="fal fa-exchange"></i></a></li>
                </ul>
                <div class="progress-indicator">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="-1 -1 34 34">
                        <circle cx="16" cy="16" r="15.9155"
                            class="progress-bar__background" />
                        <circle cx="16" cy="16" r="15.9155"
                            class="progress-bar__progress 
                            js-progress-bar" />
                    </svg>
                </div>
            </div>
            <!--secondary-nav end -->			
            <a class="to-top color-bg"><i class="fas fa-caret-up"></i></a>   
        </div>
        <!-- Main end -->
        <!--contact-form-wrap -->	
        <div class="contact-form-wrap">
            <div class="contact-form-container">
                <div class="contact-form-main fl-wrap">
                    <div class="contact-form-header">
                        <h4>Contactez-nous</h4>
                        <span class="close-contact-form"><i class="fal fa-times"></i></span>
                    </div>
                    <div id="contact-form" class="contact-form fl-wrap">
                        <div id="message"></div>
                        <form  class="custom-form" action="{{ route('hoost.contacts.store') }}" method="POST" name="contactform" id="contactform">
                        @csrf
                           <fieldset>
                                <label>Vôtre nom* <span class="dec-icon"><i class="fas fa-user"></i></span></label>
                                <input type="text" name="nom" id="name" placeholder="Vôtre nom*" value="{{old('nom')}}"/>
                                <label>Vôtre prenom* <span class="dec-icon"><i class="fas fa-user"></i></span></label>
                                <input type="text" name="prenom" id="name" placeholder="Vôtre prenom*" value="{{old('prenom')}}"/>
                                <label>Vôtre email* <span class="dec-icon"><i class="fas fa-envelope"></i></span></label>
                                <input type="text"  name="email" id="email" placeholder="Adresse email*" value="{{old('email')}}"/>
                                <textarea name="message"  id="comments" cols="40" rows="3" placeholder="Vôtre message"></textarea>
                            </fieldset>
                            <button class="btn float-btn color-bg" style="margin-top:15px;" id="submitBtn">Envoyer</button>
                        </form>
                    </div>
                    <!-- contact form  end--> 					
                </div>
            </div>
            <div class="contact-form-overlay"></div>
        </div>
        <!--contact-form-wrap end-->	
        <!--=============== scripts  ===============-->
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/plugins.js')}}"></script>
        <script src="{{asset('assets/js/scripts.js')}}"></script>
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOU_API_KEY_HERE&libraries=places"></script> --}}
        <script src="{{asset('assets/js/map-single.js')}}"></script>
        <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Script pour afficher les notifications -->
    <script>
        // Fonction pour afficher une notification toast
        function showToast(icon, title, text = '') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: icon,
                title: title,
                text: text
            });
        }

        // Afficher les messages de session s'ils existent
        @if(session('success'))
            showToast('success', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showToast('error', '{{ session('error') }}');
        @endif

        @if(session('warning'))
            showToast('warning', '{{ session('warning') }}');
        @endif

        @if(session('info'))
            showToast('info', '{{ session('info') }}');
        @endif
    </script>
   

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const btn = document.querySelector('#submitBtn');
    btn.addEventListener('click', function (e) {
        e.preventDefault();

        let form = document.querySelector('#contactform');
        let formData = new FormData(form);

        fetch("{{ route('hoost.contacts.store') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                "Accept": "application/json"
            },
            body: formData
        })
        .then(async response => {
            let data = await response.json();

            // ❌ Si erreur Laravel (validation ou 500)
            if (!response.ok) {
                throw data;
            }

            return data;
        })
        .then(data => {
            // ✅ Affichage succès
            Swal.fire({
                icon: 'success',
                title: 'Message envoyé !',
                text: data.message,
                confirmButtonColor: '#3085d6',
                timer: 2500
            });

            form.reset();
        })
        .catch(error => {

            // erreur validation Laravel
            if (error.errors) {
                let messages = Object.values(error.errors)
                    .flat()
                    .join("<br>");

                Swal.fire({
                    icon: 'error',
                    title: 'Erreur de validation',
                    html: messages,
                    confirmButtonColor: '#d33',
                });

                return;
            }

            // Erreur serveur générique
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: error.message ?? "Une erreur s'est produite.",
                confirmButtonColor: '#d33',
            });
        });
    });

});
</script>


</body>
</html>