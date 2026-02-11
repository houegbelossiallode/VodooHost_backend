{{-- 
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Réinitialisation du mot de passe</div>

                <div class="card-body">
                    
                    <form method="POST" action="{{ route('hoost.password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token ?? $request->token }}">
                        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Adresse Email</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Nouveau mot de passe</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmer le mot de passe</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Réinitialiser le mot de passe
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 --}}



<div class="reset-container">
    <div class="reset-card">
        <h2 class="reset-title">Réinitialisation du mot de passe</h2>
        {{-- <p class="reset-subtext">Veuillez saisir votre nouveau mot de passe.</p> --}}

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

        <form method="POST" action="{{ route('hoost.password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token ?? $request->token }}">
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

            {{-- <div class="form-group">
                <label>Email <span class="required">*</span></label>
                <div class="input-with-icon @error('email') has-error @enderror">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="exemple@domaine.com" value="{{ old('email') }}" required autofocus>
                </div>
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div> --}}

            <div class="form-group">
                <label>Nouveau mot de passe <span class="required">*</span></label>
                <div class="input-with-icon @error('password') has-error @enderror">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Confirmer le mot de passe <span class="required">*</span></label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_confirmation" required placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="btn-reset">
                Mettre à jour le mot de passe
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
        background: #F4F4F4;
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
        margin-bottom: 10px;
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
