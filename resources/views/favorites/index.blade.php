@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dashboard Menu
        </div>

        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Mes favoris</span>
                </div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            

            <!-- Header de la page favoris -->
            <div class="dasboard-widget-box fl-wrap vh-fav-page-header">
                <div class="vh-fav-header-left">
                    <h3 class="vh-fav-page-title">Mes listes de favoris</h3>
                    <p class="vh-fav-page-sub">
                        Retrouvez ici tous les logements que vous avez enregistrés.
                    </p>
                </div>
                <div class="vh-fav-header-right">
                    <a href="{{ route('hoost.logements.visiteurs.index') }}" class="btn color-bg">
                        <i class="fal fa-search"></i> Continuer à explorer
                    </a>
                </div>
            </div>

            @forelse($lists as $list)
                <div class="dasboard-widget-box fl-wrap vh-fav-list-box">
                    <!-- En-tête de la liste -->
                    <div class="vh-fav-list-header">
                        <div class="vh-fav-list-left">
                            {{-- Renommer la liste --}}
                            <form action="{{ route('hoost.favorites.lists.rename', $list) }}"
                                  method="POST"
                                  class="vh-fav-rename-form">
                                @csrf
                                @method('PATCH')
                                <input type="text"
                                       name="libelle"
                                       class="vh-fav-rename-input"
                                       value="{{ $list->libelle }}"
                                       maxlength="50">
                                <button class="vh-fav-rename-btn" type="submit">
                                    <i class="fal fa-pen"></i> Renommer
                                </button>
                            </form>

                            {{-- Partage --}}
                            @if($list->est_partage)
                                <a href="{{ route('hoost.favorites.share.show', $list->lien_partage) }}"
                                   class="vh-fav-share-btn"
                                   target="_blank">
                                    <i class="fal fa-link"></i> Lien de partage
                                </a>
                            @else
                                <span class="vh-fav-share-badge">
                                    Partage désactivé
                                </span>
                            @endif
                        </div>

                        <!-- Supprimer la liste -->
                        <div class="vh-fav-list-right">

                            {{-- Bouton activer / désactiver partage --}}
                            <form action="{{ route('hoost.favorites.lists.share.toggle', $list) }}"
                                  method="POST"
                                  class="vh-fav-share-toggle-form">
                                @csrf
                                <button type="submit" class="vh-fav-share-toggle-btn color-bg">
                                    @if($list->est_partage)
                                        <i class="fal fa-lock"></i> Désactiver le partage
                                    @else
                                        <i class="fal fa-unlock"></i> Activer le partage
                                    @endif
                                </button>
                            </form>

                            <form action="{{ route('hoost.favorites.lists.delete', $list) }}"
                                  method="POST"
                                  onsubmit="return confirm('Supprimer cette liste ?');">
                                @csrf
                                @method('DELETE')
                                <button class="vh-fav-delete-list-btn" type="submit">
                                    <i class="fal fa-trash"></i> Supprimer la liste
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contenu de la liste -->
                    <div class="vh-fav-list-body">
                        @if($list->items->count())
                            <div class="row">
                                @foreach($list->items as $it)
                                    @php
                                        $l = $it->logement;
                                        if (!$l) continue;
                                        $photo = optional($l->photos->first())->url ?? asset('images/default-house.jpg');
                                    @endphp
                                    <div class="col-md-3 col-sm-6">
                                        <div class="vh-fav-logement-card fl-wrap">
                                            <div class="vh-fav-card-img">
                                                <img src="{{ $photo }}"
                                                     alt="Photo de {{ $l->titre }}">
                                            </div>
                                            <div class="vh-fav-card-body">
                                                <div class="vh-fav-card-title" title="{{ $l->titre }}">
                                                    {{ $l->titre }}
                                                </div>
                                                @isset($l->prix_par_nuit)
                                                    <div class="vh-fav-card-price">
                                                        {{ number_format($l->prix_par_nuit, 0, ',', ' ') }} FCFA
                                                        <span class="vh-fav-card-price-unit">/ nuit</span>
                                                    </div>
                                                @endisset
                                            </div>
                                            <div class="vh-fav-card-footer">
                                                <a href="{{ route('hoost.logements.show', $l) }}"
                                                   class="vh-fav-btn-view">
                                                    <i class="fal fa-eye"></i> Voir
                                                </a>

                                                <form action="{{ route('hoost.favorites.items.remove', [$list, $l]) }}"
                                                      method="POST"
                                                      class="vh-fav-remove-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="vh-fav-btn-remove">
                                                        <i class="fal fa-times"></i> Retirer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="vh-fav-empty-list">
                                Aucun logement dans cette liste.
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="dasboard-widget-box fl-wrap vh-fav-empty-global">
                    <p>
                        Aucune liste de favoris pour le moment.
                        Cliquez sur <i class="fal fa-heart"></i> sur un logement pour en créer une.
                    </p>
                    <a href="{{ route('hoost.logements.visiteurs.index') }}" class="btn color-bg">
                        <i class="fal fa-search"></i> Commencer à explorer
                    </a>
                </div>
            @endforelse
        </div>

        <div class="dashbard-bg gray-bg"></div>
    </div>
    <!-- content end -->

    <style>
        /* ========= PAGE FAVORIS ========= */

        .vh-fav-page-header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:15px 20px;
            margin-bottom:15px;
            border-radius:12px;
        }

        .vh-fav-header-left {
            display:flex;
            flex-direction:column;
            gap:3px;
        }

        .vh-fav-page-title {
            font-size:18px;
            font-weight:600;
            margin:0;
        }

        .vh-fav-page-sub {
            font-size:13px;
            color:#777;
            margin:0;
        }

        .vh-fav-header-right .btn {
            font-size:13px;
            padding:8px 14px;
            border-radius:20px;
            display:inline-flex;
            align-items:center;
            gap:6px;
        }

        /* ========= BLOC LISTE FAVORIS ========= */

        .vh-fav-list-box {
            padding:15px 18px 18px;
            border-radius:12px;
            margin-bottom:15px;
        }

        .vh-fav-list-header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
            margin-bottom:12px;
            border-bottom:1px solid #f1f1f1;
            padding-bottom:8px;
        }

        .vh-fav-list-left {
            display:flex;
            align-items:center;
            flex-wrap:wrap;
            gap:8px;
        }

        .vh-fav-rename-form {
            display:flex;
            align-items:center;
            gap:6px;
        }

        .vh-fav-rename-input {
            border-radius:20px;
            border:1px solid #ddd;
            padding:4px 10px;
            font-size:13px;
            min-width:200px;
            max-width:260px;
        }

        .vh-fav-rename-input:focus {
            outline:none;
            border-color:#00c683;
        }

        .vh-fav-rename-btn {
            border:none;
            background:#f1f3f5;
            border-radius:20px;
            padding:4px 10px;
            font-size:12px;
            display:flex;
            align-items:center;
            gap:5px;
            cursor:pointer;
            color:#444;
        }

        .vh-fav-rename-btn i {
            font-size:12px;
        }

        .vh-fav-share-btn {
            font-size:12px;
            padding:4px 10px;
            border-radius:20px;
            border:1px solid #ddd;
            display:inline-flex;
            align-items:center;
            gap:5px;
            color:#444;
            background:#fff;
        }

        .vh-fav-share-btn i {
            font-size:12px;
        }

        .vh-fav-share-badge {
            font-size:11px;
            padding:4px 8px;
            border-radius:20px;
            background:#f8f9fa;
            color:#777;
        }

        .vh-fav-list-right {
            display:flex;
            align-items:center;
        }

        .vh-fav-delete-list-btn {
            border-radius:20px;
            border:1px solid #f8d7da;
            background:#fff5f5;
            color:#c92a2a;
            padding:4px 10px;
            font-size:12px;
            display:flex;
            align-items:center;
            gap:5px;
            cursor:pointer;
        }

        .vh-fav-delete-list-btn i {
            font-size:12px;
        }

        .vh-fav-list-body {
            margin-top:5px;
        }

        .vh-fav-empty-list {
            font-size:13px;
            color:#777;
            margin:5px 0 0;
        }

        .vh-fav-empty-global {
            text-align:center;
            padding:25px 20px;
            border-radius:12px;
            margin-top:10px;
        }

        .vh-fav-empty-global p {
            margin-bottom:10px;
            font-size:14px;
            color:#555;
        }

        .vh-fav-empty-global .btn {
            font-size:13px;
            padding:8px 16px;
            border-radius:20px;
            display:inline-flex;
            align-items:center;
            gap:6px;
        }

        /* ========= CARTE LOGEMENT FAVORI ========= */

        .vh-fav-logement-card {
            border-radius:12px;
            overflow:hidden;
            background:#fff;
            box-shadow:0 4px 12px rgba(0,0,0,0.04);
            margin-bottom:12px;
            display:flex;
            flex-direction:column;
            height:100%;
        }

        .vh-fav-card-img {
            position:relative;
            width:100%;
            padding-top:62%;
            overflow:hidden;
        }

        .vh-fav-card-img img {
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
        }

        .vh-fav-card-body {
            padding:8px 10px 4px;
        }

        .vh-fav-card-title {
            font-size:13px;
            font-weight:600;
            color:#333;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
            margin-bottom:2px;
        }

        .vh-fav-card-price {
            font-size:12px;
            font-weight:500;
            color: #D1B11B;
        }

        .vh-fav-card-price-unit {
            font-size:11px;
            color: #777;
            margin-left:3px;
        }

        .vh-fav-card-footer {
            padding:6px 10px 8px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:6px;
            border-top:1px solid #f1f1f1;
            margin-top:auto;
        }

        .vh-fav-btn-view,
        .vh-fav-btn-remove {
            font-size:11px;
            padding:5px 8px;
            border-radius:16px;
            display:inline-flex;
            align-items:center;
            gap:4px;
            text-decoration:none;
            cursor:pointer;
            border:1px solid transparent;
        }

        .vh-fav-btn-view {
            background:#fff;
            border-color: #D1B11B;
            color: #D1B11B;
        }

        .vh-fav-btn-remove {
            background:#fff5f5;
            border-color:#f8d7da;
            color:#c92a2a;
        }

        .vh-fav-btn-view i,
        .vh-fav-btn-remove i {
            font-size:11px;
        }

        .vh-fav-remove-form {
            margin:0;
        }

        @media (max-width: 767px) {
            .vh-fav-list-header {
                flex-direction:column;
                align-items:flex-start;
            }
            .vh-fav-list-right {
                align-self:flex-end;
            }
        }

        .vh-fav-share-toggle-btn{
            
            font-size:11px;
            padding:5px 8px;
            border-radius:16px;
            display:inline-flex;
            align-items:center;
            gap:4px;
            color:white;
            text-decoration:none;
            cursor:pointer;
            border:1px solid transparent;
        }
    </style>
@endsection
