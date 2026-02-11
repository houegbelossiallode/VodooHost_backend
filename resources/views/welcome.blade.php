@extends('layouts.app')
@section('section')
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg">
        <span><i class="fas fa-bars"></i></span>Dashboard Menu
    </div>

    <div class="container dasboard-container">

        <!-- dashboard-title -->
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item"><span>Administration - Statistiques</span></div>
            <div class="dashbard-menu-header">
                <div class="dashbard-menu-avatar fl-wrap">
                    <img src="{{ asset('images/avatar/1.jpg') }}" alt="">
                    <h4>Bienvenue, <span>{{ Auth::user()->nom}}</span></h4>
                </div>
                <a href="{{ route('hoost.logout') }}" class="log-out-btn tolt" data-microtip-position="bottom" data-tooltip="Déconnexion">
                    <i class="far fa-power-off"></i>
                </a>
            </div>
        </div>
        <!-- dashboard-title end -->

        <div class="dasboard-wrapper fl-wrap no-pag">

            <!-- STATISTIQUES -->
            <div class="dashboard-stats-container fl-wrap">
                <div class="row">

                    <!-- Revenus plateforme -->
                    <div class="col-md-3">
                        <div class="dashboard-stats fl-wrap">
                            <i class="fal fa-chart-line"></i>
                            <h4>Revenus Plateforme</h4>
                            <div class="dashboard-stats-count">{{ number_format($revenuPlateforme, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>

                    <!-- Contributions sociales -->
                    <div class="col-md-3">
                        <div class="dashboard-stats fl-wrap">
                            <i class="fal fa-hand-holding-heart"></i>
                            <h4>Contributions Sociales</h4>
                            <div class="dashboard-stats-count">{{ number_format($contributionsTotal, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>

                    <!-- Revenus hôtes -->
                    <div class="col-md-3">
                        <div class="dashboard-stats fl-wrap">
                            <i class="fal fa-wallet"></i>
                            <h4>Reversés aux Hôtes</h4>
                            <div class="dashboard-stats-count">{{ number_format($revenuHotes, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>

                    <!-- Réservations -->
                    <div class="col-md-3">
                        <div class="dashboard-stats fl-wrap">
                            <i class="fal fa-calendar-check"></i>
                            <h4>Réservations</h4>
                            <div class="dashboard-stats-count">{{ $reservationsCount }}</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="clearfix"></div>

            <!-- GRAPH -->
            <div class="row mt-4">
                <div class="col-md-8">
                    <div class="dashboard-widget-title fl-wrap">Revenus mensuels</div>
                    <div class="dasboard-content fl-wrap">

                        <div class="chart-wrap fl-wrap">
                            <canvas id="canvas-chart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="box-widget fl-wrap">
                        <div class="banner-widget fl-wrap">
                            <div class="bg-wrap bg-parallax-wrap-gradien">
                                <div class="bg" data-bg="{{ asset('images/all/blog/1.jpg') }}"></div>
                            </div>
                            <div class="banner-widget_content">
                                <h5>Statistiques globales de la plateforme.</h5>
                                <a href="#" class="btn float-btn color-bg small-btn">Voir Plus</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- dashboard-footer -->
    <div class="dashboard-footer">
        <div class="dashboard-footer-links fl-wrap">
            <span>Liens utiles :</span>
            <ul>
                <li><a href="#">A propos</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Tarifs</a></li>
                <li><a href="#">Contacts</a></li>
                <li><a href="#">Centre d'aide</a></li>
            </ul>
        </div>
        <a href="#main" class="dashbord-totop custom-scroll-link"><i class="fas fa-caret-up"></i></a>
    </div>

</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('canvas-chart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: "Revenus mensuels",
                data: @json($revenusMensuels),
                borderWidth: 3,
                tension: 0.4
            }]
        }
    });
</script>

@endsection