<div class="main-register-wrap modal">
    <style>
        /* container général */
        .role-toggle {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 15px 0;
        }

        /* On cache les radios visuellement */
        .role-toggle input[type="radio"] {
            display: none;
        }

        /* Style des labels (boutons) */
        .role-toggle label {
            padding: 10px 25px;
            background: #f5f5f5;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            border: 2px solid transparent;
            transition: 0.25s;
            user-select: none;
            font-size: 15px;
        }

        /* Au survol */
        .role-toggle label:hover {
            background: #ececec;
        }

        /* Quand c’est sélectionné */
        .role-toggle input[type="radio"]:checked+label {
            background: #D1B11B;
            /* couleur Airbnb */
            color: white;
            border-color: #D1B11B;
            box-shadow: 0 4px 10px rgba(255, 90, 95, 0.4);
            transform: translateY(-1px);
        }
    </style>
    @php

        use App\Models\Role;

        // Exemple : ne garder que les rôles utiles
        $roles = Role::whereIn('libelle', ['Visiteur', 'Hote'])->get();
    @endphp
    <div class="reg-overlay"></div>
    <div class="main-register-holder tabs-act">
        <div class="main-register-wrapper modal_main fl-wrap">
            <div class="main-register-header color-bg">
                <div class="main-register-logo fl-wrap">
                    {{-- <img src="{{ asset('assets/images/voodoo/popo.png') }}" alt=""> --}}
                </div>
                <div class="main-register-bg">
                    <div class="mrb_pin"></div>
                    <div class="mrb_pin mrb_pin2"></div>
                </div>
                <div class="mrb_dec"></div>
                <div class="mrb_dec mrb_dec2"></div>
            </div>
            <div class="main-register">
                <div class="close-reg"><i class="fal fa-times"></i></div>
                <ul class="tabs-menu fl-wrap no-list-style">
                    <li class="current"><a href="#tab-1"><i class="fal fa-sign-in-alt"></i>Se connecter</a></li>
                    <li><a href="#tab-2"><i class="fal fa-user-plus"></i>S'inscrire</a></li>
                </ul>
                <!--tabs -->
                <div class="tabs-container">
                    <div class="tab">
                        <!--tab -->
                        <div id="tab-1" class="tab-content first-tab">
                            <div class="custom-form">
                                <form method="POST" action="{{ route('hoost.login') }}">
                                    @csrf
                                    <label>Email* <span class="dec-icon"><i class="fal fa-user"></i></span></label>
                                    <input name="email" type="email" placeholder="Vôtre email"
                                        onClick="this.select()" value="" required>
                                    <div class="pass-input-wrap fl-wrap">
                                        <label>Mot de passe* <span class="dec-icon"><i
                                                    class="fal fa-key"></i></span></label>
                                        <input name="password" placeholder="Vôtre mot de passe" type="password"
                                            autocomplete="off" onClick="this.select()" value="" required>
                                        <span class="eye"><i class="fal fa-eye"></i> </span>
                                    </div>
                                    <div class="lost_password">
                                        <a href="{{ route('hoost.password.forgot.form') }}">Vous avez oubliez vôtre mot
                                            de passe
                                            ?</a>
                                    </div>

                                    <div class="clearfix"></div>
                                    <button type="submit" class="log_btn color-bg"> Connexion </button>
                                </form>
                            </div>
                        </div>
                        <!--tab end -->
                        <!--tab -->
                        <div class="tab">
                            <div id="tab-2" class="tab-content">
                                <div class="custom-form">
                                    <form method="post" action="{{ route('hoost.register') }}" name="registerform"
                                        class="main-register-form" id="main-register-form2">
                                        @csrf
                                        {{-- Nom --}}
                                        <label>Nom * <span class="dec-icon"><i class="fal fa-user"></i></span></label>
                                        <input name="nom" type="text" placeholder="Votre nom"
                                            value="{{ old('nom') }}"
                                            class="{{ $errors->has('nom') ? 'is-invalid' : '' }}" required>
                                        @error('nom')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror

                                        {{-- Prénom --}}
                                        <label>Prénom * <span class="dec-icon"><i
                                                    class="fal fa-user"></i></span></label>
                                        <input name="prenom" type="text" placeholder="Votre prénom"
                                            value="{{ old('prenom') }}"
                                            class="{{ $errors->has('prenom') ? 'is-invalid' : '' }}" required>
                                        @error('prenom')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror

                                        {{-- Téléphone --}}
                                        <label>Téléphone * <span class="dec-icon"><i
                                                    class="fal fa-phone"></i></span></label>
                                        <input name="telephone" type="number" placeholder="Votre téléphone"
                                            value="{{ old('telephone') }}"
                                            class="{{ $errors->has('telephone') ? 'is-invalid' : '' }}" required>
                                        @error('telephone')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror

                                        {{-- Profession --}}
                                        <label>Profession * <span class="dec-icon"><i
                                                    class="fal fa-user"></i></span></label>
                                        <input name="profession" type="text" placeholder="Votre profession"
                                            value="{{ old('profession') }}"
                                            class="{{ $errors->has('profession') ? 'is-invalid' : '' }}" required>
                                        @error('profession')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror

                                        {{-- Email --}}
                                        <label>Email * <span class="dec-icon"><i
                                                    class="fal fa-envelope"></i></span></label>
                                        <input name="email" type="email" placeholder="Votre email"
                                            value="{{ old('email') }}"
                                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required>
                                        @error('email')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror


                                        <div class="pass-input-wrap fl-wrap">
                                            <label>Mot de passe * <span class="dec-icon"><i
                                                        class="fal fa-key"></i></span></label>
                                            <input name="password" placeholder="Vôtre mot de passe" type="password"
                                                autocomplete="off" onClick="this.select()" value="" required>
                                            <span class="eye"><i class="fal fa-eye"></i> </span>
                                        </div>


                                        <div class="pass-input-wrap fl-wrap">
                                            <label>Confirmer mot de passe * <span class="dec-icon"><i
                                                        class="fal fa-key"></i></span></label>
                                            <input name="password_confirmation"
                                                placeholder="Confirmer vôtre mot de passe" type="password"
                                                autocomplete="off" onClick="this.select()" value="" required>
                                            <span class="eye"><i class="fal fa-eye"></i> </span>
                                        </div>


                                        <p style="text-align:center;">Je m'inscrire en tant que *</p>
                                        <div class="role-toggle">
                                            <input type="radio" id="role-host" name="slug" value="host"
                                                checked required>
                                            <label for="role-host">Hôte</label>

                                            <input type="radio" id="role-visitor" name="slug" value="visitor"
                                                required>
                                            <label for="role-visitor">Visiteur</label>
                                        </div>


                                        <div class="log-separator fl-wrap"><span>ou</span></div>
                                        <div class="soc-log fl-wrap">
                                            <p>Pour aller plus vite, utilisez votre compte social.</p>
                                            <!-- Facebook -->
                                            {{-- <a href="{{ route('hoost.supabase.redirect', ['provider' => 'facebook']) }}" class="facebook-log">
                                                <i class="fab fa-facebook-f"></i> Continuer avec Facebook
                                            </a>

                                            <a href="{{ route('hoost.supabase.redirect', ['provider' => 'google']) }}" class="google-log"
                                                style="background:#fff;color:#444;border:1px solid #ddd;">
                                                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google"
                                                    style="width:18px;margin-right:8px;vertical-align:middle;">
                                                Continuer avec Google
                                            </a> --}}
                                            <a href="#" class="google-log social-login"
                                                data-base-url="{{ route('hoost.supabase.redirect', ['provider' => 'google']) }}"
                                                style="background:#fff;color:#444;border:1px solid #ddd;">
                                                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google"
                                                    style="width:18px;margin-right:8px;vertical-align:middle;">
                                                Continuer avec Google
                                            </a>

                                            <a href="#" class="facebook-log social-login"
                                                data-base-url="{{ route('hoost.supabase.redirect', ['provider' => 'facebook']) }}">
                                                <i class="fab fa-facebook-f"></i> Continuer avec Facebook
                                            </a>
                                        </div>



                                        <div class="clearfix"></div>
                                        <button type="submit" class="log_btn color-bg"> Inscription </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--tab end -->
                    </div>
                    <!--tabs end -->
                    <!-- Social -->
                    

                </div>
            </div>
        </div>
    </div>
