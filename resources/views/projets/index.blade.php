{{-- @extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">
            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Projets Communautaires</span></div>
                @include('partials/hearder2')
            </div>
            <!-- Titre end -->

            <div class="dasboard-wrapper fl-wrap">
                <div class="dasboard-widget-title fl-wrap"
                    style="display:flex;justify-content:space-between;align-items:center;">
                    <h5>Liste des projets</h5>
                    <a href="{{ route('hoost.projets.create') }}" class="btn color-bg float-btn">
                        <i class="fas fa-plus"></i> Ajouter un projet
                    </a>
                </div>

                <div class="dasboard-widget-box fl-wrap">
                    <div class="row">
                        @forelse ($projets as $projet)
                            <div class="col-md-6">
                                <div class="bookings-item fl-wrap">
                                    <div class="bookings-item-header fl-wrap">
                                        <img src="{{ asset('assets/images/all/1.jpg') }}" alt="">
                                        <h4>
                                            <a href="javascript:void(0)">
                                                {{ ucfirst($projet->titre) }}
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="bookings-item-content fl-wrap">
                                        <ul>
                                            <li>
                                                <strong>Description:</strong>
                                                <span>{{ \Illuminate\Support\Str::limit($projet->description, 55) }}</span>
                                            </li>
                                            <li>
                                                <strong>Date de début:</strong>
                                                <span>{{ \Carbon\Carbon::parse($projet->date_debut)->format('d/m/Y') }}</span>
                                            </li>

                                            <li>
                                                <strong>catégorie:</strong>
                                                <span>{{ $projet->categorie->libelle }}</span>
                                            </li>

                                            <li>
                                                <strong>Pourcentage:</strong>
                                                <span>{{ $projet->pourcentage_contribution }}</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="bookings-item-footer fl-wrap">
                                        <span class="message-date">
                                            {{ $projet->updated_at }}
                                        </span>
                                        <ul>
                                            <li>
                                                <form id="delete-projet-{{ $projet->id }}"
                                                    action="{{ route('hoost.projets.destroy', $projet->id) }}" method="POST"
                                                    style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="#" class="tolt" data-microtip-position="top-left"
                                                    data-tooltip="Supprimer"
                                                    onclick="event.preventDefault(); 
                                                        if(confirm('Supprimer ce projet ?')) 
                                                        document.getElementById('delete-projet-{{ $projet->id }}').submit();">
                                                    <i class="far fa-trash"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('hoost.projets.edit', $projet->id) }}" class="tolt"
                                                    data-microtip-position="top-left" data-tooltip="Éditer">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p>Aucun projet enregistré pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection --}}


