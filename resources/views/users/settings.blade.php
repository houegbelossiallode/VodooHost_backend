@extends('layouts.app')
@section('section')
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ Auth::user()->getProfilePhotoUrlAttribute() }}" 
                             class="rounded-circle" 
                             width="100" 
                             alt="Photo de profil">
                        <h5 class="mt-3 mb-0">{{ Auth::user()->name }}</h5>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <a href="#profile" 
                           class="list-group-item list-group-item-action active" 
                           data-bs-toggle="tab">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                        <a href="#security" 
                           class="list-group-item list-group-item-action" 
                           data-bs-toggle="tab">
                            <i class="fas fa-lock me-2"></i> Sécurité
                        </a>
                        <a href="#notifications" 
                           class="list-group-item list-group-item-action" 
                           data-bs-toggle="tab">
                            <i class="fas fa-bell me-2"></i> Notifications
                        </a>
                        <a href="#payments" 
                           class="list-group-item list-group-item-action" 
                           data-bs-toggle="tab">
                            <i class="fas fa-credit-card me-2"></i> Paiements
                        </a>
                        <a href="#privacy" 
                           class="list-group-item list-group-item-action" 
                           data-bs-toggle="tab">
                            <i class="fas fa-shield-alt me-2"></i> Confidentialité
                        </a>
                        <a href="#language" 
                           class="list-group-item list-group-item-action" 
                           data-bs-toggle="tab">
                            <i class="fas fa-language me-2"></i> Langue
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="tab-content">
                        <!-- Onglet Profil -->
                        <div class="tab-pane fade show active" id="profile">
                            <h4 class="mb-4">Informations personnelles</h4>
                            <form action="{{ route('hoost.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nom complet</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="name" 
                                                   value="{{ old('name', $user->name) }}"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" 
                                                   class="form-control" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}"
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Téléphone</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="phone" 
                                                   value="{{ old('phone', $user->phone) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Ville</label>
                                            <input type="text" 
                                                   class="form-control" 
                                                   name="city" 
                                                   value="{{ old('city', $user->city) }}">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">À propos de moi</label>
                                    <textarea class="form-control" 
                                              name="bio" 
                                              rows="3">{{ old('bio', $user->bio) }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                            </form>
                        </div>
                        
                        <!-- Onglet Sécurité -->
                        <div class="tab-pane fade" id="security">
                            <h4 class="mb-4">Sécurité du compte</h4>
                            <form action="{{ route('hoost.user.security.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label class="form-label">Mot de passe actuel</label>
                                    <input type="password" 
                                           class="form-control" 
                                           name="current_password" 
                                           required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Nouveau mot de passe</label>
                                    <input type="password" 
                                           class="form-control" 
                                           name="password" 
                                           required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Confirmer le nouveau mot de passe</label>
                                    <input type="password" 
                                           class="form-control" 
                                           name="password_confirmation" 
                                           required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Mettre à jour le mot de passe</button>
                            </form>
                            
                            <hr class="my-4">
                            
                            <h5>Sessions actives</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        @foreach($sessions as $session)
                                            <tr>
                                                <td>
                                                    <div>
                                                        {{ $session->user_agent }}
                                                        <div class="text-muted small">
                                                            {{ $session->ip_address }} - 
                                                            {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-end">
                                                    @if($session->id === Session::getId())
                                                        <span class="badge bg-success">Cette session</span>
                                                    @else
                                                        <form action="{{ route('hoost.user.sessions.destroy', $session->id) }}" 
                                                              method="POST" 
                                                              class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger">
                                                                Déconnecter
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Autres onglets (à implémenter) -->
                        <div class="tab-pane fade" id="notifications">
                            <h4 class="mb-4">Préférences de notification</h4>
                            <p>Gérez comment vous recevez les notifications.</p>
                            <!-- Formulaire de notifications à implémenter -->
                        </div>
                        
                        <div class="tab-pane fade" id="payments">
                            <h4 class="mb-4">Méthodes de paiement</h4>
                            <p>Gérez vos méthodes de paiement enregistrées.</p>
                            <!-- Gestion des méthodes de paiement à implémenter -->
                        </div>
                        
                        <div class="tab-pane fade" id="privacy">
                            <h4 class="mb-4">Confidentialité</h4>
                            <p>Contrôlez votre confidentialité et vos données.</p>
                            <!-- Paramètres de confidentialité à implémenter -->
                        </div>
                        
                        <div class="tab-pane fade" id="language">
                            <h4 class="mb-4">Langue</h4>
                            <p>Sélectionnez votre langue préférée.</p>
                            <!-- Sélecteur de langue à implémenter -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<style>
    .list-group-item.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .tab-pane {
        padding: 1.5rem 0.5rem;
    }
</style>



<script>
    // Active l'onglet sauvegardé dans localStorage
    document.addEventListener('DOMContentLoaded', function() {
        // Récupère l'onglet actif depuis localStorage
        const activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            const tabTrigger = new bootstrap.Tab(document.querySelector(activeTab));
            tabTrigger.show();
        }

        // Sauvegarde l'onglet actif dans localStorage
        const tabList = [].slice.call(document.querySelectorAll('a[data-bs-toggle="tab"]'));
        tabList.forEach(function(tabEl) {
            tabEl.addEventListener('shown.bs.tab', function (event) {
                localStorage.setItem('activeTab', event.target.getAttribute('href'));
            });
        });
    });
</script>
