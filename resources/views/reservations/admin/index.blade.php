@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Réservations</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-wrapper fl-wrap">
                <div class="dasboard-listing-box fl-wrap">
                    <!-- dashboard-listings-wrap-->
                    <div class="dashboard-listings-wrap fl-wrap">
                        <div class="row">
                            @forelse($reservations as $reservation)
                                <div class="col-md-6">
                                    <div class="dashboard-listings-item fl-wrap">
                                        <div class="dashboard-listings-item_img">
                                            <div class="bg-wrap">
                                                @php
                                                    $photo = $reservation->logement->photos->first()->url;
                                                @endphp
                                                <div class="bg" data-bg="{{ $photo }}"></div>
                                            </div>
                                            <div class="overlay"></div>
                                        </div>
                                        <div class="dashboard-listings-item_content">
                                            <h4>
                                                <a href="#">
                                                    {{ $reservation->logement->titre }}
                                                </a>
                                            </h4>
                                            <div class="geodir-category-location location-column">
                                                <div class="loc-item">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>{{ $reservation->logement->adresse }}</span>
                                                </div>

                                                <div class="loc-item">
                                                    <i class="fal fa-money-bill-wave"></i>
                                                    <span>{{ number_format($reservation->montant, 0, ',', ' ') }} FCFA</span>
                                                </div>

                                                <div class="loc-item">
                                                    <i class="fal fa-calendar"></i>
                                                    <span>
                                                        Du {{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}
                                                        Au {{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
                                                    </span>
                                                </div>

                                                <div class="loc-item">
                                                    <i class="fal fa-users"></i>
                                                    <span>{{ $reservation->nb_voyageurs }} voyageurs</span>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            
                                            <div class="dashboard-listings-item_opt">
                                                <ul>
                                                    <li>
                                                        <a href="#" class="tolt"
                                                            data-microtip-position="top-left"
                                                            data-tooltip="Détails">
                                                            <i class="fal fa-eye"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p>Vous n'avez fait aucune réservation.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- dashboard-listings-wrap end-->
                </div>

                <!-- pagination-->
                @if ($reservations->hasPages())
                    <div class="pagination">
                        {{-- Précédent --}}
                        @if ($reservations->onFirstPage())
                            <a href="javascript:void(0)" class="prevposts-link disabled">
                                <i class="fa fa-caret-left"></i>
                            </a>
                        @else
                            <a href="{{ $reservations->previousPageUrl() }}" class="prevposts-link">
                                <i class="fa fa-caret-left"></i>
                            </a>
                        @endif

                         {{-- Pages --}}
                        @for ($page = 1; $page <= $reservations->lastPage(); $page++)
                            @if ($page == $reservations->currentPage())
                                <a href="{{ $reservations->url($page) }}" class="current-page">
                                    {{ $page }}
                                </a>
                            @else
                                <a href="{{ $reservations->url($page) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endfor

                        {{-- Suivant --}}
                        @if ($reservations->hasMorePages())
                            <a href="{{ $reservations->nextPageUrl() }}" class="nextposts-link">
                                <i class="fa fa-caret-right"></i>
                            </a>
                        @else
                            <a href="javascript:void(0)" class="nextposts-link disabled">
                                <i class="fa fa-caret-right"></i>
                            </a>
                        @endif
                    </div>
                @endif
                <!-- pagination end-->
            </div>
        </div>

    </div>
    <!-- content end -->



    <style>
        .location-column {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 10px;
            color: #999;
        }

        .location-column .loc-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .location-column .loc-item i {
            width: 20px;
            text-align: center;
            color: #D1B11B;
            font-size: 14px;
        }

        .location-column .loc-item span {
            font-size: 14px;
        }

        /* Empêcher le scroll quand le popup est ouvert */
        .vh-no-scroll {
            overflow: hidden;
        }

        .vh-fav-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .vh-fav-modal.vh-open {
            display: flex;
        }

        .vh-fav-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.55);
        }

        .vh-fav-dialog {
            position: relative;
            z-index: 1;
            background: #fff;
            border-radius: 16px;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            overflow: hidden;
            font-size: 14px;
        }

        .vh-fav-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            color: #fff;
        }

        .vh-fav-close {
            border: none;
            background: transparent;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vh-fav-body {
            padding: 14px 16px 16px;
        }

        .vh-fav-text {
            font-size: 13px;
            color: #555;
            margin-bottom: 8px;
        }

        .vh-fav-label {
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .vh-fav-input {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 8px 10px;
            font-size: 13px;
            margin-bottom: 10px;
            background: #fafafa;
        }

        .vh-fav-input:focus {
            outline: none;
            border-color: #00c683;
            background: #fff;
        }

        .vh-fav-btn-main {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 9px;
            font-size: 13px;
            cursor: pointer;
            color: #fff;
            display:flex;
            align-items:center;
            justify-content:center;
        }
    </style>

@endsection
