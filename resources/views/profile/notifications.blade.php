@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">

            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Notifications</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-wrapper fl-wrap no-pag">
                <div class="dasboard-widget-title fl-wrap" id="sec1">
                    <h5><i class="fas fa-bell"></i>Paramètres de Notifications</h5>
                </div>

                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form">
                        <form method="POST" action="{{ route('hoost.notifications.update') }}">
                            @csrf
                            <div class="row">
                                <!-- Notification par Email -->
                                <div class="col-md-4">
                                    <div class="content-widget-switcher fl-wrap">
                                        <span class="content-widget-switcher-title">

                                            Notification par Email
                                        </span>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="email" class="onoffswitch-checkbox"
                                                id="notif_email" value="1" {{ $preferences->email ? 'checked' : '' }}>
                                            <label class="onoffswitch-label" for="notif_email">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification par SMS -->
                                <div class="col-md-4">
                                    <div class="content-widget-switcher fl-wrap">
                                        <span class="content-widget-switcher-title">

                                            Notification par SMS
                                        </span>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="sms" class="onoffswitch-checkbox"
                                                id="notif_sms" value="1" {{ $preferences->sms ? 'checked' : '' }}>
                                            <label class="onoffswitch-label" for="notif_sms">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notification dans l'application -->
                                <div class="col-md-4">
                                    <div class="content-widget-switcher fl-wrap">
                                        <span class="content-widget-switcher-title">

                                            Notification dans l'application
                                        </span>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="in_app" class="onoffswitch-checkbox"
                                                id="notif_in_app" value="1"
                                                {{ $preferences->in_app ? 'checked' : '' }}>
                                            <label class="onoffswitch-label" for="notif_in_app">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Réservation confirmée -->
                                <div class="col-md-4" style="margin-top: 20px">
                                    <div class="content-widget-switcher fl-wrap">
                                        <span class="content-widget-switcher-title">

                                            Réservation confirmée
                                        </span>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="reservation_confirmee" class="onoffswitch-checkbox"
                                                id="notif_resa_ok" value="1"
                                                {{ $preferences->reservation_confirmee ? 'checked' : '' }}>
                                            <label class="onoffswitch-label" for="notif_resa_ok">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Annulation de réservation -->
                                <div class="col-md-4" style="margin-top: 20px">
                                    <div class="content-widget-switcher fl-wrap">
                                        <span class="content-widget-switcher-title">

                                            Annulation de réservation
                                        </span>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="annulation_reservation"
                                                class="onoffswitch-checkbox" id="notif_resa_cancel" value="1"
                                                {{ $preferences->annulation_reservation ? 'checked' : '' }}>
                                            <label class="onoffswitch-label" for="notif_resa_cancel">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nouveau message -->
                                <div class="col-md-4" style="margin-top: 20px">
                                    <div class="content-widget-switcher fl-wrap">
                                        <span class="content-widget-switcher-title">
                                            
                                            Nouveau message reçu
                                        </span>
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="nouveau_message" class="onoffswitch-checkbox"
                                                id="notif_msg" value="1"
                                                {{ $preferences->nouveau_message ? 'checked' : '' }}>
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
@endsection
