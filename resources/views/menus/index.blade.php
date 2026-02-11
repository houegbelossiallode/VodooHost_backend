@extends('layouts.app')
@section('section')
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
    <div class="container dasboard-container">
        
        <!-- Titre -->
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item"><span>Menus</span></div>
            @include('partials/hearder2')
        </div>
        <!-- Titre end -->

        <div class="dasboard-wrapper fl-wrap">
            <div class="dasboard-widget-title fl-wrap" style="display:flex;justify-content:space-between;align-items:center;">
                <h5>Liste des menus</h5>
                <a href="{{ route('hoost.menus.create') }}" 
                    class="btn color-bg float-btn">
                    <i class="fas fa-plus"></i> Ajouter un menu
                </a>
            </div>

            <div class="dasboard-widget-box fl-wrap">
                <div class="row">
                    @forelse ($menus as $menu)
                        <div class="col-md-6">
                            <div class="bookings-item fl-wrap">
                                <div class="bookings-item-header fl-wrap">
                                    <img src="{{ asset('images/all/1.jpg') }}" alt="">
                                    <h4>
                                        <a href="javascript:void(0)">
                                            {{ ucfirst($menu->name) }}
                                        </a>
                                    </h4>
                                </div>

                                <div class="bookings-item-content fl-wrap">
                                    <ul>
                                        <li>
                                            <strong>Module :</strong>
                                            <span>{{ $menu->module?->name ?? '—' }}</span>
                                        </li>
                                        <li>
                                            <strong>Icone :</strong>
                                            <span>{{ $menu->icon ?? '—' }}</span>
                                        </li>
                                        
                                        <li>
                                            <strong>Créé le :</strong>
                                            <span>{{ $menu->created_at->format('d/m/Y H:i') }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="bookings-item-footer fl-wrap">
                                    <span class="message-date">
                                        {{ $menu->updated_at->format('d/m/Y H:i') }}
                                    </span>
                                    <ul>
                                        <li>
                                            <form id="delete-menu-{{ $menu->id }}" 
                                                  action="{{ route('hoost.menus.destroy', $menu->id) }}" 
                                                  method="POST" 
                                                  style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="#" class="tolt" 
                                               data-microtip-position="top-left" 
                                               data-tooltip="Supprimer"
                                               onclick="event.preventDefault(); 
                                                        if(confirm('Supprimer ce menu ?')) 
                                                        document.getElementById('delete-menu-{{ $menu->id }}').submit();">
                                                <i class="far fa-trash"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('hoost.menus.edit', $menu->id) }}" 
                                               class="tolt" 
                                               data-microtip-position="top-left" 
                                               data-tooltip="Éditer">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>Aucun menu enregistré pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            {{-- <div class="pagination float-pagination">
                {{ $menus->links() }}
            </div> --}}
            <!-- Pagination end -->
        </div>
    </div>
</div>
@endsection
