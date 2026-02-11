            {{-- <div class="dashbard-menu-header">
                <div class="dashbard-menu-avatar fl-wrap">
                    <img src="{{ auth()->user()->photo}}" alt="">
                    <h4>Bienvenue, <span>{{ auth()->user()->nom ?? 'Utilisateur' }}</span></h4>
                </div>
                <a href="{{route('hoost.logout')}}" class="log-out-btn tolt" data-microtip-position="bottom" data-tooltip="Déconnexion">
                    <i class="far fa-power-off"></i>
                </a>
            </div> --}}

            @php
                $user = auth()->user();
                $photo = $user->photo;

                // Initiales à partir du nom + prénom
                $initials = strtoupper(substr($user->nom, 0, 1) . substr($user->prenom ?? '', 0, 1));

                // Avatar généré si pas de photo
                $avatar = "https://ui-avatars.com/api/?name={$initials}&background=D1B11B&color=fff&size=128&rounded=true";
            @endphp

            <div class="dashbard-menu-header">
                <div class="dashbard-menu-avatar fl-wrap">
                    <img src="{{ $photo ? $photo : $avatar }}" alt="Avatar utilisateur">
                    <h4>Bienvenue, <span>{{ $user->nom ?? 'Utilisateur' }}</span></h4>
                </div>

                <a href="{{ route('hoost.logout') }}" class="log-out-btn tolt" data-microtip-position="bottom"
                    data-tooltip="Déconnexion">
                    <i class="far fa-power-off"></i>
                </a>
            </div>
