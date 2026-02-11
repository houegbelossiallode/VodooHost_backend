{{-- resources/views/chats/index-admin.blade.php --}}
@extends('layouts.app')

@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dasboard Menu
        </div>

        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Messages (Admin)</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->

            <div class="dasboard-wrapper fl-wrap no-pag">
                <!-- dashboard-list-box-->
                <div class="dashboard-list-box fl-wrap">
                    <div class="dasboard-widget-title fl-wrap">
                        <h5>
                            {{-- <i class="fas fa-comment-alt"></i>Derniers Messages
                            @if (!empty($newMessagesCount) && $newMessagesCount > 0)
                                <span> ( +{{ $newMessagesCount }} New ) </span>
                            @endif --}}
                        </h5>

                        <div class="dasboard-opt fl-wrap">
                            <div class="dasboard-opt sl-opt fl-wrap">
                                <form method="GET" action="{{ route('hoost.admin.chats.index') }}">
                                    <div class="dashboard-search-listing">
                                        <input type="text"
                                               name="q"
                                               onclick="this.select()"
                                               id="chatMessageSearch"
                                               placeholder="Rechercher un message"
                                               value="{{ request('q') }}">
                                        <button type="submit"><i class="far fa-search"></i></button>
                                    </div>
                                    <!-- price-opt-->
                                    {{-- <div class="price-opt">
                                        <span class="price-opt-title">Trier par :</span>
                                        <div class="listsearch-input-item">
                                            <select name="sort"
                                                    class="chosen-select no-search-select"
                                                    onchange="this.form.submit()">
                                                <option value="all" {{ ($sort ?? '') === 'all' ? 'selected' : '' }}>
                                                    Tous les messages
                                                </option>
                                                <option value="hosts" {{ ($sort ?? '') === 'hosts' ? 'selected' : '' }}>
                                                    Messages hôtes
                                                </option>
                                                <option value="visitors" {{ ($sort ?? '') === 'visitors' ? 'selected' : '' }}>
                                                    Messages visiteurs
                                                </option>
                                                <option value="translators" {{ ($sort ?? '') === 'translators' ? 'selected' : '' }}>
                                                    Messages traducteurs
                                                </option>
                                            </select>
                                        </div>
                                    </div> --}}
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- dashboard-list-box end -->
            </div>

            <div class="chat-wrapper fl-wrap">

                <!-- chat-box-->
                <div class="chat-box fl-wrap">
                    <div class="chat-box-scroll fl-wrap full-height" data-simplebar="init">

                        @foreach ($messages as $message)
                            @php
                                $initials = strtoupper(
                                    substr($message->sender->nom ?? '', 0, 1)
                                    . substr($message->sender->prenom ?? '', 0, 1)
                                );
                                $avatar = "https://ui-avatars.com/api/?name={$initials}&background=D1B11B&color=fff&size=128&rounded=true";
                            @endphp

                            <div class="chat-message {{ $message->sender_id == auth()->id() ? 'chat-message_user' : '' }} fl-wrap">
                                <div class="dashboard-message-avatar">
                                    <img src="{{ $message->sender->photo ?? $avatar }}" alt="">
                                    <span class="chat-message-user-name cmun_sm">
                                        {{ $message->sender->nom }}
                                    </span>
                                </div>

                                <span class="massage-date">
                                    {{ $message->created_at->format('d M Y H:i') }}
                                </span>

                                <p>{{ $message->message }}</p>

                                {{-- Admin : peut supprimer tous les messages, 
                                     et l’auteur peut aussi supprimer les siens --}}
                                {{-- @if(auth()->id() === $message->sender_id || auth()->user()->role_id == \App\Http\Controllers\ChatController::ROLE_ADMIN)
                                    <div class="chat-message-actions">
                                         
                                        <button type="button"
                                                class="edit-message-btn"
                                                data-id="{{ $message->id }}"
                                                data-text="{{ e($message->message) }}">
                                            <i class="fal fa-edit"></i>
                                        </button>

                                        
                                        <form action="{{ route('admin.messages.destroy', $message->id) }}"
                                              method="POST"
                                              style="display:inline-block"
                                              onsubmit="return confirm('Supprimer ce message ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-message-btn">
                                                <i class="fal fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif --}}
                            </div>
                        @endforeach

                    </div>
                </div>
                <!-- chat-box end-->

                {{-- @if ($activeConversation)
                    <form method="POST" action="{{ route('admin.chats.send', $activeConversation->id) }}">
                        @csrf
                        <div class="chat-widget_input">
                            <textarea name="message" placeholder="Tapez votre message..." required></textarea>
                            <button class="color-bg">
                                <i class="fal fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-muted pl-3">
                        Sélectionnez une conversation pour envoyer un message.
                    </p>
                @endif --}}

                <!-- chat-contacts-->
                <div class="chat-contacts">
                    @foreach ($conversations as $conversation)
                        @php
                            $other = $conversation->otherUser();
                            $initials = strtoupper(
                                substr($other->nom ?? '', 0, 1)
                                . substr($other->prenom ?? '', 0, 1)
                            );
                            $avatar = "https://ui-avatars.com/api/?name={$initials}&background=D1B11B&color=fff&size=128&rounded=true";

                            // si tu ajoutes un champ unread_count plus tard :
                            $unreadCount = $conversation->unread_count ?? null;
                        @endphp

                        <a class="chat-contacts-item {{ $activeConversation && $activeConversation->id === $conversation->id ? 'chat-contacts-item_active' : '' }}"
                           href="{{ route('hoost.admin.chats.show', ['conversation' => $conversation->id]) }}">
                            <div class="dashboard-message-avatar">
                                <img src="{{ $other->photo ?? $avatar }}" alt="">
                                @if($unreadCount && $unreadCount > 0)
                                    <div class="message-counter">{{ $unreadCount }}</div>
                                @endif
                            </div>
                            <div class="chat-contacts-item-text">
                                <h4>{{ $other->nom ?? 'Utilisateur' }}</h4>
                                <span>
                                    {{ optional($conversation->lastMessage?->updated_at)->format('d M Y') }}
                                </span>
                                <p>
                                    {{ \Illuminate\Support\Str::limit($conversation->lastMessage->message ?? 'Aucun message', 35) }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
                <!-- chat-contacts end-->

            </div>
            <!-- dashboard-list-box end-->
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('chatMessageSearch');
            if (!input) return;

            input.addEventListener('keyup', function() {
                filterMessages();
                filterConversations();
            });

            function filterMessages() {
                const query = input.value.toLowerCase().trim();
                const messages = document.querySelectorAll('.chat-message');

                messages.forEach(function(msg) {
                    const nameEl = msg.querySelector('.chat-message-user-name');
                    const textEl = msg.querySelector('p');

                    const name = nameEl ? nameEl.textContent.toLowerCase() : '';
                    const texte = textEl ? textEl.textContent.toLowerCase() : '';

                    const match = !query || name.includes(query) || texte.includes(query);
                    msg.style.display = match ? '' : 'none';
                });
            }

            function filterConversations() {
                const query = input.value.toLowerCase().trim();
                const items = document.querySelectorAll('.chat-contacts-item');

                items.forEach(function(item) {
                    const nameEl = item.querySelector('h4');
                    const msgEl = item.querySelector('p');

                    const name = nameEl ? nameEl.textContent.toLowerCase() : '';
                    const texte = msgEl ? msgEl.textContent.toLowerCase() : '';

                    const match = !query || name.includes(query) || texte.includes(query);
                    item.style.display = match ? '' : 'none';
                });
            }
        });
    </script>

    <style>
        .chat-message {
            position: relative;
        }

        .chat-message-actions {
            position: absolute;
            top: 6px;
            right: 10px;
            display: flex;
            gap: 6px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease-in-out;
        }

        .chat-message:hover .chat-message-actions {
            opacity: 1;
            pointer-events: auto;
        }

        .chat-message-actions button {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 4px 6px;
            font-size: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
        }

        .chat-message-actions button i {
            color: #444;
        }

        .chat-message-actions button:hover i {
            color: #000;
        }
    </style>
@endsection