@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">

            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Les projets Communautaires</span></div>
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

            <div class="dasboard-widget-box fl-wrap">
                <div class="custom-form">
                    <div class="row">
                        <div class="dasboard-widget-title fl-wrap"
                            style="display:flex;justify-content:space-between;align-items:center;">
                            <h5>Liste des projets</h5>
                            <a href="{{ route('hoost.projets.create') }}" class="btn color-bg float-btn">
                                <i class="fas fa-plus"></i>Nouveau projet
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:left; width:200px;">Titre</th>
                                    <th style="text-align:left; width:200px;">Description</th>
                                    <th style="text-align:left; width:200px;">Date de début</th>
                                    <th style="text-align:left; width:200px;">Catégorie</th>
                                    <th style="text-align:left; width:200px;">Pourcentage de contribution</th>
                                    <th style="width:200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projets as $projet)
                                    <tr>
                                        <td style="text-align:left; width:200px;">{{ $projet->titre }}</td>
                                        <td style="text-align:left; width:200px;">{{ Str::limit($projet->description, 90) }}
                                        </td>
                                        <td style="text-align:left; width:200px;">
                                            {{ \Carbon\Carbon::parse($projet->date_debut)->format('d/m/Y') }}</td>
                                        <td style="text-align:left; width:200px;">{{ $projet->categorie->libelle }}</td>
                                        <td style="text-align:left; width:200px;">{{ $projet->pourcentage_contribution }}
                                        </td>
                                        {{-- <td style="text-align:left; width:200px;">
                                            {{ $projet->created_at->format('d/m/Y H:i') }}</td> --}}
                                        <td class="align-middle text-end">
                                            <div class="vh-action-dropdown">
                                                <button type="button" class="vh-action-btn">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="vh-action-menu">
                                                    <a href="{{ route('hoost.projets.edit', $projet) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a>
                                                    {{-- <a href="{{ route('hoost.projets.show',$projet) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-eye me-2"></i>Voir plus
                                                    </a> --}}
                                                    <button type="button" class="vh-action-item projet-open"
                                                        data-projet-id="{{ $projet->id }}"
                                                        data-titre="{{ $projet->titre }}"
                                                        data-description="{{ $projet->description }}" {{-- data-annonce-url="{{ $projet->annonce_url }}" --}}
                                                        {{-- data-created-at="{{ optional($projet->created_at)->format('d/m/Y H:i') }}" --}}>
                                                        <i class="fa fa-eye me-2"></i>Voir plus
                                                    </button>

                                                    <form action="{{ route('hoost.projets.destroy', $projet) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Confirmer la suppression de ce projet ?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="vh-action-item vh-action-danger">
                                                            <i class="fa fa-trash me-2"></i> Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Aucun projet enregistré pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        @if ($projets->hasPages())
            <div class="pagination" style="margin-top:25px;">
                {{-- Précédent --}}
                @if ($projets->onFirstPage())
                    <a href="javascript:void(0)" class="prevposts-link disabled">
                        <i class="fa fa-caret-left"></i>
                    </a>
                @else
                    <a href="{{ $projets->previousPageUrl() }}" class="prevposts-link">
                        <i class="fa fa-caret-left"></i>
                    </a>
                @endif

                {{-- Pages --}}
                @for ($page = 1; $page <= $projets->lastPage(); $page++)
                    @if ($page == $projets->currentPage())
                        <a href="{{ $projets->url($page) }}" class="current-page">
                            {{ $page }}
                        </a>
                    @else
                        <a href="{{ $projets->url($page) }}">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                {{-- Suivant --}}
                @if ($projets->hasMorePages())
                    <a href="{{ $projets->nextPageUrl() }}" class="nextposts-link">
                        <i class="fa fa-caret-right"></i>
                    </a>
                @else
                    <a href="javascript:void(0)" class="nextposts-link disabled">
                        <i class="fa fa-caret-right"></i>
                    </a>
                @endif
            </div>
        @endif



    </div>




    <div id="vh-fav-modal" class="vh-fav-modal">
        <div class="vh-fav-overlay"></div>

        <div class="vh-fav-dialog">
            <div class="vh-fav-header color-bg">
                <span>Détails du projet</span>
                <button type="button" class="vh-fav-close"><i class="fal fa-times"></i></button>
            </div>

            <div class="vh-fav-body">
                <div class="vh-projet-grid">
                    {{-- <div class="vh-row">
                        <div class="vh-label">Titre</div>
                        <div class="vh-value"><span class="vh-chip" id="vhprojetType">-</span></div>
                    </div> --}}

                    {{-- <div class="vh-row">
                        <div class="vh-label">Date</div>
                        <div class="vh-value" id="vhprojetCreatedAt">-</div>
                    </div>

                    <div class="vh-row">
                        <div class="vh-label">Lien annonce</div>
                        <div class="vh-value">
                            <a href="#" target="_blank" id="vhprojetUrl" class="vh-link">-</a>
                        </div>
                    </div> --}}
                </div>

                <div class="vh-section-title">Description</div>
                <div class="vh-message-box" id="vhprojetMessage">-</div>
            </div>


        </div>
    </div>



    <style>
        /* ===== MODAL CONTAINER ===== */
        .vh-fav-modal {
            position: fixed;
            /* ← clé */
            inset: 0;
            /* top:0 right:0 bottom:0 left:0 */
            z-index: 9999;
            display: none;
            /* caché par défaut */
        }

        /* visible */
        .vh-fav-modal.vh-open {
            display: flex;
            align-items: center;
            /* centre vertical */
            justify-content: center;
            /* centre horizontal */
        }

        /* ===== OVERLAY ===== */
        .vh-fav-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(2px);
        }

        /* ===== DIALOG ===== */
        .vh-fav-dialog {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 520px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, .35);
            animation: vhZoom .25s ease;
        }


        .vh-fav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            color: white;
        }

        .vh-fav-close {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 0;
            background: rgba(255, 255, 255, .18);
            color: #fff;
            cursor: pointer;
        }

        .vh-fav-close:hover {
            background: rgba(255, 255, 255, .28);
        }




        /* ===== BODY ===== */
        .vh-fav-body {
            padding: 18px;
        }




        /* ===== NO SCROLL PAGE ===== */
        .vh-no-scroll {
            overflow: hidden;
        }

        /* ===== ANIMATION ===== */
        @keyframes vhZoom {
            from {
                transform: scale(.92);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }


        /* Layout interne */
        .vh-projet-grid {
            display: grid;
            gap: 10px;
            margin-bottom: 14px;
        }

        .vh-row {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 12px;
            align-items: center;
            padding: 10px 12px;
            border: 1px solid #eee;
            border-radius: 10px;
            background: #fafafa;
        }

        .vh-label {
            font-weight: 600;
            color: #444;
            font-size: 13px;
        }

        .vh-value {
            color: #111;
            font-size: 13px;
            line-height: 1.4;
            word-break: break-word;
            /* casse les longs mots */
            overflow-wrap: anywhere;
            /* casse aussi URLs */
        }

        .vh-chip {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(0, 0, 0, .06);
            font-weight: 700;
            text-transform: capitalize;
        }

        .vh-link {
            color: #D1B11B;
            text-decoration: none;
            font-weight: 600;
        }

        .vh-link:hover {
            text-decoration: underline;
        }

        /* Message */
        .vh-section-title {
            font-weight: 700;
            margin: 8px 0 8px;
            color: #222;
        }

        .vh-message-box {
            border: 1px solid #eee;
            background: #fff;
            border-radius: 10px;
            padding: 12px;
            max-height: 160px;
            /* si long => scroll */
            overflow: auto;
            line-height: 1.5;
            font-size: 13px;

            /* IMPORTANT pour ton cas */
            word-break: break-word;
            overflow-wrap: anywhere;
            white-space: pre-wrap;
            /* garde les retours à la ligne */
        }
    </style>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('vh-fav-modal');
            if (!modal) return;

            const overlay = modal.querySelector('.vh-fav-overlay');
            const closeBtn = modal.querySelector('.vh-fav-close');

            // champs d'affichage
            const elType = document.getElementById('vhprojetType');
            const elMessage = document.getElementById('vhprojetMessage');
            const elUrl = document.getElementById('vhprojetUrl');
            const elCreatedAt = document.getElementById('vhprojetCreatedAt');

            function openModalWithprojet(data) {
                if (elType) elType.textContent = data.titre || '-';
                if (elMessage) elMessage.textContent = data.description || '-';
                if (elCreatedAt) elCreatedAt.textContent = data.createdAt || '-';

                if (elUrl) {
                    const url = data.annonceUrl || '';
                    elUrl.textContent = url ? url : 'Aucun';
                    elUrl.href = url ? url : '#';
                    elUrl.style.pointerEvents = url ? 'auto' : 'none';
                }

                modal.classList.add('vh-open');
                document.body.classList.add('vh-no-scroll');
            }

            function closeModal() {
                modal.classList.remove('vh-open');
                document.body.classList.remove('vh-no-scroll');
            }

            // Clic "Voir plus"
            document.querySelectorAll('.projet-open').forEach(btn => {
                btn.addEventListener('click', function() {
                    openModalWithprojet({
                        id: this.dataset.projetId,
                        titre: this.dataset.titre,
                        description: this.dataset.description,
                        annonceUrl: this.dataset.annonceUrl,
                        createdAt: this.dataset.createdAt,
                    });

                    // optionnel: fermer le dropdown actions si besoin
                    const menu = this.closest('.vh-action-menu');
                    if (menu) menu.classList.remove('open');
                });
            });

            if (overlay) overlay.addEventListener('click', closeModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('vh-open')) closeModal();
            });
        });
    </script>

@endsection
