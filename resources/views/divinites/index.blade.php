{{-- @extends('layouts.app')

@section('section')
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
    <div class="container dasboard-container">

        <!-- Titre -->
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item"><span>Divinités</span></div>
            @include('partials/hearder2')
        </div>
        <!-- Titre end -->

        <div class="dasboard-wrapper fl-wrap">
            <div class="dasboard-widget-title fl-wrap" style="display:flex;justify-content:space-between;align-items:center;">
                <h5>Liste des divinités</h5>
                <a href="{{ route('hoost.divinites.create') }}"
                    class="btn color-bg float-btn">
                    <i class="fas fa-plus"></i> Ajouter une divinité
                </a>
            </div>

            <div class="dasboard-widget-box fl-wrap">
                <div class="row">
                    @forelse ($divinites as $divinite)
                        

                        <div class="col-md-6">
                            <div class="bookings-item fl-wrap">
                                <!-- Header -->
                                <div class="bookings-item-header fl-wrap">
                                    <img src="{{ $divinite->image }}" alt="{{ $divinite->nom}}" loading="lazy">
                                    <h4>
                                        <a href="javascript:void(0)">
                                            {{ ucfirst($divinite->nom) }}
                                        </a>
                                    </h4>
                                </div>

                                <!-- Contenu -->
                                <div class="bookings-item-content fl-wrap">
                                    <ul>
                                        <li>
                                            <strong>Description :</strong>
                                            <span>{{ \Illuminate\Support\Str::limit($divinite->description, 35) ?: '—' }}</span>
                                        </li>
                                        
                                        
                                        <li>
                                            <strong>Créé le :</strong>
                                            <span>{{ optional($divinite->created_at)->format('d/m/Y H:i') }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Footer -->
                                <div class="bookings-item-footer fl-wrap">
                                    <span class="message-date">
                                        {{ optional($divinite->updated_at)->format('d/m/Y H:i') }}
                                    </span>
                                    <ul>
                                        <li>
                                            <form id="delete-divinite-{{ $divinite->id }}"
                                                  action="{{ route('hoost.divinites.destroy', $divinite->id) }}"
                                                  method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="#" class="tolt"
                                               data-microtip-position="top-left" data-tooltip="Supprimer"
                                               onclick="event.preventDefault();
                                                        if(confirm('Supprimer cette divinité ?'))
                                                        document.getElementById('delete-divinite-{{ $divinite->id }}').submit();">
                                                <i class="far fa-trash"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('hoost.divinites.edit', $divinite->id) }}"
                                               class="tolt" data-microtip-position="top-left" data-tooltip="Éditer">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>Aucune divinité enregistré pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            
        </div>
    </div>
</div>

<style>
/* Image du rituel : pas de débordement, recadrée */
.bookings-item-header img.rituel-cover{
    width:100%;
    height:180px;           /* ajuste 160–220px selon ton design */
    object-fit:cover;
    border-radius:8px;
    display:block;
}

/* Titre sous l’image */
.bookings-item-header h4{
    margin-top:10px;
    font-size:16px;
    font-weight:600;
}

/* Sécurise le header contre tout dépassement */
.bookings-item-header{
    position:relative;
    overflow:hidden;
}
</style>
@endsection --}}


