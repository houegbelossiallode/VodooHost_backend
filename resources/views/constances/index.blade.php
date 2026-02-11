@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">

            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Constantes</span></div>
                @include('partials/hearder2')
            </div>
            <!-- Titre end -->

            <div class="dasboard-wrapper fl-wrap">
                <div class="dasboard-widget-title fl-wrap"
                    style="display: flex; justify-content: space-between; align-items: center;">
                    <h5>Liste des constances</h5>
                    <a href="{{ route('hoost.constances.create') }}" class="btn color-bg float-btn">
                        <i class="fas fa-plus"></i> Ajouter une constante
                    </a>
                </div>

                <div class="dasboard-widget-box fl-wrap">
                    <div class="row">

                        @forelse ($constances as $constance)
                            <div class="col-md-6">
                                <div class="bookings-item fl-wrap">
                                    <div class="bookings-item-header fl-wrap">
                                        <img src="{{ asset('images/all/1.jpg') }}" alt="">
                                        <h4>
                                            <a href="javascript:void(0)">
                                                {{ ucfirst($constance->param) }}
                                            </a>
                                        </h4>
                                    </div>

                                    <div class="bookings-item-content fl-wrap">
                                        <ul>
                                            <li><strong>Valeur:</strong> <span>{{ $constance->val }}</span></li>
                                            <li><strong>Créé le :</strong>
                                                <span>{{ $constance->created_at->format('d/m/Y H:i') }}</span></li>
                                        </ul>
                                    </div>

                                    <div class="bookings-item-footer fl-wrap">
                                        <span class="message-date">{{ $constance->updated_at->format('d/m/Y H:i') }}</span>
                                        <ul>
                                            <li>
                                                <form id="delete-form-{{ $constance->id }}"
                                                    action="{{ route('hoost.constances.destroy', $constance->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <a href="#" class="tolt" data-microtip-position="top-left"
                                                    data-tooltip="Supprimer"
                                                    onclick="
                                                    if(confirm('Êtes-vous sûr de vouloir supprimer cette constante ?')) {
                                                        event.preventDefault();
                                                        document.getElementById('delete-form-{{ $constance->id }}').submit();
                                                    } else {
                                                        event.preventDefault();
                                                    }">
                                                    <i class="far fa-trash"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('hoost.constances.edit', $constance->id) }}" class="tolt"
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
                                <p>Aucune constante enregistrée pour le moment.</p>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
