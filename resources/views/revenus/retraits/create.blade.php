@extends('layouts.app')

@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Tableau de bord
        </div>

        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Demande de retrait</span>
                </div>

                <div class="dashbard-menu-header">
                    <div class="dashbard-menu-avatar fl-wrap">
                        <img src="{{ auth()->user()->photo ?? asset('assets/images/avatar/1.jpg') }}" alt="">
                        <h4>Bonjour, <span>{{ auth()->user()->prenom }}</span></h4>
                    </div>

                    {{-- Bouton vers l’historique des retraits si tu as une route --}}
                    @if (Route::has('retraits.index'))
                        <a href="{{ route('hoost.retraits.index') }}" class="log-out-btn tolt"
                            data-microtip-position="bottom" data-tooltip="Historique des retraits">
                            <i class="far fa-history"></i>
                        </a>
                    @endif
                </div>

                <!-- Tariff Plan style : ici résumé de ton portefeuille -->
                <div class="tfp-det-container">
                    <div class="tfp-btn">
                        <span>Solde disponible : </span>
                        <strong>{{ number_format($solde, 0, ',', ' ') }} FCFA</strong>
                    </div>
                    <div class="tfp-det">
                        <p>
                            Vous pouvez demander un retrait à partir d’un montant minimum de
                            <strong>{{ number_format($minRetrait ?? 1000, 0, ',', ' ') }} FCFA</strong>.
                        </p>
                        @if (!empty($delaiRetrait))
                            <p>Délai de traitement estimé : <strong>{{ $delaiRetrait }}</strong>.</p>
                        @endif
                    </div>
                </div>
                <!-- Tariff Plan style end -->
            </div>
            <!-- dashboard-title end -->

            <div class="dasboard-wrapper fl-wrap no-pag">
                {{-- Navigation scrollable si tu veux étendre la section plus tard --}}
                <div class="dasboard-scrollnav-wrap scroll-init2 fl-wrap">
                    <ul>
                        <li><a href="#sec1" class="act-scrlink">Formulaire</a></li>
                        <li><a href="#sec2">Infos bancaires / Mobile Money</a></li>
                    </ul>
                    <div class="progress-indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-1 -1 34 34">
                            <circle cx="16" cy="16" r="15.9155" class="progress-bar__background" />
                            <circle cx="16" cy="16" r="15.9155"
                                class="progress-bar__progress js-progress-bar" />
                        </svg>
                    </div>
                </div>

                <!-- SECTION 1 : Formulaire de retrait -->
                <div class="dasboard-widget-title fl-wrap" id="sec1">
                    <h5><i class="fas fa-money-check-alt"></i> Formulaire de demande de retrait</h5>
                </div>

                <div class="dasboard-widget-box fl-wrap">
                    <div class="row">
                        <!-- Colonne résumé solde -->
                        <div class="col-md-4">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-wallet"></i>
                                <h4>Solde disponible</h4>
                                <div class="dashboard-stats-count">
                                    {{ number_format($solde, 0, ',', ' ') }} FCFA
                                </div>
                            </div>


                            <div class="dashboard-stats fl-wrap" style="margin-top: 20px;">
                                <i class="fal fa-wallet"></i>
                                <h4>Montant total retiré</h4>
                                <div class="dashboard-stats-count">
                                    {{ number_format($retraits->where('statut', 'valide')->sum('montant'), 0, ',', ' ') }}
                                    FCFA
                                </div>
                            </div>


                        </div>

                        <!-- Colonne formulaire -->
                        <div class="col-md-8">
                            <div class="custom-form">
                                <form action="{{ route('hoost.retraits.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        {{-- Champs Mobile Money --}}
                                        <div class="col-sm-6" id="mobile_money_number_block">
                                            <label>
                                                Numéro Mobile Money
                                                <span class="dec-icon">
                                                    <i class="far fa-phone"></i>
                                                </span>
                                            </label>
                                            <input type="text" name="mobile_money_number"
                                                placeholder="Ex : 229 96 00 00 00" value="{{ old('mobile_money_number') }}">
                                        </div>

                                        <div class="col-sm-6" id="mobile_money_name_block">
                                            <label>
                                                Nom du titulaire Mobile Money
                                                <span class="dec-icon">
                                                    <i class="far fa-user"></i>
                                                </span>
                                            </label>
                                            <input type="text" name="mobile_money_name"
                                                placeholder="Nom sur le compte Mobile Money"
                                                value="{{ old('mobile_money_name') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- Champs Carte bancaire --}}
                                        <div class="col-sm-6" id="card_holder_block">
                                            <label>
                                                Nom du titulaire de la carte
                                                <span class="dec-icon">
                                                    <i class="far fa-user"></i>
                                                </span>
                                            </label>
                                            <input type="text" name="card_holder"
                                                placeholder="Nom du titulaire de la carte"
                                                value="{{ old('card_holder') }}">
                                        </div>

                                        <div class="col-sm-6" id="card_number_block">
                                            <label>
                                                Numéro de la carte bancaire
                                                <span class="dec-icon">
                                                    <i class="far fa-credit-card"></i>
                                                </span>
                                            </label>
                                            <input type="text" name="card_number"
                                                placeholder="Numéro de la carte bancaire" value="{{ old('card_number') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Montant à retirer
                                                <span class="dec-icon">
                                                    <i class="far fa-money-bill-wave"></i>
                                                </span>
                                            </label>
                                            <input type="number" name="montant"
                                                class="@error('montant') is-invalid @enderror"
                                                 
                                                placeholder="Ex : 25 000" value="{{ old('montant') }}" required>
                                        </div>

                                        <div class="col-sm-6">
                                            <label>Mode de retrait</label>
                                            <div class="listsearch-input-item">
                                                <select name="mode" id="modeRetrait"
                                                    class="chosen-select no-search-select" required>
                                                    <option value="mobile_money"
                                                        {{ old('mode') == 'mobile_money' ? 'selected' : '' }}>
                                                        Mobile Money (MTN / Moov)
                                                    </option>
                                                    <option value="card" {{ old('mode') == 'card' ? 'selected' : '' }}>
                                                        Carte bancaire
                                                    </option>
                                                </select>

                                                @error('mode')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn color-bg float-btn mt-3">
                                        <i class="far fa-paper-plane"></i>
                                        Demander un retrait
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2 : Infos générales -->
                <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec2">
                    <h5><i class="fas fa-info-circle"></i> Informations importantes</h5>
                </div>

                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form">
                        <p>
                            ✅ Vérifiez que vos informations Mobile Money ou bancaires sont correctes avant de valider.<br>
                            ✅ Les retraits peuvent être soumis à une vérification manuelle pour des raisons de sécurité.<br>
                            ✅ En cas de problème, contactez notre support via la page <strong>“Aide / Support”</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="limit-box fl-wrap"></div>
    </div>



    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script>
        $(function() {
            var $mode = $('#modeRetrait');

            var $mobileMoneyNumber = $('#mobile_money_number_block');
            var $mobileMoneyName = $('#mobile_money_name_block');
            var $cardHolder = $('#card_holder_block');
            var $cardNumber = $('#card_number_block');

            function updateFields() {
                var mode = ($mode.val() || '').trim();
                console.log('mode =', mode);

                if (mode === 'mobile_money' || mode === '') {
                    // Afficher Mobile Money
                    $mobileMoneyNumber.show();
                    $mobileMoneyName.show();

                    // Cacher Carte
                    $cardHolder.hide();
                    $cardNumber.hide();
                } else {
                    // Afficher Carte
                    $cardHolder.show();
                    $cardNumber.show();

                    // Cacher Mobile Money
                    $mobileMoneyNumber.hide();
                    $mobileMoneyName.hide();
                }
            }

            // Chosen ou pas, le change sur le <select> est toujours déclenché
            $mode.on('change', updateFields);

            // Si tu initialises Chosen manuellement quelque part, genre :
            // $(".chosen-select").chosen();
            // tu peux aussi forcer une mise à jour ensuite :
            // $mode.trigger('change');

            // Premier affichage (en fonction de la valeur actuelle)
            updateFields();
        });
    </script>
@endsection
