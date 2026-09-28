<div class="main-register-wrap modal">
    <style>
        .oauth-profile-overlay[hidden],
        .oauth-profile-error[hidden] {
            display: none !important;
        }

        .auth-google-button {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 18px;
            border: 1px solid #d9d9d9;
            border-radius: 8px;
            color: #333;
            text-decoration: none;
        }

        .auth-google-button img {
            width: 18px;
            height: 18px;
        }

        .oauth-profile-overlay {
            position: fixed;
            inset: 0;
            z-index: 10001;
            display: grid;
            place-items: center;
            padding: 20px;
            background: rgba(20, 28, 35, 0.56);
        }

        .oauth-profile-dialog {
            width: min(100%, 440px);
            padding: 30px;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 20px 60px rgba(20, 28, 35, 0.24);
        }

        .oauth-profile-dialog h2 {
            margin: 0 0 8px;
            color: #262b2f;
            font-size: 1.35rem;
        }

        .oauth-profile-intro {
            margin: 0;
            color: #68727a;
            line-height: 1.5;
        }

        .oauth-profile-options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin: 22px 0 8px;
        }

        .oauth-role-card {
            display: flex;
            min-width: 0;
            min-height: 154px;
            flex-direction: column;
            align-items: flex-start;
            padding: 16px;
            border: 1px solid #e0e4e6;
            border-radius: 10px;
            background: #fff;
            color: #262b2f;
            text-align: left;
            cursor: pointer;
            transition: border-color 150ms ease, background-color 150ms ease, transform 150ms ease;
        }

        .oauth-role-card:hover,
        .oauth-role-card:focus-visible {
            transform: translateY(-2px);
            border-color: #b89716;
            background: #fffdf6;
            outline: none;
        }

        .oauth-role-icon {
            display: grid;
            width: 40px;
            height: 40px;
            place-items: center;
            margin-bottom: 14px;
            border-radius: 10px;
            background: #e8f2ef;
            color: #176b55;
            font-size: 18px;
        }

        .oauth-role-card[data-partial-google-role="host"] .oauth-role-icon {
            background: #fbf2d5;
            color: #91710b;
        }

        .oauth-role-name {
            font-size: 1rem;
            font-weight: 700;
        }

        .oauth-role-description {
            margin-top: 5px;
            color: #68727a;
            font-size: 0.82rem;
            line-height: 1.4;
        }

        .oauth-role-card:disabled {
            cursor: wait;
            opacity: 0.58;
            transform: none;
        }

        .oauth-profile-cancel {
            min-height: 44px;
            padding: 8px 12px;
            border: 0;
            background: transparent;
            color: #68727a;
            font: inherit;
            cursor: pointer;
        }

        .oauth-profile-cancel:hover {
            color: #262b2f;
            text-decoration: underline;
        }

        .oauth-profile-error {
            color: #b42318;
        }

        @media (max-width: 480px) {
            .oauth-profile-dialog { padding: 22px; }
            .oauth-profile-options { grid-template-columns: 1fr; }
            .oauth-role-card { min-height: 116px; }
        }

        .auth-google-error {
            color: #b42318;
            text-align: center;
        }

        #main-register-form2 #signup-role-id {
            float: left;
            width: 100%;
            margin-bottom: 20px;
            padding: 15px 42px 15px 70px;
            border: 1px solid #e5e7f2;
            border-radius: 4px;
            background-color: #f5f7fb;
            color: #7d93b2;
            font-size: 12px;
            font-weight: 400;
            outline: none;
        }

        #main-register-form2 #signup-role-id:focus {
            border-color: #e5e7f2;
            background-color: #fff;
            box-shadow: 0 10px 14px rgba(12, 0, 46, 0.06);
        }
    </style>
    @php
        $signupRoles = \App\Models\Role::query()
            ->where('actif', 'OUI')
            ->whereRaw('LOWER(TRIM(libelle)) NOT IN (?, ?)', ['admin', 'administrateur'])
            ->orderBy('libelle')
            ->get(['id', 'libelle']);
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
                                <div class="log-separator fl-wrap"><span>ou</span></div>
                                <a id="partial-google-login" class="auth-google-button" href="{{ route('hoost.supabase.redirect', ['provider' => 'google']) }}">
                                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="" aria-hidden="true">
                                    Continuer avec Google
                                </a>
                                <p id="partial-google-error" class="auth-google-error" role="alert" hidden></p>
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

                                        <label for="signup-role-id">Rôle * <span class="dec-icon"><i class="fal fa-user-tag"></i></span></label>
                                        <select id="signup-role-id" name="role_id" required>
                                            <option value="">Choisissez votre rôle</option>
                                            @forelse ($signupRoles as $signupRole)
                                                <option value="{{ $signupRole->id }}" {{ (string) old('role_id') === (string) $signupRole->id ? 'selected' : '' }}>
                                                    {{ $signupRole->libelle }}
                                                </option>
                                            @empty
                                                <option value="" disabled>Aucun rôle disponible</option>
                                            @endforelse
                                        </select>
                                        @error('role_id')
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



