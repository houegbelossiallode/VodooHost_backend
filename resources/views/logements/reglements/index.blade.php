@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Tableau de bord
        </div>

        <div class="container dasboard-container">
            <!-- Titre dashboard -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Les règlements</span>
                </div>
                @include('partials/hearder2')
            </div>
            <!-- Titre dashboard end -->

            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5><i class="fa fa-home"></i> Liste des règlements</h5>
                <a href="{{ route('hoost.logements.reglements.create', $logement->id) }}" class="btn color-bg float-btn"
                    style="margin-left: auto;">
                    <i class="fa fa-plus me-1"></i> Ajouter un règlement
                </a>
            </div>

            <div class="dasboard-widget-box fl-wrap">


                @if ($reglements->count() === 0)
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i> Aucun règlement enregistré pour le moment.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:left; width:200px;">Libelle</th>
                                    <th >Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reglements as $reglement)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="desc-col">
                                                <span class="desc-text">{{$reglement->libelle}}</span>
                                            </div>
                                        </td>

                                        <td class="align-middle text-end">
                                            <div class="vh-action-dropdown">
                                                <button type="button" class="vh-action-btn">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="vh-action-menu">
                                                    <a href="{{ route('hoost.logements.reglements.edit',['logement'=>$logement->id,'reglement'=>$reglement->id]) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a>

                                                    <form action="{{ route('hoost.logements.reglements.destroy',['logement'=>$logement->id,'reglement'=>$reglement->id]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Confirmer la suppression de ce règlement ?');">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- content end -->
    <div class="dashbard-bg gray-bg"></div>


    <script>
        document.addEventListener('click', function(e) {
            const toggle = e.target.closest('.vh-action-btn');
            const dropdowns = document.querySelectorAll('.vh-action-dropdown');

            // Fermer tous les dropdowns si on clique ailleurs
            dropdowns.forEach(function(dd) {
                if (!toggle || dd !== toggle.closest('.vh-action-dropdown')) {
                    dd.classList.remove('vh-open');
                }
            });

            // Si on a cliqué sur un bouton, on toggle celui-là
            if (toggle) {
                const parent = toggle.closest('.vh-action-dropdown');
                parent.classList.toggle('vh-open');
            }
        });
    </script>

@endsection
