@extends('layouts.app')
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
{{-- <style>
    .dropdown-toggle::after {
        display: none;
    }

    .dropdown-menu {
        min-width: 12rem;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
    }

    .dropdown-item i {
        width: 20px;
        margin-right: 8px;
        text-align: center;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }

    .table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .table td,
    .table th {
        padding: 0.75rem;
        vertical-align: middle;
        border-top: 1px solid #dee2e6;
    }

    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        border-radius: 0.25rem;
    }

    .text-muted {
        color: #6c757d !important;
    }
</style> --}}

@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dashboard Menu
        </div>
        <div class="container dasboard-container">

            <!-- Titre -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Utilisateurs</span>
                </div>
                @include('partials/hearder2')
            </div>

            <div class="dasboard-widget-box fl-wrap">
                <div class="custom-form">
                    <div class="row">
                        <div class="dasboard-widget-title fl-wrap"
                            style="display:flex;justify-content:space-between;align-items:center;">
                            <h5>Liste des utilisateurs</h5>
                            {{-- <a href="{{ route('hoost.users.create') }}" class="btn color-bg float-btn">
                                <i class="fas fa-plus"></i> Ajouter un utilisateur
                            </a> --}}
                        </div>
                    </div>

                    <div class="table-responsive mt-3">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="text-align:left; width:200px;">Nom & Prénom</th>
                                    <th style="text-align:left; width:200px;">Téléphone</th>
                                    <th style="text-align:left; width:200px;">Rôle</th>
                                    <th style="text-align:left; width:200px;">Email</th>
                                    <th style="text-align:left; width:200px;">Profession</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td style="text-align:left; width:200px;">
                                            {{ $user->nom }} {{ $user->prenom }}
                                        </td>
                                        <td style="text-align:left; width:200px;">
                                            {{ $user->telephone }}
                                        </td>
                                        <td style="text-align:left; width:200px;">
                                            @php
                                                $role = strtolower($user->role->libelle);
                                                $color = match ($role) {
                                                    'admin' => 'green',
                                                    'hote' => 'red',
                                                    'visiteur' => 'blue',
                                                    default => 'brown',
                                                };
                                            @endphp
                                            <span
                                                style="
                                                    background: {{ $color }};
                                                    color: white;
                                                    padding: 4px 10px;
                                                    border-radius: 6px;
                                                    font-size: 12px;
                                                    font-weight: bold;
                                                    text-transform: capitalize;
                                                ">
                                                {{ $user->role->libelle }}
                                            </span>
                                        </td>
                                        <td style="text-align:left; width:200px;">
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </td>
                                        <td style="text-align:left; width:200px;">
                                            {{ $user->profession }}
                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="vh-action-dropdown">
                                                <button type="button" class="vh-action-btn">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>

                                                <div class="vh-action-menu">
                                                    <a href="{{ route('hoost.users.edit', $user) }}" class="vh-action-item">
                                                        <i class="fa fa-edit me-2"></i> Modifier
                                                    </a>

                                                    <form action="{{ route('hoost.users.destroy', $user) }}" method="POST"
                                                        onsubmit="return confirm('Confirmer la suppression de cet utilisateur ?');">
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
                                        <td colspan="7" class="text-center">
                                            Aucun utilisateur enregistré pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
