{{-- <!DOCTYPE HTML>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>


<style>
  .main-register-wrap{
    display:block !important;
    opacity:1 !important;
    visibility:visible !important;
    transform:none !important;
    position:relative !important;
    left:auto !important;
    top:auto !important;
    z-index:1 !important;
  }
  .reg-overlay{display:none!important;} 
</style>




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
            <div class="content">
                <div class="container">
                    <div class="main-register-wrap" >
                        <div ></div>
                        <div class="main-register-holder tabs-act">
                            <div class="main-register-wrapper  fl-wrap">
                                <div class="main-register-header color-bg">
                                    <div class="main-register-logo fl-wrap">
                                        <img src="{{ asset('assets/images/voodoo/logo.png') }}" alt="">
                                    </div>
                                    <div class="main-register-bg">
                                        <div class="mrb_pin"></div>
                                        <div class="mrb_pin mrb_pin2"></div>
                                    </div>
                                    <div class="mrb_dec"></div>
                                    <div class="mrb_dec mrb_dec2"></div>
                                </div>

                                <div class="main-register">
                                    <h3 class="mb-3" style="text-align:center;">Se connecter</h3>

                                    <div class="custom-form">
                                        <form method="POST" action="{{ route('hoost.login') }}">
                                            @csrf

                                            
                                            <label>Email* <span class="dec-icon">
                                                <i class="fal fa-user"></i></span>
                                            </label>
                                            <input name="email" type="email" placeholder="Votre email"
                                                value="{{ old('email') }}" required>
                                            @error('email')
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror

                                            
                                            <div class="pass-input-wrap fl-wrap">
                                                <label>Mot de passe* <span class="dec-icon">
                                                        <i class="fal fa-key"></i></span>
                                                </label>
                                                <input name="password" type="password" placeholder="Votre mot de passe"
                                                    autocomplete="off" required>
                                                <span class="eye"><i class="fal fa-eye"></i></span>
                                            </div>
                                            @error('password')
                                                <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror

                                            <div class="lost_password">
                                                <a href="{{ route('hoost.password.forgot.form') }}">
                                                    Vous avez oublié votre mot de passe ?
                                                </a>
                                            </div>

                                            <div class="clearfix"></div>
                                            <button type="submit" class="log_btn color-bg">
                                                Connexion
                                            </button>
                                        </form>
                                    </div>

                                    <div class="log-separator fl-wrap"><span>ou</span></div>

                                    
                                    <div class="soc-log fl-wrap">
                                        <p>Pour aller plus vite, utilisez votre compte social.</p>

                                        <a href="{{ route('hoost.supabase.redirect', ['provider' => 'facebook']) }}"
                                            class="facebook-log">
                                            <i class="fab fa-facebook-f"></i> Continuer avec Facebook
                                        </a>

                                        <a href="{{ route('hoost.supabase.redirect', ['provider' => 'google']) }}"
                                            class="google-log"
                                            style="background:#fff;color:#444;border:1px solid #ddd;">
                                            <img src="https://developers.google.com/identity/images/g-logo.png"
                                                alt="Google"
                                                style="width:18px;margin-right:8px;vertical-align:middle;">
                                            Continuer avec Google
                                        </a>
                                    </div>

                                    <div class="mt-3" style="text-align:center;">
                                        <span>Pas encore de compte ?</span>
                                        <a href="{{ route('hoost.register') }}" class="color-bg"
                                            style="padding:2px 6px;border-radius:4px;color:#fff;">
                                            S'inscrire
                                        </a>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @include('partials.footer')

        </div>
        <!-- wrapper end -->
        <!--register form -->
        @include('partials/register_login')
        <!--register form end -->
        <!--secondary-nav -->
        <div class="secondary-nav">
            <ul>
                <li><a href="dashboard-add-listing.html" class="tolt" data-microtip-position="left"
                        data-tooltip="Sell Property"><i class="fal fa-truck-couch"></i> </a></li>
                <li><a href="listing.html" class="tolt" data-microtip-position="left" data-tooltip="Buy Property">
                        <i class="fal fa-shopping-bag"></i></a></li>
                <li><a href="compare.html" class="tolt" data-microtip-position="left"
                        data-tooltip="Your Compare"><i class="fal fa-exchange"></i></a></li>
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
    </div>
    <!-- Main end -->

    <!--contact-form-wrap end-->
    <!--=============== scripts  ===============-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    
    <script src="{{ asset('assets/js/map-single.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        
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

        @if (session('success'))
            showToast('success', '{{ session('success') }}');
        @endif

        @if (session('error'))
            showToast('error', '{{ session('error') }}');
        @endif

        @if (session('warning'))
            showToast('warning', '{{ session('warning') }}');
        @endif

        @if (session('info'))
            showToast('info', '{{ session('info') }}');
        @endif
    </script>

</body>

</html> --}}