@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">

            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Divinités</span></div>
                 @include('partials/hearder2')
            </div>

            <div class="dasboard-widget-box fl-wrap">
                <div class="custom-form">
                    <div class="row">
                        <div class="dasboard-widget-title fl-wrap"
                            style="display:flex;justify-content:space-between;align-items:center;">
                            <h5>Liste des divinités</h5>
                            <a href="{{ route('hoost.divinites.create') }}" class="btn color-bg float-btn">
                                <i class="fas fa-plus"></i>Nouvelle divinité
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:left; width:200px;">Image</th>
                                    <th style="text-align:left; width:200px;">Nom</th>
                                    <th style="text-align:left; width:280px;">Description</th>
                                    
                                    <th style="width:200px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($divinites as $divinite)
                                    @php
                                        $imageSrc = $divinite->image
                                            ? (\Illuminate\Support\Str::startsWith($divinite->image, ['http://', 'https://'])
                                                ? $divinite->image
                                                : asset('storage/' . ltrim($divinite->image, '/')))
                                            : asset('images/all/1.jpg');
                                    @endphp

                                    <tr>
                                        <td style="text-align:left; width:200px;">
                                            <img src="{{ $imageSrc }}" alt="{{ $divinite->nom }}"
                                                 style="width: 65%; height: 65%; object-fit: contain;" loading="lazy">
                                        </td>

                                        <td style="text-align:left; width:200px;">
                                            {{ ucfirst($divinite->nom) }}
                                        </td>

                                        <td style="text-align:left; width:280px;">
                                            {{ \Illuminate\Support\Str::limit($divinite->description,40) }}
                                        </td>

                                        

                                        <td class="align-middle text-end">
                                            <div class="vh-action-dropdown">
                                                <button type="button" class="vh-action-btn">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="vh-action-menu">
                                                    <a href="{{ route('hoost.divinites.edit', $divinite) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a>

                                                    <button type="button" class="vh-action-item divinite-open"
                                                        data-id="{{ $divinite->id }}"
                                                        data-nom="{{ ucfirst($divinite->nom) }}"
                                                        data-description="{{ $divinite->description }}"
                                                        data-image="{{ $imageSrc }}">
                                                        <i class="fa fa-eye me-2"></i>Voir plus
                                                    </button>

                                                    <form action="{{ route('hoost.divinites.destroy', $divinite) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Confirmer la suppression de cette divinité ?');">
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
                                        <td colspan="5" class="text-center">Aucune divinité enregistrée pour le moment.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>


        {{-- Pagination (si $divinites est paginate()) --}}
        @if (method_exists($divinites, 'hasPages') && $divinites->hasPages())
            <div class="pagination" style="margin-top:25px;">
                @if ($divinites->onFirstPage())
                    <a href="javascript:void(0)" class="prevposts-link disabled">
                        <i class="fa fa-caret-left"></i>
                    </a>
                @else
                    <a href="{{ $divinites->previousPageUrl() }}" class="prevposts-link">
                        <i class="fa fa-caret-left"></i>
                    </a>
                @endif

                @for ($page = 1; $page <= $divinites->lastPage(); $page++)
                    @if ($page == $divinites->currentPage())
                        <a href="{{ $divinites->url($page) }}" class="current-page">{{ $page }}</a>
                    @else
                        <a href="{{ $divinites->url($page) }}">{{ $page }}</a>
                    @endif
                @endfor

                @if ($divinites->hasMorePages())
                    <a href="{{ $divinites->nextPageUrl() }}" class="nextposts-link">
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


    {{-- MODAL Divinité --}}
    <div id="vh-divinite-modal" class="vh-fav-modal">
        <div class="vh-fav-overlay"></div>

        <div class="vh-fav-dialog">
            <div class="vh-fav-header color-bg">
                <span id="vhDiviniteTitle">Détails de la divinité</span>
                <button type="button" class="vh-fav-close"><i class="fal fa-times"></i></button>
            </div>

            <div class="vh-fav-body">
                <div class="vh-rituel-grid">
                    <div class="vh-rituel-media">
                        <img id="vhDiviniteImage" src="" alt="Image divinité">
                    </div>
                </div>

                <div class="vh-section-title">Description</div>
                <div class="vh-message-box" id="vhDiviniteDescription">-</div>
            </div>
        </div>
    </div>


    {{-- ✅ On reprend le même CSS que ton modal rituels (en gardant image non coupée) --}}
    <style>
        .vh-fav-modal { position: fixed; inset: 0; z-index: 9999; display: none; }
        .vh-fav-modal.vh-open { display: flex; align-items: center; justify-content: center; }
        .vh-fav-overlay { position: absolute; inset: 0; background: rgba(0,0,0,.55); backdrop-filter: blur(2px); }

        .vh-fav-dialog {
            position: relative; z-index: 2;
            width: 100%; max-width: 520px;
            background: #fff; border-radius: 12px; overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,.35);
            animation: vhZoom .25s ease;
        }
        .vh-fav-header { display:flex; justify-content:space-between; align-items:center; padding:12px 16px; color:#fff; }
        .vh-fav-close { width:34px; height:34px; border-radius:10px; border:0; background: rgba(255,255,255,.18); color:#fff; cursor:pointer; }
        .vh-fav-close:hover { background: rgba(255,255,255,.28); }

        .vh-fav-body { padding: 18px; }
        .vh-no-scroll { overflow: hidden; }

        @keyframes vhZoom {
            from { transform: scale(.92); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .vh-rituel-grid { display: grid; gap: 10px; margin-bottom: 14px; }
        .vh-section-title { font-weight: 700; margin: 8px 0 8px; color: #222; }

        .vh-message-box {
            border: 1px solid #eee; background: #fff; border-radius: 10px;
            padding: 12px; max-height: 220px; overflow: auto;
            line-height: 1.5; font-size: 13px;
            word-break: break-word; overflow-wrap: anywhere; white-space: pre-wrap;
        }

        /* ✅ Image : jamais coupée */
        .vh-rituel-media { max-height: 300px; overflow: auto; text-align: center; }
        #vhDiviniteImage { max-width: 100%; height: auto; }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('vh-divinite-modal');
            if (!modal) return;

            const overlay = modal.querySelector('.vh-fav-overlay');
            const closeBtn = modal.querySelector('.vh-fav-close');

            const elTitle = document.getElementById('vhDiviniteTitle');
            const elDesc = document.getElementById('vhDiviniteDescription');
            const elImg = document.getElementById('vhDiviniteImage');

            function openModalWithDivinite(data) {
                if (elTitle) elTitle.textContent = data.nom ? ('Détails : ' + data.nom) : 'Détails de la divinité';
                if (elDesc) elDesc.textContent = data.description || '-';

                if (elImg) {
                    elImg.src = data.image || '';
                    elImg.style.display = data.image ? 'block' : 'none';
                }

                modal.classList.add('vh-open');
                document.body.classList.add('vh-no-scroll');
            }

            function closeModal() {
                modal.classList.remove('vh-open');
                document.body.classList.remove('vh-no-scroll');
            }

            document.querySelectorAll('.divinite-open').forEach(btn => {
                btn.addEventListener('click', function() {
                    openModalWithDivinite({
                        id: this.dataset.id,
                        nom: this.dataset.nom,
                        description: this.dataset.description,
                        image: this.dataset.image,
                    });

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