<div id="partial-oauth-profile" class="oauth-profile-overlay" hidden>
    <section class="oauth-profile-dialog" role="dialog" aria-modal="true" aria-labelledby="partial-oauth-title">
        <h2 id="partial-oauth-title">Choisissez votre profil</h2>
        <p class="oauth-profile-intro">Votre compte Google est reconnu, mais aucun profil Vodoo Host n'y est encore associé.</p>
        <div class="oauth-profile-options">
            <button type="button" class="oauth-role-card" data-partial-google-role="visitor" aria-label="Choisir le profil Visiteur">
                <span class="oauth-role-icon" aria-hidden="true"><i class="fas fa-compass"></i></span>
                <span class="oauth-role-name">Visiteur</span>
                <span class="oauth-role-description">Trouver un logement et préparer votre séjour.</span>
            </button>
            <button type="button" class="oauth-role-card" data-partial-google-role="host" aria-label="Choisir le profil Hôte">
                <span class="oauth-role-icon" aria-hidden="true"><i class="fas fa-home"></i></span>
                <span class="oauth-role-name">Hôte</span>
                <span class="oauth-role-description">Proposer votre logement aux voyageurs.</span>
            </button>
            <button type="button" class="oauth-role-card" data-partial-google-role="photographer" aria-label="Choisir le profil Photographe">
                <span class="oauth-role-icon" aria-hidden="true"><i class="fas fa-camera"></i></span>
                <span class="oauth-role-name">Photographe</span>
                <span class="oauth-role-description">Partager vos services photo avec les hôtes.</span>
            </button>
            <button type="button" class="oauth-role-card" data-partial-google-role="manager" aria-label="Choisir le profil Manager">
                <span class="oauth-role-icon" aria-hidden="true"><i class="fas fa-user-cog"></i></span>
                <span class="oauth-role-name">Manager</span>
                <span class="oauth-role-description">Gérer les activités et le suivi de la plateforme.</span>
            </button>
        </div>
        <p id="partial-oauth-error" class="oauth-profile-error" role="alert" hidden></p>
        <button type="button" class="oauth-profile-cancel" id="partial-oauth-cancel">Annuler</button>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const googleButton = document.getElementById('partial-google-login');
        const googleError = document.getElementById('partial-google-error');
        const profileModal = document.getElementById('partial-oauth-profile');
        const profileError = document.getElementById('partial-oauth-error');
        const roleButtons = [...document.querySelectorAll('[data-partial-google-role]')];
        const cancelButton = document.getElementById('partial-oauth-cancel');
        let authPopup = null;

        googleButton.addEventListener('click', (event) => {
            event.preventDefault();
            googleError.hidden = true;
            authPopup = window.open(
                googleButton.href,
                'vodoo-google-auth',
                'popup=yes,width=500,height=650,resizable=yes,scrollbars=yes'
            );
            if (!authPopup) {
                googleError.textContent = 'Autorisez les fenêtres pop-up pour continuer avec Google.';
                googleError.hidden = false;
                return;
            }
            authPopup.focus();
        });

        window.addEventListener('message', (event) => {
            if (event.origin !== window.location.origin || event.source !== authPopup) return;
            if (event.data?.type === 'google-profile-required') {
                sessionStorage.setItem('google_oauth_access_token', event.data.access_token);
                sessionStorage.setItem('google_oauth_refresh_token', event.data.refresh_token || '');
                profileModal.hidden = false;
                roleButtons[0]?.focus();
            } else if (event.data?.type === 'google-auth-success') {
                window.location.replace(event.data.redirect || '/hoost/home');
            } else if (event.data?.type === 'google-auth-error') {
                googleError.textContent = event.data.message || 'La connexion Google a échoué.';
                googleError.hidden = false;
            }
            if (authPopup && !authPopup.closed) authPopup.close();
            authPopup = null;
        });

        roleButtons.forEach((button) => {
            button.addEventListener('click', async () => {
                const accessToken = sessionStorage.getItem('google_oauth_access_token');
                const refreshToken = sessionStorage.getItem('google_oauth_refresh_token');
                if (!accessToken) return;
                roleButtons.forEach((item) => item.disabled = true);
                cancelButton.disabled = true;
                profileError.hidden = true;
                try {
                    const response = await fetch("{{ route('hoost.supabase.handle') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            access_token: accessToken,
                            refresh_token: refreshToken,
                            role_slug: button.dataset.partialGoogleRole,
                        }),
                    });
                    const data = await response.json();
                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'La création du profil a échoué.');
                    }
                    sessionStorage.removeItem('google_oauth_access_token');
                    sessionStorage.removeItem('google_oauth_refresh_token');
                    window.location.replace(data.redirect || '/hoost/home');
                } catch (error) {
                    profileError.textContent = error.message;
                    profileError.hidden = false;
                    roleButtons.forEach((item) => item.disabled = false);
                    cancelButton.disabled = false;
                }
            });
        });

        cancelButton.addEventListener('click', async () => {
            cancelButton.disabled = true;
            try {
                const client = window.supabase.createClient(
                    '{{ config('services.supabase.url') }}',
                    '{{ config('services.supabase.anon_key') }}'
                );
                await client.auth.signOut();
            } catch (error) {
                console.error('Erreur lors de la déconnexion Supabase:', error);
            } finally {
                sessionStorage.removeItem('google_oauth_access_token');
                sessionStorage.removeItem('google_oauth_refresh_token');
                profileModal.hidden = true;
            }
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
