{{-- <div class="main-register-wrap modal">
    <div class="reg-overlay"></div>
    <div class="main-register-holder tabs-act">
        <div class="main-register-wrapper modal_main fl-wrap">
            <div class="main-register-header color-bg"></div>

            <div class="main-register">
                <h3 style="text-align:center">Mot de passe oublié ?</h3>
                <p style="text-align:center">Entrez votre email pour recevoir le lien.</p>

                <div class="custom-form">
                    <form method="POST" action="{{ route('hoost.password.forgot.submit') }}">
                        @csrf

                        <label>Email *</label>
                        <input name="email" type="email" required>

                        <button class="log_btn color-bg" style="margin-top:15px;">
                            Envoyer le lien
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}




{{-- <div class="auth-reset-wrapper">
    <div class="auth-reset-card">
        <div class="auth-reset-header">
            <div class="auth-reset-icon">
                <i class="fas fa-lock"></i>
            </div>
            <h1>Réinitialisation du mot de passe</h1>
            <p>Renseignez votre adresse email et nous vous enverrons un lien sécurisé.</p>
        </div>

        @if (session('status'))
            <div class="alert-reset success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('hoost.password.forgot.submit') }}" class="auth-reset-form">
            @csrf

            <div class="form-group-reset">
                <label for="email">Adresse Email <span class="required">*</span></label>
                <div class="input-with-icon-reset @error('email') has-error @enderror">
                    <i class="fas fa-envelope"></i>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        autofocus
                        placeholder="exemple@domaine.com"
                    >
                </div>
                @error('email')
                    <span class="error-text-reset">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-reset-primary">
                <span>Envoyer le lien de réinitialisation</span>
                <i class="fas fa-paper-plane"></i>
            </button>

            <div class="auth-reset-footer">
                <a href="{{ route('hoost.login') }}" class="back-link-reset">
                    <i class="fas fa-arrow-left me-1"></i>
                    Retour à la connexion
                </a>
            </div>
        </form>
    </div>
</div>

<style>
   /* Fond premium */
.auth-reset-wrapper {
    min-height: 100vh;
    padding: 40px 15px;
    display: flex;
    align-items: center;
    justify-content: center;
   /* background: linear-gradient(135deg, #0E0E0E, #1A1A1A);*/
}

/* Carte */
.auth-reset-card {
    width: 100%;
    max-width: 520px;
    padding: 32px;
    border-radius: 20px;
   /* background: #151515; */
    border: 1px solid rgba(209, 177, 27, 0.15);
   /* box-shadow: 0 20px 35px rgba(0,0,0,0.55); */
    color: #FAFAFA;
}

/* Header */
.auth-reset-header {
    text-align: center;
    margin-bottom: 26px;
}

.auth-reset-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 16px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #D1B11B;
    color: #0E0E0E;
    box-shadow: 0 10px 30px rgba(209, 177, 27, 0.45);
}

.auth-reset-header h1 {
    font-size: 1.45rem;
    font-weight: 700;
    color: #FAFAFA;
}

.auth-reset-header p {
    color: #D9D9D9;
    font-size: 0.92rem;
}

/* Alert */
.alert-reset.success {
    background: rgba(209, 177, 27, 0.12);
    border-left: 3px solid #D1B11B;
    color: #E6D68A;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 15px;
}

/* Form */
.form-group-reset label {
    display: block;
    margin-bottom: 6px;
    font-size: 0.9rem;
    font-weight: 500;
    color: #FAFAFA;
}

.required { color: #E53E3E; }

.input-with-icon-reset {
    position: relative;
}

.input-with-icon-reset i {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #D9D9D9;
}

.input-with-icon-reset input {
    width: 100%;
    height: 48px;
    border-radius: 10px;
    border: 1px solid #3A3A3A;
   /* background: #0E0E0E; */
    padding-left: 42px;
    font-size: 0.95rem;
    color: #FAFAFA;
    transition: all .2s ease;
}

.input-with-icon-reset input::placeholder {
    color: #7D7D7D;
}

.input-with-icon-reset input:focus {
    border-color: #D1B11B;
    box-shadow: 0 0 0 1px #D1B11B;
}

/* Errors */
.input-with-icon-reset.has-error input {
    border-color: #E53E3E;
}

.error-text-reset {
    font-size: .8rem;
    color: #FFC1C1;
    margin-top: 5px;
}

/* Bouton principal */
.btn-reset-primary {
    width: 100%;
    margin-top: 12px;
    padding: 12px 20px;
    border-radius: 10px;
    background: #D1B11B;
    border: none;
    font-size: 0.95rem;
    font-weight: 600;
    color: #0E0E0E;
    cursor: pointer;
    text-transform: uppercase;
    transition: all .2s ease;
}

.btn-reset-primary:hover {
    background: #A88C14;
}

/* Footer */
.auth-reset-footer {
    margin-top: 18px;
    text-align: center;
}

.back-link-reset {
    font-size: 0.9rem;
    color: #D1B11B;
    text-decoration: none;
    transition: color .2s ease;
}

.back-link-reset:hover {
    color: #A88C14;
}
</style> --}}


<div class="reset-container">
    <div class="reset-card">
        <h2 class="reset-title">Réinitialisation du mot de passe</h2>
        <p class="reset-subtext">Entrez votre adresse email pour recevoir le lien de réinitialisation.</p>

        @if (session('success'))
            <div class="reset-alert success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="reset-alert error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('hoost.password.forgot.submit') }}">
            @csrf

            <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <div class="input-with-icon @error('email') has-error @enderror">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="exemple@domaine.com" value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-reset">
                Envoyer le lien
            </button>

            <div class="reset-footer">
                <a href="{{ route('hoost.login') }}">Retour à la connexion</a>
            </div>
        </form>
    </div>
</div>

<style>
    .reset-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        background: #F4F4F4; /* léger gris propre */
    }

    .reset-card {
        width: 100%;
        max-width: 460px;
        background: #FFFFFF;
        border-radius: 12px;
        padding: 32px;
        border: 1px solid #E5E5E5;
        box-shadow: 0px 8px 22px rgba(0,0,0,0.06);
    }

    .reset-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .reset-subtext {
        font-size: 0.9rem;
        color: #6A6A6A;
        margin-bottom: 22px;
    }

    .reset-alert {
        font-size: 0.9rem;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 18px;
    }

    .reset-alert.success {
        background: rgba(209,177,27,0.12);
        border-left: 3px solid #D1B11B;
        color: #6F5D0D;
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

    .required {
        color: #E53935;
    }

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
        transition: border-color 0.2s;
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

    .btn-reset {
        width: 100%;
        border: none;
        padding: 12px;
        margin-top: 8px;
        background: #D1B11B;
        color: #FFFFFF;
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-reset:hover {
        background: #B89815;
    }

    .reset-footer {
        text-align: center;
        margin-top: 14px;
    }

    .reset-footer a {
        font-size: 0.9rem;
        color: #B89815;
        text-decoration: none;
    }

    .reset-footer a:hover {
        text-decoration: underline;
    }
</style>
