@extends('layouts.app')

@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Tableau de bord
        </div>

        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Notifications</span>
                    {{-- @if ($unreadCount > 0)
                        <span class="notification-count">
                            (+{{ $unreadCount }} nouvelle{{ $unreadCount > 1 ? 's' : '' }})
                        </span>
                    @endif --}}
                </div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->

            <div class="dasboard-wrapper fl-wrap no-pag">
                <div class="dasboard-opt fl-wrap">
                    <div class="dasboard-opt sl-opt fl-wrap">
                        <form method="GET" action="{{ route('hoost.notifications.index') }}">
                            <div class="dashboard-search-listing">
                                <input type="text" name="q" onclick="this.select()" id="chatMessageSearch"
                                    placeholder="Rechercher une notification" value="{{ request('q') }}">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </div>
                            <!-- price-opt-->
                            <div class="price-opt">
                                <span class="price-opt-title">Trier par :</span>
                                <div class="listsearch-input-item">
                                    <select name="sort" class="chosen-select no-search-select"
                                        onchange="this.form.submit()">
                                        <option value="all" {{ request('sort') === 'all' ? 'selected' : '' }}>
                                            Toutes les notifications
                                        </option>
                                        {{-- <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Non
                                            lues</option>
                                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Déjà
                                            lues</option> --}}
                                        <option value="reservation"
                                            {{ request('sort') === 'reservation' ? 'selected' : '' }}>
                                            Réservations
                                        </option>
                                        {{-- <option value="rappel" {{ request('sort') === 'rappel' ? 'selected' : '' }}>
                                            Rappels
                                        </option> --}}
                                        <option value="message" {{ request('sort') === 'message' ? 'selected' : '' }}>
                                            Messages
                                        </option>
                                        {{-- <option value="disponibilite" {{ request('sort') === 'disponibilite' ? 'selected' : '' }}>
                                            Disponibilités
                                        </option> --}}
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- dashboard-list-box-->
                <div class="dashboard-list-box fl-wrap">
                    <div class="dasboard-widget-title fl-wrap">
                        <h5>
                            <i class="fas fa-bell"></i>
                            Mes notifications
                            @if ($unreadCount > 0)
                                <span> ( +{{ $unreadCount }} non lue{{ $unreadCount > 1 ? 's' : '' }} ) </span>
                            @endif
                        </h5>


                        @if ($unreadCount > 0)
                            <button id="mark-all-read" class="mark-btn tolt" data-microtip-position="bottom"
                                data-tooltip="Tout marquer comme lu">
                                <i class="far fa-check-circle"></i>
                            </button>
                        @endif
                    </div>


                    <!-- chat-contacts-->
                    <div class="chat-contacts">
                        @foreach ($notifications as $notification)
                            @php
                                $isUnread = is_null($notification->read_at);
                                $data = $notification->data ?? [];
                                $title = $data['title'] ?? 'Nouvelle notification';
                                $message = $data['message'] ?? '';
                                $url = $notification->url ?? '#';
                                $type = class_basename($notification->type);
                            @endphp

                            <a class="chat-contacts-item {{ $isUnread ? 'chat-contacts-item_active' : '' }}"
                                href="{{ $url }}" data-notification-id="{{ $notification->id }}">
                                <div class="dashboard-message-avatar notif-avatar">
                                    {{-- Ici, on remplace les images par des icônes --}}
                                    @switch($type)
                                        @case('disponibilite')
                                            <i class="fas fa-calendar-check"></i>
                                        @break

                                        @case('message')
                                            <i class="fas fa-envelope"></i>
                                        @break

                                        @case('rappel')
                                            <i class="fas fa-bell"></i>
                                        @break

                                        @case('reservation')
                                            <i class="fas fa-calendar-check"></i>
                                        @break

                                        @default
                                            <i class="fas fa-bell"></i>
                                    @endswitch

                                    @if ($isUnread)
                                        <div class="message-counter">!</div>
                                    @endif
                                </div>

                                <div class="chat-contacts-item-text">
                                    <h4>
                                        {{ $notification->title }}
                                        {{-- @if ($isUnread)
                                                <span class="new-notification">Nouveau</span>
                                            @endif --}}
                                    </h4>
                                    <span>
                                        {{ $notification->created_at->format('d M Y') }}
                                        • {{ $notification->created_at->format('H:i') }}
                                    </span>
                                    @if ($notification->message)
                                        <p>{{ $notification->message }}</p>
                                    @endif

                                    {{-- Bouton "Laisser un avis" pour les notifs d’avis --}}
                                    @if ($url && \Illuminate\Support\Str::contains($url, 'avis'))
                                        <div class="notif-actions">
                                            <span class="btn color-bg btn-sm notif-review-btn" style="color:white;">
                                                <i class="fal fa-comment-dots"></i> Laisser un avis
                                            </span>
                                        </div>
                                    @endif


                                </div>
                            </a>
                        @endforeach
                    </div>
                    <!-- chat-contacts end-->


                    @if ($notifications->hasPages())
                        <div class="pagination">
                            {{-- Précédent --}}
                            @if ($notifications->onFirstPage())
                                <a href="javascript:void(0)" class="prevposts-link disabled">
                                    <i class="fa fa-caret-left"></i>
                                </a>
                            @else
                                <a href="{{ $notifications->previousPageUrl() }}" class="prevposts-link">
                                    <i class="fa fa-caret-left"></i>
                                </a>
                            @endif

                            {{-- Pages --}}
                            @for ($page = 1; $page <= $notifications->lastPage(); $page++)
                                @if ($page == $notifications->currentPage())
                                    {{-- Page active : même structure que le template --}}
                                    <a href="{{ $notifications->url($page) }}" class="current-page">
                                        {{ $page }}
                                    </a>
                                @else
                                    <a href="{{ $notifications->url($page) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endfor

                            {{-- Suivant --}}
                            @if ($notifications->hasMorePages())
                                <a href="{{ $notifications->nextPageUrl() }}" class="nextposts-link">
                                    <i class="fa fa-caret-right"></i>
                                </a>
                            @else
                                <a href="javascript:void(0)" class="nextposts-link disabled">
                                    <i class="fa fa-caret-right"></i>
                                </a>
                            @endif
                        </div>
                    @endif



                </div>
                <!-- dashboard-list-box end-->
            </div>
        </div>
        <!-- content end-->
    </div>

    <style>
        .notification-count {
            color: #ff5a5f;
            font-weight: 600;
            margin-left: 6px;
            font-size: 13px;
        }

        /* Avatar dans le style du template mais adapté aux icônes */
        .notif-avatar {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4ff;
            border-radius: 50%;
        }

        .notif-avatar i {
            font-size: 18px;
            color: #D1B11B;
        }

        /* Badge non lu */
        .message-counter {
            position: absolute;
            right: -4px;
            top: -4px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 999px;
            background: #ff5a5f;
            color: #fff;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .chat-contacts-item.chat-contacts-item_active {
            background: #f8f9ff;
            border-left: 3px solid #D1B11B;
        }

        .new-notification {
            background: #ff5a5f;
            color: #fff;
            font-size: 9px;
            padding: 2px 6px;
            border-radius: 999px;
            margin-left: 6px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .dashboard-list-null {
            text-align: center;
            padding: 50px 20px;
        }

        .dashboard-list-null i {
            font-size: 50px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .dashboard-list-null h4 {
            font-size: 18px;
            color: #444;
            margin-bottom: 10px;
        }

        .dashboard-list-null p {
            color: #999;
            font-size: 14px;
        }


        .notif-actions {
            margin-top: 8px;
        }

        .notif-review-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            font-size: 12px;
            border-radius: 999px;
            cursor: pointer;
        }

        .notif-review-btn i {
            font-size: 12px;
        }
    </style>


    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Marquer une notification comme lue au clic sur l'item
            document.querySelectorAll('.chat-contacts-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault(); // on gère la redirection nous-mêmes

                    const id = this.dataset.notificationId;
                    const targetUrl = this.getAttribute('href') || '#';

                    if (!id) {
                        // Si jamais pas d'ID, on redirige normalement
                        if (targetUrl && targetUrl !== '#') {
                            window.location.href = targetUrl;
                        }
                        return;
                    }

                    fetch(`{{ url('hoost/notifications') }}/${id}/read`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                                "Accept": "application/json"
                            }
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Succès',
                                    text: 'Notification marquée comme lue.',
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    if (targetUrl && targetUrl !== '#') {
                                        window.location.href = targetUrl;
                                    } else {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: data.message ||
                                        'Impossible de marquer la notification comme lue.',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(() => {
                            Swal.fire({
                                title: 'Erreur',
                                text: 'Une erreur est survenue.',
                                icon: 'error'
                            });
                        });
                });
            });

            // Marquer TOUTES les notifications comme lues
            const markAllBtn = document.getElementById('mark-all-read');
            if (markAllBtn) {
                markAllBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    fetch(`{{ route('hoost.notifications.readAll') }}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                                "Accept": "application/json"
                            }
                        })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Succès',
                                    text: 'Toutes les notifications ont été marquées comme lues.',
                                    icon: 'success',
                                    confirmButtonColor: '#28a745',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: data.message ||
                                        'Impossible de marquer les notifications comme lues.',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(() => {
                            Swal.fire({
                                title: 'Erreur',
                                text: 'Une erreur est survenue.',
                                icon: 'error'
                            });
                        });
                });
            }

        });
    </script>



@endsection
