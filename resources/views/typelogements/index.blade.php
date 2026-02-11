@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">

            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Type de logements</span></div>
                @include('partials/hearder2')
            </div>
            <!-- Titre end -->

            <div class="dasboard-wrapper fl-wrap">
                <div class="dasboard-widget-title fl-wrap"
                    style="display:flex;justify-content:space-between;align-items:center;">
                    <h5>Liste des types de logements</h5>
                    <a href="{{ route('hoost.typelogements.create') }}" class="btn color-bg float-btn">
                        <i class="fas fa-plus"></i> Ajouter un type de logement
                    </a>
                </div>

                <div class="dasboard-widget-box fl-wrap">
                    <div class="row">
                        @forelse ($typelogements as $typelogement)
                            <div class="col-md-6">
                                <div class="bookings-item fl-wrap">
                                    <!-- Header -->
                                    <div class="bookings-item-header fl-wrap">
                                        {{-- <img src="{{ $typelogement->image }}" alt="{{ $typelogement->nom }}"
                                    class="deity-cover" loading="lazy"> --}}
                                        <h4>
                                            <a href="javascript:void(0)">
                                                {{ ucfirst($typelogement->libelle) }}
                                            </a>
                                        </h4>
                                    </div>

                                    <!-- Contenu -->
                                    <div class="bookings-item-content fl-wrap">
                                        <ul>

                                            <li>
                                                <strong>Créé le :</strong>
                                                <span>{{ $typelogement->created_at->format('d/m/Y H:i') }}</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Footer -->
                                    <div class="bookings-item-footer fl-wrap">
                                        <span class="message-date">
                                            {{ $typelogement->updated_at->format('d/m/Y H:i') }}
                                        </span>
                                        <ul>
                                            <li>
                                                <form id="delete-typelogement-{{ $typelogement->id }}"
                                                    action="{{ route('hoost.typelogements.destroy', $typelogement->id) }}"
                                                    method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="#" class="tolt" data-microtip-position="top-left"
                                                    data-tooltip="Supprimer"
                                                    onclick="event.preventDefault();
                                                        if(confirm('Supprimer ce type de logement ?'))
                                                        document.getElementById('delete-typelogement-{{ $typelogement->id }}').submit();">
                                                    <i class="far fa-trash"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('hoost.typelogements.edit', $typelogement->id) }}"
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
                                <p>Aucune divinité enregistrée pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
