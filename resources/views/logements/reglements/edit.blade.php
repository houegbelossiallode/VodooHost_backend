@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Modification</span></div>
                <div class="dashbard-menu-header">
                    <div class="dashbard-menu-avatar fl-wrap">
                        <img src="{{ auth()->user()->photo }}" alt="">
                        <h4>Bienvenue, <span>{{ auth()->user()->nom ?? 'Utilisateur' }}</span></h4>
                    </div>
                    <a href="{{ route('hoost.logout') }}" class="log-out-btn tolt" data-microtip-position="bottom"
                        data-tooltip="Déconnexion">
                        <i class="far fa-power-off"></i>
                    </a>
                </div>
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-wrapper fl-wrap no-pag">
                <!-- dasboard-widget-box  end-->
                <!-- dasboard-widget-title -->
                <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec6">
                    <h5>Règlements</h5>

                </div>
                <!-- dasboard-widget-title end -->
                <!-- dasboard-widget-box  -->
                <div class="dasboard-widget-box   fl-wrap">
                    <form method="POST" action="{{ route('hoost.logements.reglements.update', [$logement, $reglement]) }}">
                        @csrf
                        @method('PUT')
                        <div class="custom-form add_room-item-wrap">
                            <div class="add_room-container fl-wrap">
                                <!-- add_room-item   -->
                                <div class="add_room-item fl-wrap ">
                                    <span class="remove-rp tolt" data-microtip-position="left" data-tooltip="Supprimer"><i
                                            class="fal fa-times-circle"></i></span>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Libelle:</label>
                                            <input type="text" name="libelle" placeholder="Règlement" required
                                                value="{{ old('libelle', $reglement->libelle) }}"
                                                style="text-align:left;padding-left:15px;" />
                                        </div>
                                    </div>
                                </div>
                                <!--add_room-item end  -->
                            </div>
                            {{-- <a href="#" class="add-room-item">Ajouter<i class="fal fa-plus"></i> </a> --}}
                            <div class="mt-3">
                                <button type="submit" class="btn color-bg float-btn">Enregistrer</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="limit-box fl-wrap"></div>

    </div>
    <!-- content end -->
    <div class="dashbard-bg gray-bg"></div>
@endsection