</div>
</div>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        const socialButtons = document.querySelectorAll('.social-login');

        socialButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                // Rôle choisi dans le formulaire (host / visitor)
                const checked = document.querySelector('input[name="slug"]:checked');
                const roleSlug = checked ? checked.value : 'visitor'; // défaut : visitor

                // URL de base fournie dans data-base-url
                const baseUrl = this.getAttribute('data-base-url');

                // On ajoute ?slug=xxx
                const url = baseUrl + (baseUrl.includes('?') ? '&' : '?') +
                    'slug=' + encodeURIComponent(roleSlug);

                window.location.href = url;
            });
        });
    });
</script>





<script>
    (function() {
        const hash = window.location.hash;
        if (!hash || !hash.includes('access_token=')) {
            return;
        }

        const params = new URLSearchParams(hash.substring(1));
        const accessToken = params.get('access_token');
        const refreshToken = params.get('refresh_token');
        const tokenType = params.get('token_type');

        if (!accessToken) {
            return;
        }

        // On nettoie l’URL (on enlève le token de la barre d’adresse)
        window.history.replaceState(null, '', window.location.pathname + window.location.search);

        fetch("{{ route('hoost.supabase.handle') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    access_token: accessToken,
                    refresh_token: refreshToken,
                    token_type: tokenType,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    console.error('Erreur auth Supabase:', data);
                }
            })
            .catch(err => {
                console.error('Erreur réseau auth Supabase:', err);
            });
    })();
</script>
