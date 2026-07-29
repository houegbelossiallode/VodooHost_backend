@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>MON PROFILE</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <!-- dasboard-wrapper-->
            <div class="dasboard-wrapper fl-wrap no-pag">
                <div class="row">
                    <div class="col-md-7">
                        <div class="dasboard-widget-title fl-wrap">
                            <h5><i class="fas fa-user-circle"></i>Changez vôtre photo de profile</h5>
                        </div>
                        <form id="profile-photo" action="{{ route('hoost.profile.update-photo') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="dasboard-widget-box nopad-dash-widget-box fl-wrap">
                                <div class="edit-profile-photo">
                                    <img src="{{ auth()->user()->photo }}" class="respimg" alt="">
                                    <div class="change-photo-btn">
                                        <div class="photoUpload">
                                            <span>Téléchargez une nouvelle photo</span>
                                            <input type="file" name="photo" class="upload">
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-wrap bg-parallax-wrap-gradien">
                                    <div class="bg" data-bg="images/bg/1.jpg"></div>
                                </div>
                                {{-- <div class="change-photo-btn cpb-2  ">
                                            <div class="photoUpload color-bg">
                                                <span> <i class="far fa-camera"></i> Change Cover </span>
                                                <input type="file" name="photo" class="upload">
                                            </div>
                                        </div> --}}
                            </div>
                        </form>

                        @php
                            $user = auth()->user();

                            // Valeurs par défaut si vide
                            $userLangues = old('langue', $user->langue ?? []);
                            $userPassions = old('passions', $user->passions ?? []);

                            if (empty($userLangues)) {
                                $userLangues = ['Français'];
                            }
                        @endphp

                        <div class="dasboard-widget-title fl-wrap">
                            <h5><i class="fas fa-key"></i>Informations personnelles</h5>
                        </div>
                        <div class="dasboard-widget-box fl-wrap">
                            <div class="custom-form">
                                <form action="{{ route('hoost.profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    {{-- Nom --}}
                                    <label>Nom <span class="dec-icon"><i class="far fa-user"></i></span></label>
                                    <input type="text" name="nom" placeholder="Votre nom"
                                        value="{{ old('nom', $user->nom) }}" />

                                    {{-- Prénom --}}
                                    <label>Prénom <span class="dec-icon"><i class="fas fa-user"></i></span></label>
                                    <input type="text" name="prenom" placeholder="Votre prénom"
                                        value="{{ old('prenom', $user->prenom) }}" />

                                    {{-- Email --}}
                                    {{-- <label>Email <span class="dec-icon"><i class="far fa-envelope"></i></span></label>
                                    <input type="email" name="email" placeholder="Votre email"
                                        value="{{ old('email', $user->email) }}" /> --}}

                                    {{-- Téléphone --}}
                                    <label>Téléphone<span class="dec-icon"><i class="far fa-phone"></i> </span></label>
                                    <input type="text" name="telephone" placeholder="Votre téléphone"
                                        value="{{ old('telephone', $user->telephone) }}" />

                                    {{-- Profession --}}
                                    <label>Profession <span class="dec-icon"><i class="far fa-briefcase"></i>
                                        </span></label>
                                    <input type="text" name="profession" placeholder="Votre profession"
                                        value="{{ old('profession', $user->profession) }}" />

                                    <div class="listsearch-input-item">
                                        <label>Choisir les langues parlées</label>
                                        <select name="langues[]" class="chosen-select on-radius" multiple>
                                            @php $langues = collect($user->langue ?? []); @endphp

                                            <option value="fr" @selected($langues->contains('fr'))>Français</option>
                                            <option value="fon" @selected($langues->contains('fon'))>Fon</option>
                                            <option value="dendi" @selected($langues->contains('dendi'))>Dendi</option>
                                            <option value="yoruba" @selected($langues->contains('yoruba'))>Yoruba</option>
                                            <option value="de" @selected($langues->contains('de'))>Allemand</option>
                                            <option value="mina" @selected($langues->contains('mina'))>Mina</option>
                                            <option value="en" @selected($langues->contains('en'))>Anglais</option>
                                        </select>

                                    </div>

                                    {{-- <div class="listsearch-input-item">
                                        <label>Choisir la devise</label>
                                        <select name="preferred_currency" class="chosen-select on-radius">
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
                                        </select>
                                    </div> --}}

                                    {{-- Bio --}}
                                    <p>Bio </p>
                                    <textarea name="bio" cols="40" rows="3" placeholder="Parlez un peu de vous">{{ old('bio', $user->bio) }}
                                    </textarea>
                                    <button class="btn color-bg float-btn">Enregistrer les modifications</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="dasboard-widget-title dbt-mm fl-wrap">
                            <h5><i class="fas fa-key"></i>Sécurité</h5>
                        </div>
                        <form action="{{ route('hoost.user.security.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="dasboard-widget-box fl-wrap">
                                <div class="custom-form">
                                    <div class="pass-input-wrap fl-wrap">
                                        <label>Mot de passe actuel<span class="dec-icon"><i
                                                    class="far fa-lock-open-alt"></i></span></label>
                                        <input type="password" name="current_password" class="pass-input" placeholder=""
                                            value="" />
                                        <span class="eye"><i class="far fa-eye" aria-hidden="true"></i> </span>
                                    </div>
                                    <div class="pass-input-wrap fl-wrap">
                                        <label>Nouveau mot de passe<span class="dec-icon"><i
                                                    class="far fa-lock-alt"></i></span></label>
                                        <input type="password" name="password" class="pass-input" placeholder=""
                                            value="" />
                                        <span class="eye"><i class="far fa-eye" aria-hidden="true"></i> </span>
                                    </div>
                                    <div class="pass-input-wrap fl-wrap">
                                        <label>Confirmez nouveau mot de passe<span class="dec-icon"><i
                                                    class="far fa-shield-check"></i> </span></label>
                                        <input type="password" name="password_confirmation" class="pass-input"
                                            placeholder="" value="" />
                                        <span class="eye"><i class="far fa-eye" aria-hidden="true"></i> </span>
                                    </div>
                                    <button class="btn    color-bg  float-btn">Enregistrer</button>
                                </div>
                        </form>
                    </div>


                    <!-- dasboard-widget-title -->
                    <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec7">
                        <h5><i class="fas fa-bell"></i>Paramètres de Notifications</h5>
                    </div>
                    <div class="dasboard-widget-box fl-wrap">
                        <div class="custom-form">
                            <form method="POST" action="{{ route('hoost.notifications.update') }}">
                                @csrf
                                <div class="row">
                                    <!-- Notification par Email -->
                                    <div class="col-md-12" style="margin-bottom: 20px">
                                        <div class="content-widget-switcher fl-wrap">
                                            <span class="content-widget-switcher-title">

                                                Notification par Email
                                            </span>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="email" class="onoffswitch-checkbox"
                                                    id="notif_email" value="1"
                                                    {{ $preferences?->email ? 'checked' : '' }}>
                                                <label class="onoffswitch-label" for="notif_email">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notification par SMS -->
                                    <div class="col-md-12" style="margin-bottom: 20px">
                                        <div class="content-widget-switcher fl-wrap">
                                            <span class="content-widget-switcher-title">
                                                Notification par SMS
                                            </span>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="sms" class="onoffswitch-checkbox"
                                                    id="notif_sms" value="1"
                                                    {{ $preferences?->sms ? 'checked' : '' }}>
                                                <label class="onoffswitch-label" for="notif_sms">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Notification dans l'application -->
                                    <div class="col-md-12" style="margin-bottom: 20px">
                                        <div class="content-widget-switcher fl-wrap">
                                            <span class="content-widget-switcher-title">

                                                Notification dans l'application
                                            </span>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="in_app" class="onoffswitch-checkbox"
                                                    id="notif_in_app" value="1"
                                                    {{ $preferences?->in_app ? 'checked' : '' }}>
                                                <label class="onoffswitch-label" for="notif_in_app">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Réservation confirmée -->
                                    <div class="col-md-12" style="margin-top: -5px">
                                        <div class="content-widget-switcher fl-wrap">
                                            <span class="content-widget-switcher-title">

                                                Réservation confirmée
                                            </span>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="reservation_confirmee"
                                                    class="onoffswitch-checkbox" id="notif_resa_ok" value="1"
                                                    {{ $preferences?->reservation_confirmee ? 'checked' : '' }}>
                                                <label class="onoffswitch-label" for="notif_resa_ok">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Annulation de réservation -->
                                    <div class="col-md-12" style="margin-top: 20px">
                                        <div class="content-widget-switcher fl-wrap">
                                            <span class="content-widget-switcher-title">

                                                Annulation de réservation
                                            </span>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="annulation_reservation"
                                                    class="onoffswitch-checkbox" id="notif_resa_cancel" value="1"
                                                    {{ $preferences?->annulation_reservation ? 'checked' : '' }}>
                                                <label class="onoffswitch-label" for="notif_resa_cancel">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nouveau message -->
                                    <div class="col-md-12" style="margin-top: 20px">
                                        <div class="content-widget-switcher fl-wrap">
                                            <span class="content-widget-switcher-title">

                                                Nouveau message reçu
                                            </span>
                                            <div class="onoffswitch">
                                                <input type="checkbox" name="nouveau_message"
                                                    class="onoffswitch-checkbox" id="notif_msg" value="1"
                                                    {{ $preferences?->nouveau_message ? 'checked' : '' }}>
                                                <label class="onoffswitch-label" for="notif_msg">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn color-bg float-btn">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <!-- dasboard-wrapper end -->
    </div>
    <!-- dashboard-footer -->
    <div class="dashboard-footer">
        {{-- <div class="dashboard-footer-links fl-wrap">
                            <span>Helpfull Links:</span>
                            <ul>
                                <li><a href="about.html">About  </a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="pricing.html">Pricing Plans</a></li>
                                <li><a href="contacts.html">Contacts</a></li>
                                <li><a href="help.html">Help Center</a></li>
                            </ul>
                        </div> --}}
        <a href="#main" class="dashbord-totop  custom-scroll-link"><i class="fas fa-caret-up"></i></a>
    </div>
    <!-- dashboard-footer end -->
    </div>
    <!-- content end -->
    <div class="dashbard-bg gray-bg"></div>
    </div>





    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fonction pour ajouter un nouveau champ
            function addNewField(containerId, placeholder, required = false) {
                const container = document.getElementById(containerId);
                const newField = document.createElement('div');
                newField.className = 'input-group mb-2';
                newField.innerHTML = `
            <input type="text"
                   class="form-control"
                   name="${containerId === 'langues-container' ? 'langue' : 'passions'}[]"
                   placeholder="${placeholder}"
                   ${required ? 'required' : ''}>
            <button type="button" class="btn btn-danger remove-${containerId === 'langues-container' ? 'langue' : 'passion'}">
                <i class="fa fa-times"></i>
            </button>
        `;
                container.appendChild(newField);
            }

            // Gestion des clics sur les boutons d'ajout
            document.getElementById('add-langue')?.addEventListener('click', function() {
                addNewField('langues-container', 'Ex: Anglais', false);
            });

            document.getElementById('add-passion')?.addEventListener('click', function() {
                addNewField('passions-container', 'Ex: Photographie', false);
            });

            // Délégation d'événements pour la suppression
            document.addEventListener('click', function(e) {
                // Suppression d'une langue
                if (e.target.closest('.remove-langue')) {
                    const container = document.getElementById('langues-container');
                    if (container.children.length > 1) {
                        e.target.closest('.input-group').remove();
                    }
                }
                // Suppression d'une passion
                else if (e.target.closest('.remove-passion')) {
                    e.target.closest('.input-group').remove();
                }
            });
        });
    </script>

    <script>
        window.profileUpdatePhotoUrl = "{{ route('hoost.profile.update-photo') }}";
        window.csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('photo.js') }}"></script>
@endsection