<div class="auth-container">
    <div class="auth-card">
        {{-- Si tu as un logo, tu peux le mettre ici --}}
        {{-- <div class="auth-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        </div> --}}

        <h2 class="auth-title">Connexion</h2>
        <p class="auth-subtext">Connectez-vous pour accéder à votre espace.</p>

        @if (session('success'))
            <div class="auth-alert success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('error'))
            <div class="auth-alert error">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('hoost.login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email">Adresse email <span class="required">*</span></label>
                <div class="input-with-icon @error('email') has-error @enderror">
                    <i class="fas fa-envelope"></i>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="exemple@domaine.com"
                        required
                        autofocus
                    >
                </div>
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Mot de passe --}}
            <div class="form-group">
                <label for="password">Mot de passe <span class="required">*</span></label>
                <div class="input-with-icon @error('password') has-error @enderror">
                    <i class="fas fa-lock"></i>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                    >
                </div>
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            {{-- Se souvenir de moi + Mot de passe oublié --}}
            <div class="auth-row">
                <label class="remember-me">
                    {{-- <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Se souvenir de moi</span> --}}
                </label>

                <a href="{{ route('hoost.password.forgot.form') }}" class="link-small">
                    Mot de passe oublié ?
                </a>
            </div>

            <button type="submit" class="btn-auth">
                Se connecter
            </button>

            {{-- <div class="auth-footer">
                <span>Pas encore de compte ?</span>
                <a href="{{ route('hoost.register') }}">Créer un compte</a>
            </div> --}}
        </form>
        <div class="auth-social-separator"><span>ou</span></div>
        <a id="google-login-button" href="{{ route('hoost.supabase.redirect', ['provider' => 'google']) }}" class="btn-google-auth">
            <img src="https://developers.google.com/identity/images/g-logo.png" alt="" aria-hidden="true">
            Continuer avec Google
        </a>
        <p class="google-login-error" id="google-login-error" role="alert" hidden></p>
    </div>
</div>

<div class="google-profile-overlay" id="google-profile-modal" hidden>
    <section class="google-profile-dialog" role="dialog" aria-modal="true" aria-labelledby="google-profile-title">
        <h2 id="google-profile-title">Choisissez votre profil</h2>
        <p class="google-profile-intro">Votre compte Google est reconnu, mais aucun profil Vodoo Host n’y est encore associé.</p>
        <div class="google-profile-options">
            <button type="button" class="google-role-card" data-google-role="visitor" aria-label="Choisir le profil Visiteur">
                <span class="google-role-icon" aria-hidden="true"><i class="fas fa-compass"></i></span>
                <span class="google-role-name">Visiteur</span>
                <span class="google-role-description">Trouver un logement et préparer votre séjour.</span>
            </button>
            <button type="button" class="google-role-card" data-google-role="host" aria-label="Choisir le profil Hôte">
                <span class="google-role-icon" aria-hidden="true"><i class="fas fa-home"></i></span>
                <span class="google-role-name">Hôte</span>
                <span class="google-role-description">Proposer votre logement aux voyageurs.</span>
            </button>
            <button type="button" class="google-role-card" data-google-role="photographer" aria-label="Choisir le profil Photographe">
                <span class="google-role-icon" aria-hidden="true"><i class="fas fa-camera"></i></span>
                <span class="google-role-name">Photographe</span>
                <span class="google-role-description">Partager vos services photo avec les hôtes.</span>
            </button>
            <button type="button" class="google-role-card" data-google-role="manager" aria-label="Choisir le profil Manager">
                <span class="google-role-icon" aria-hidden="true"><i class="fas fa-user-cog"></i></span>
                <span class="google-role-name">Manager</span>
                <span class="google-role-description">Gérer les activités et le suivi de la plateforme.</span>
            </button>
        </div>
        <p class="google-profile-error" id="google-profile-error" role="alert" hidden></p>
        <button type="button" class="google-profile-cancel" id="google-profile-cancel">Annuler</button>
    </section>
</div>

<style>
    .auth-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background: #F4F4F4;
    }

    .auth-card {
        width: 100%;
        max-width: 460px;
        background: #FFFFFF;
        border-radius: 12px;
        padding: 32px;
        border: 1px solid #E5E5E5;
        box-shadow: 0px 8px 22px rgba(0,0,0,0.06);
    }

    .auth-logo {
        text-align: center;
        margin-bottom: 16px;
    }

    .auth-logo img {
        height: 48px;
    }

    .auth-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .auth-subtext {
        font-size: 0.9rem;
        color: #6A6A6A;
        margin-bottom: 22px;
    }

    .auth-alert {
        font-size: 0.9rem;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .auth-alert.success {
        background: rgba(209,177,27,0.12);
        border-left: 3px solid #D1B11B;
        color: #6F5D0D;
    }

    .auth-alert.error {
        background: rgba(229,57,53,0.08);
        border-left: 3px solid #E53935;
        color: #B71C1C;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 0.88rem;
        font-weight: 520;
        margin-bottom: 5px;
    }

    .required { color: #E53935; }

    .input-with-icon {
        position: relative;
    }

    .input-with-icon i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.85rem;
        color: #888;
    }

    .input-with-icon input {
        width: 100%;
        height: 46px;
        border: 1px solid #D9D9D9;
        border-radius: 8px;
        padding-left: 36px;
        font-size: 0.92rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .input-with-icon input:focus {
        border-color: #D1B11B;
        outline: none;
        box-shadow: 0 0 0 2px rgba(209,177,27,0.18);
    }

    .has-error input {
        border-color: #E53935 !important;
    }

    .error-msg {
        display: block;
        font-size: 0.8rem;
        margin-top: 5px;
        color: #E53935;
    }

    .auth-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .remember-me {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: #555;
        cursor: pointer;
    }

    .remember-me input {
        accent-color: #D1B11B;
    }

    .link-small {
        font-size: 0.85rem;
        color: #B89815;
        text-decoration: none;
    }

    .link-small:hover {
        text-decoration: underline;
    }

    .btn-auth {
        width: 100%;
        border: none;
        padding: 12px;
        margin-top: 4px;
        background: #D1B11B;
        color: #FFFFFF;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-auth:hover {
        background: #B89815;
    }

    .auth-footer {
        text-align: center;
        margin-top: 16px;
        font-size: 0.9rem;
        color: #666;
    }

        .auth-social-separator {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: #777;
            font-size: 0.88rem;
        }

        .auth-social-separator::before,
        .auth-social-separator::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e5e5;
        }

        .btn-google-auth {
            min-height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 1px solid #d9d9d9;
            border-radius: 8px;
            color: #333;
            font-size: 0.92rem;
            text-decoration: none;
        }

        .btn-google-auth:hover {
            background: #f8f8f8;
        }

        .btn-google-auth img {
            width: 18px;
            height: 18px;
        }

        .google-profile-overlay {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: grid;
            place-items: center;
            padding: 20px;
            background: rgba(20, 28, 35, 0.56);
        }

        .google-profile-overlay[hidden],
        .google-profile-error[hidden] {
            display: none;
        }

        .google-profile-dialog {
            width: min(100%, 440px);
            padding: 30px;
            border: 1px solid #e5e5e5;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 20px 60px rgba(20, 28, 35, 0.24);
        }

        .google-profile-dialog h2 {
            margin: 0 0 8px;
            color: #262b2f;
            font-size: 1.35rem;
        }

        .google-profile-intro {
            margin: 0;
            color: #68727a;
            line-height: 1.5;
        }

        .google-profile-options {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin: 22px 0 8px;
        }

        .google-role-card {
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

        .google-role-card:hover,
        .google-role-card:focus-visible {
            transform: translateY(-2px);
            border-color: #b89716;
            background: #fffdf6;
            outline: none;
        }

        .google-role-icon {
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

        .google-role-card[data-google-role="host"] .google-role-icon {
            background: #fbf2d5;
            color: #91710b;
        }

        .google-role-name {
            font-size: 1rem;
            font-weight: 700;
        }

        .google-role-description {
            margin-top: 5px;
            color: #68727a;
            font-size: 0.82rem;
            line-height: 1.4;
        }

        .google-role-card:disabled {
            cursor: wait;
            opacity: 0.58;
            transform: none;
        }

        .google-profile-cancel {
            min-height: 44px;
            padding: 8px 12px;
            border: 0;
            background: transparent;
            color: #68727a;
            font: inherit;
            cursor: pointer;
        }

        .google-profile-cancel:hover {
            color: #262b2f;
            text-decoration: underline;
        }

        .google-profile-cancel:disabled {
            cursor: wait;
            opacity: 0.6;
        }

        .google-profile-error {
            margin: 12px 0 0;
            color: #b42318 !important;
            font-size: 0.9rem;
        }

        @media (max-width: 480px) {
            .google-profile-dialog { padding: 22px; }
            .google-profile-options { grid-template-columns: 1fr; }
            .google-role-card { min-height: 116px; }
        }

        .google-login-error {
            margin: 10px 0 0;
            color: #b42318;
            font-size: 0.88rem;
        }

        .google-login-error[hidden] {
            display: none;
        }

    .auth-footer a {
        color: #B89815;
        text-decoration: none;
        margin-left: 4px;
        font-weight: 500;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    @media (max-width: 480px) {
        .auth-card {
            padding: 24px;
        }
    }
</style>

    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const googleButton = document.getElementById('google-login-button');
            const googleError = document.getElementById('google-login-error');
            const modal = document.getElementById('google-profile-modal');
            const roleButtons = [...document.querySelectorAll('[data-google-role]')];
            const cancelButton = document.getElementById('google-profile-cancel');
            const errorMessage = document.getElementById('google-profile-error');
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
                    modal.hidden = false;
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

            const params = new URLSearchParams(window.location.search);
            if (params.get('google_profile') === 'complete') {
                const accessToken = sessionStorage.getItem('google_oauth_access_token');
                if (accessToken) modal.hidden = false;
                window.history.replaceState({}, '', window.location.pathname);
            }

            roleButtons.forEach((button) => {
                button.addEventListener('click', async () => {
                    const accessToken = sessionStorage.getItem('google_oauth_access_token');
                    const refreshToken = sessionStorage.getItem('google_oauth_refresh_token');
                    if (!accessToken) return;

                    roleButtons.forEach((item) => item.disabled = true);
                    cancelButton.disabled = true;
                    errorMessage.hidden = true;

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
                                role_slug: button.dataset.googleRole,
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
                        errorMessage.textContent = error.message;
                        errorMessage.hidden = false;
                        roleButtons.forEach((item) => item.disabled = false);
                        cancelButton.disabled = false;
                    }
                });
            });

            cancelButton.addEventListener('click', async () => {
                cancelButton.disabled = true;
                try {
                    const supabaseUrl = '{{ config('services.supabase.url') }}';
                    const supabaseAnonKey = '{{ config('services.supabase.anon_key') }}';
                    const supabaseClient = window.supabase.createClient(supabaseUrl, supabaseAnonKey);
                    await supabaseClient.auth.signOut();
                } catch (error) {
                    console.error('Erreur lors de la déconnexion Supabase:', error);
                } finally {
                    sessionStorage.removeItem('google_oauth_access_token');
                    sessionStorage.removeItem('google_oauth_refresh_token');
                    window.location.replace('/login');
                }
            });
        });
    </script>
