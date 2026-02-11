@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">

            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Equipements</span></div>
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
                            <h5>Liste des equipements</h5>
                            <a href="{{ route('hoost.equipements.create') }}" class="btn color-bg float-btn">
                                <i class="fas fa-plus"></i> Ajouter un équipement
                            </a>
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:left; width:200px;">Libellé</th>
                                    <th style="text-align:left; width:200px;">Date de création</th>
                                    <th style="width:200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($equipements as $index => $equipement)
                                    <tr>
                                        <td style="text-align:left; width:200px;">{{ Str::limit($equipement->libelle,100) }}</td>
                                        <td style="text-align:left; width:200px;">
                                            {{ $equipement->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="align-middle text-end">
                                            <div class="vh-action-dropdown">
                                                <button type="button" class="vh-action-btn">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="vh-action-menu">
                                                    <a href="{{ route('hoost.equipements.edit',$equipement) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a>

                                                    <form
                                                        action="{{ route('hoost.equipements.destroy',$equipement) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Confirmer la suppression de cet équipement ?');">
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
                                        <td colspan="4" class="text-center">Aucun équipement enregistré pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dashboard container end -->
    </div>
    <!-- content end -->

@endsection
