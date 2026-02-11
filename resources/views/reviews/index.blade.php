@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dashboard Menu</div>
        <div class="container dasboard-container">

            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Avis laissés sur les hôtes </span></div>
                @include('partials/hearder2')
            </div>

            <div class="dasboard-widget-box fl-wrap">
                <div class="custom-form">
                    <div class="row">
                        <div class="dasboard-widget-title fl-wrap"
                            style="display:flex;justify-content:space-between;align-items:center;">
                            <h5>Liste des avis laissés sur les hôtes</h5>
                            {{-- <a href="" class="btn color-bg float-btn">
                                <i class="fas fa-plus"></i> Ajouter un point fort
                            </a> --}}
                           
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:left; width:200px;">Hôte</th>
                                    <th style="text-align:left; width:200px;">Commentaire</th>
                                     <th style="text-align:left; width:200px;">Critère</th>
                                      <th style="text-align:left; width:200px;">Note</th>
                                    <th style="width:200px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as  $review)
                                    <tr>
                                        <td style="text-align:left; width:200px;">{{ $review->reviewed->nom . ' ' . $review->reviewed->prenom}}</td>
                                        <td style="text-align:left; width:200px;">{{ $review->comment}}</td>
                                        <td style="text-align:left; width:200px;">{{ $review->critere}}</td>
                                        <td style="text-align:left; width:200px;">{{ number_format($review->rating, 0, ',', ' ')}}</td>
                                        <td class="align-middle text-end">
                                            <div class="vh-action-dropdown">
                                                <button type="button" class="vh-action-btn">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="vh-action-menu">
                                                    <a href="{{ route('hoost.reviews.edit',$review->id) }}"
                                                        class="vh-action-item">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a>

                                                    <form
                                                        action="{{ route('hoost.reviews.destroy',$review->id) }}"
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
                                        <td colspan="4" class="text-center">Aucun avis enregistré pour le moment.
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
