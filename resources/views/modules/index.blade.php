@extends('layouts.app')
@section('section')
<div class="dashboard-content">
    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
    <div class="container dasboard-container">
        
        <!-- Titre -->
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item"><span>Modules</span></div>
            @include('partials/hearder2')
        </div>
        <!-- Titre end -->

        <div class="dasboard-wrapper fl-wrap">
            <div class="dasboard-widget-title fl-wrap" style="display: flex; justify-content: space-between; align-items: center;">
                <h5>Liste des modules</h5>
                <a href="{{ route('hoost.modules.create') }}" class="btn color-bg float-btn">
                    <i class="fas fa-plus"></i> Ajouter un module
                </a>
            </div>

            <div class="dasboard-widget-box fl-wrap">
                <div class="row">

                    @forelse ($modules as $module)
                        <div class="col-md-6">
                            <div class="bookings-item fl-wrap">
                                <div class="bookings-item-header fl-wrap">
                                    <img src="{{ asset('images/all/1.jpg') }}" alt="">
                                    <h4>
                                        <a href="javascript:void(0)">
                                            {{ ucfirst($module->name) }}
                                        </a>
                                    </h4>
                                </div>

                                <div class="bookings-item-content fl-wrap">
                                    <ul>
                                        <li><strong>Créé le :</strong> <span>{{$module->created_at->format('d/m/Y H:i') }}</span></li>
                                    </ul>
                                </div>

                                <div class="bookings-item-footer fl-wrap">
                                    <span class="message-date">{{$module->updated_at->format('d/m/Y H:i') }}</span>
                                    <ul>
                                        <li>
                                            <form id="delete-form-{{$module->id }}" action="{{ route('hoost.modules.destroy',$module->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <a href="#" class="tolt" 
                                               data-microtip-position="top-left" 
                                               data-tooltip="Supprimer"
                                               onclick="
                                                    if(confirm('Êtes-vous sûr de vouloir supprimer ce module ?')) {
                                                        event.preventDefault();
                                                        document.getElementById('delete-form-{{$module->id }}').submit();
                                                    } else {
                                                        event.preventDefault();
                                                    }">
                                                <i class="far fa-trash"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('hoost.modules.edit',$module->id) }}" class="tolt" data-microtip-position="top-left" data-tooltip="Éditer">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>Aucun module enregistré pour le moment.</p>
                        </div>
                    @endforelse

                </div>
            </div>

            <!-- Pagination simple -->
            {{-- <div class="pagination float-pagination">
                {{ $modules->links() }}
            </div> --}}
            <!-- Pagination end -->
        </div>
    </div>
</div>

@endsection
