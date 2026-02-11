@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>{{ __('messages.dashboard_menu') }}
        </div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>{{ __('messages.dashboard') }}</span></div>
                @include('partials/hearder2')
                <!--Tariff Plan menu-->

            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-wrapper fl-wrap no-pag">
                <div class="dashboard-stats-container fl-wrap">
                    <div class="row">
                        <!--dashboard-stats-->
                        <div class="col-md-3">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-hotel"></i>
                                <h4>{{ trans('messages.accommodations') }}</h4>
                                <div class="dashboard-stats-count">{{ $logements }}</div>
                            </div>
                        </div>
                        <!-- dashboard-stats end -->
                        <!--dashboard-stats-->
                        <div class="col-md-3">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-chart-bar"></i>
                                <h4>Réservations</h4>
                                <div class="dashboard-stats-count">{{ $reservations }}</div>
                            </div>
                        </div>
                        <!-- dashboard-stats end -->
                        <!--dashboard-stats-->
                        <div class="col-md-3">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-user"></i>
                                <h4>{{ trans('messages.users') }}</h4>
                                <div class="dashboard-stats-count">{{ $users }}</div>
                            </div>
                        </div>
                        <!-- dashboard-stats end -->
                        <!--dashboard-stats-->
                        <div class="col-md-3">
                            <div class="dashboard-stats fl-wrap">
                                <i class="fal fa-group"></i>
                                <h4>{{ __('messages.projects') }}</h4>
                                <div class="dashboard-stats-count">{{ $projets }}</div>
                            </div>
                        </div>
                        <!-- dashboard-stats end -->
                    </div>
                </div>


                <div class="dashboard-widget-title fl-wrap">Statistiques</div>
                <div class="dasboard-content fl-wrap">
                    <div class="chart-wrap fl-wrap">
                        <div class="chart-header fl-wrap">
                            <div class="listsearch-input-item">
                                {{-- <select id="periodSelect" class="chosen-select no-search-select">
                                    <option value="month" selected>Mois</option>
                                    <option value="week">Semaine</option>
                                    <option value="year">Année</option>
                                </select> --}}
                            </div>
                            <div id="myChartLegend"></div>
                        </div>

                        <canvas id="canvas-chart"></canvas>
                    </div>
                </div>

            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data du controller
            const labelsMonth = @json($moisLabels);
            const reservationsMonth = @json($reservationsParMois);
            const revenusMonth = @json($revenusParMois);
            const commissionMonth = @json($commissionParMois);
            const partProjetMonth = @json($partProjetParMois);


            // (optionnel) datasets de fallback pour week/year si tu n’as pas encore ces données
            const labelsWeek = labelsMonth; // temporaire
            const reservationsWeek = reservationsMonth;
            const revenusWeek = revenusMonth;

            const labelsYear = labelsMonth; // temporaire
            const reservationsYear = reservationsMonth;
            const revenusYear = revenusMonth;

            const ctx = document.getElementById('canvas-chart');
            const legendContainer = document.getElementById('myChartLegend');

            const config = {
                type: 'line',
                data: {
                    labels: labelsMonth,
                    datasets: [{
                            label: 'Réservations',
                            data: reservationsMonth,
                            tension: 0.35,
                            fill: false,
                            pointRadius: 2,
                            borderWidth: 2,
                            borderColor: '#D1B11B',
                            backgroundColor: '#D1B11B'
                        },
                        {
                            label: 'Revenus clients',
                            data: revenusMonth,
                            tension: 0.35,
                            fill: false,
                            pointRadius: 2,
                            borderWidth: 2,
                            yAxisID: 'y1',
                            borderColor: '#D998D5',
                            backgroundColor: '#D998D5'
                        },
                        {
                            label: 'Commission plateforme',
                            data: commissionMonth,
                            tension: 0.35,
                            fill: false,
                            pointRadius: 2,
                            borderWidth: 2,
                            borderDash: [6, 4],
                            yAxisID: 'y1',
                            borderColor: '#591607',
                            backgroundColor: '#591607'
                        },
                        {
                            label: 'Part projet',
                            data: partProjetMonth,
                            tension: 0.35,
                            fill: false,
                            pointRadius: 2,
                            borderWidth: 2,
                            borderDash: [2, 4],
                            yAxisID: 'y1',
                            borderColor: '#E3C90E',
                            backgroundColor: '#E3C90E'
                        }
                    ]

                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            display: false
                        }, // on utilise #myChartLegend
                        tooltip: {
                            enabled: true
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Réservations'
                            }
                        },
                        y1: {
                            beginAtZero: true,
                            position: 'right',
                            grid: {
                                drawOnChartArea: false
                            },
                            title: {
                                display: true,
                                text: 'Revenus'
                            }
                        }
                    }
                }
            };

            // Fix hauteur canvas
            ctx.parentElement.style.height = '320px';

            const chart = new Chart(ctx, config);

            // Custom Legend
            function renderLegend() {
                if (!legendContainer) return;
                const items = chart.data.datasets.map((ds, i) => {
                    const color = ds.borderColor || '#111827';

                    return `
    <div class="vh-legend-item" data-index="${i}">
      <span class="vh-legend-dot" style="background:${color}"></span>
      <span class="vh-legend-label">${ds.label}</span>
    </div>
  `;
                }).join('');


                legendContainer.innerHTML = `<div class="vh-legend">${items}</div>`;

                legendContainer.querySelectorAll('.vh-legend-item').forEach(el => {
                    el.addEventListener('click', () => {
                        const idx = parseInt(el.dataset.index, 10);
                        const meta = chart.getDatasetMeta(idx);
                        meta.hidden = meta.hidden === null ? !chart.data.datasets[idx].hidden :
                            null;
                        chart.update();
                        el.classList.toggle('is-off');
                    });
                });
            }
            renderLegend();

            // Change Period (visuel / fallback)

            async function fetchStats(period) {
                const url = @json(route('hoost.dashboard.stats')) + '?period=' + encodeURIComponent(period);

                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!res.ok) throw new Error('Erreur stats: ' + res.status);
                return await res.json();
            }

            async function applyPeriod(period) {
                try {
                    // (optionnel) loader léger
                    legendContainer.style.opacity = '0.5';

                    const data = await fetchStats(period);

                    chart.data.labels = data.labels;

                    chart.data.datasets[0].data = data.series.reservations;
                    chart.data.datasets[1].data = data.series.revenus;
                    chart.data.datasets[2].data = data.series.commission;
                    chart.data.datasets[3].data = data.series.part_projet;

                    chart.update();
                    renderLegend();
                } catch (e) {
                    console.error(e);
                    alert("Impossible de charger les statistiques pour " + period);
                } finally {
                    legendContainer.style.opacity = '1';
                }
            }

            // changement de période
            if (periodSelect) {
                periodSelect.addEventListener('change', function() {
                    applyPeriod(this.value);
                });

                // au chargement, on charge la période par défaut (month)
                applyPeriod(periodSelect.value || 'month');
            }



        });
    </script>

    <style>
        /* Legend premium */
        #myChartLegend {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .vh-legend {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .vh-legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            cursor: pointer;
            user-select: none;
            background: #fff;
            font-size: 12px;
        }

        .vh-legend-item.is-off {
            opacity: .45;
        }

        .vh-legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #111827;
            /* Chart.js mettra ses couleurs par défaut, on reste neutre */
        }

        .vh-legend-label {
            color: #374151;
            font-weight: 600;
        }
    </style>
@endsection
