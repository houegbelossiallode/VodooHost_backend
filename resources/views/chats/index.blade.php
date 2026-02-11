@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Messages</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-wrapper fl-wrap no-pag">
                <!-- dashboard-list-box-->
                <div class="dashboard-list-box fl-wrap">
                    <div class="dasboard-widget-title fl-wrap">
                        {{-- <h5><i class="fas fa-comment-alt"></i>Derniers Messages
                            @if (!empty($newMessagesCount) && $newMessagesCount > 0)
                                <span> ( +{{ $newMessagesCount }} New ) </span>
                            @endif
                        </h5> --}}
                        {{-- <a href="#" class="mark-btn  tolt" data-microtip-position="bottom"
                            data-tooltip="Mark all as read"><i class="far fa-comment-alt-check"></i> </a> --}}
                        <div class="dasboard-opt fl-wrap">
                            <div class="dasboard-opt sl-opt fl-wrap">
                                <form method="GET" action="{{ route('hoost.chats.index') }}">
                                    <div class="dashboard-search-listing">
                                        <input type="text" name="q" onclick="this.select()" style="height:53px;" id="chatMessageSearch"
                                            placeholder="Rechercher un message" value="{{ request('q') }}">
                                        <button type="submit"><i class="far fa-search"></i></button>
                                    </div>
                                    <!-- price-opt-->
                                    <div class="price-opt">
                                        <span class="price-opt-title">Trier par :</span>
                                        <div class="listsearch-input-item">
                                            <select name="sort" class="chosen-select no-search-select"
                                                onchange="this.form.submit()">
                                                <option value="all" {{ ($sort ?? '') === 'all' ? 'selected' : '' }}>
                                                    Tous les messages
                                                </option>
                                                <option value="hosts" {{ ($sort ?? '') === 'hosts' ? 'selected' : '' }}>
                                                    Messages hôtes
                                                </option>
                                                <option value="visitors"
                                                    {{ ($sort ?? '') === 'visitors' ? 'selected' : '' }}>
                                                    Messages visiteurs
                                                </option>
                                                <option value="translators"
                                                    {{ ($sort ?? '') === 'translators' ? 'selected' : '' }}>
                                                    Messages traducteurs
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chat-wrapper fl-wrap">

                <!-- chat-box-->
                <div class="chat-box fl-wrap">
                    <div class="chat-box-scroll fl-wrap full-height" data-simplebar="init">

                        @foreach ($messages as $message)
                            @php
                                // Initiales à partir du nom + prénom
                                $initials = strtoupper(
                                    substr($message->sender->nom, 0, 1) . substr($message->sender->prenom ?? '', 0, 1),
                                );
                                // Avatar généré si pas de photo
                                $avatar = "https://ui-avatars.com/api/?name={$initials}&background=D1B11B&color=fff&size=128&rounded=true";
                            @endphp
                            <div
                                class="chat-message {{ $message->sender_id == auth()->id() ? 'chat-message_user' : '' }} fl-wrap">
                                <div class="dashboard-message-avatar">
                                    <img src="{{ $message->sender->photo ?? $avatar }}" alt="">
                                    <span class="chat-message-user-name cmun_sm">
                                        {{ $message->sender->nom }}
                                    </span>
                                </div>

                                <span class="massage-date">{{ $message->created_at->format('d M Y H:i') }}</span>
                                <div class="message-content">
                                    <p class="message-text">{{ $message->message }}</p>
                                    @if ($message->sender_id == auth()->id())
                                        <div class="message-actions">
                                            {{-- <a href="#" class="edit-message" data-id="{{ $message->id }}" data-message="{{ $message->message }}" title="Modifier">
                                                <i class="far fa-edit"></i>
                                            </a> --}}
                                            <a href="#" class="edit-message" data-id="{{ $message->id }}"
                                                data-message="{{ $message->message }}"
                                                data-update-url="{{ route('hoost.chats.update', $message) }}"
                                                title="Modifier">
                                                <i class="far fa-edit" style="color:#D1B11B"></i>
                                            </a>
                                            {{-- <form action="{{ route('hoost.chats.delete', $message) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete-message-btn" title="Supprimer">
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form> --}}
                                            <form action="{{ route('hoost.chats.delete', $message) }}" method="POST"
                                                class="delete-form d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="delete-message-btn" title="Supprimer">
                                                    <i class="far fa-trash-alt" style="color:#D1B11B"></i>
                                                </button>
                                            </form>

                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endforeach

                    </div>
                </div>
                @if ($activeConversation)
                    <form method="POST" action="{{ route('hoost.chats.send', $activeConversation->id) }}">
                        @csrf
                        <div class="chat-widget_input">
                            <textarea name="message" placeholder="Tapez votre message..." required></textarea>
                            <button class="color-bg">
                                <i class="fal fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-muted pl-3">Sélectionnez une conversation pour envoyer un message.</p>
                @endif
                <!-- chat-box end-->
                <!-- chat-contacts-->
                <div class="chat-contacts">

                    @foreach ($conversations as $conversation)
                        @php
                            // Initiales à partir du nom + prénom
                            $initials = strtoupper(
                                substr($conversation->otherUser()?->nom, 0, 1) .
                                    substr($conversation->otherUser()?->prenom ?? '', 0, 1),
                            );
                            // Avatar généré si pas de photo
                            $avatar = "https://ui-avatars.com/api/?name={$initials}&background=D1B11B&color=fff&size=128&rounded=true";
                        @endphp
                        <a class="chat-contacts-item {{ $activeConversation && $activeConversation->id === $conversation->id ? 'chat-contacts-item_active' : '' }}"
                            href="{{ route('hoost.chats.show', ['conversation' => $conversation->id]) }}">
                            <div class="dashboard-message-avatar">
                                <img src="{{ $conversation->otherUser()?->photo ?? $avatar }}" alt="">
                                <div class="message-counter">2</div>
                            </div>
                            <div class="chat-contacts-item-text">
                                <h4>{{ $conversation->otherUser()?->nom }}</h4>
                                <span>{{ $conversation->lastMessage?->updated_at->format('d M Y') }}</span>
                                <p>{{ Str::limit($conversation->lastMessage->message ?? 'Aucun message', 35) }}</p>
                            </div>
                        </a>
                    @endforeach

                    <!-- chat-contacts-item -->
                </div>
                <!-- chat-contacts end-->
            </div>
            <!-- dashboard-list-box end-->
        </div>
    </div>



    <style>
        .message-content {
            position: relative;
            flex-grow: 1;
        }

        .message-actions {
            position: absolute;
            top: 5px;
            right: 10px;
            opacity: 0;
            transition: opacity 0.2s;
            display: flex;
            gap: 8px;
        }

        .chat-message:hover .message-actions {
            opacity: 1;
        }

        .message-actions a,
        .message-actions button {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #2d3436;
            transition: all 0.2s;
        }

        .message-actions a:hover,
        .message-actions button:hover {
            background: #D1B11B;
            color: white;
        }

        .edit-message-form {
            margin-top: 10px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }

        .form-buttons {
            margin-top: 8px;
            display: flex;
            gap: 8px;
        }

        .form-buttons button {
            padding: 4px 12px;
            font-size: 12px;
            border-radius: 3px;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #D1B11B;
            color: white;
        }

        .btn-secondary {
            background: #e1e1e1;
            color: #333;
        }
    </style>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('DOMContentLoaded', function() {
                const mainForm = document.querySelector('.chat-widget_input')?.closest('form');
                const chatInput = document.querySelector('textarea[name="message"]');
                const sendButton = document.querySelector('.chat-widget_input button');

                if (!mainForm || !chatInput || !sendButton) return;

                const originalAction = mainForm.action;
                const originalMethod = mainForm.method;
                const originalButtonHTML = sendButton.innerHTML;

                let editing = false;
                let currentUpdateUrl = null;
                let currentMessageElement = null;
                let currentEditButton = null;

                function resetEditMode() {
                    editing = false;
                    currentUpdateUrl = null;
                    currentMessageElement = null;
                    currentEditButton = null;
                    chatInput.value = '';
                    sendButton.innerHTML = originalButtonHTML;
                    sendButton.classList.remove('updating');
                    mainForm.action = originalAction;
                    mainForm.method = originalMethod;
                }

                // Clic sur "Modifier"
                document.querySelectorAll('.edit-message').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        const messageId = this.getAttribute('data-id');
                        const messageText = this.getAttribute('data-message');
                        const updateUrl = this.getAttribute('data-update-url');
                        const messageElement = this.closest('.chat-message');

                        editing = true;
                        currentUpdateUrl = updateUrl;
                        currentMessageElement = messageElement;
                        currentEditButton = this;

                        chatInput.value = messageText;
                        chatInput.focus();

                        sendButton.innerHTML = '<i class="fal fa-save"></i> Modifier';
                        sendButton.classList.add('updating');
                    });
                });

                // Soumission du formulaire principal
                mainForm.addEventListener('submit', function(e) {
                    if (!editing) {
                        // mode normal : on laisse l'envoi standard (création)
                        return;
                    }

                    // mode édition : on empêche la création et on fait un UPDATE AJAX
                    e.preventDefault();

                    const formData = new FormData();
                    formData.append('message', chatInput.value);
                    formData.append('_method', 'PUT');

                    fetch(currentUpdateUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body: formData,
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Erreur HTTP');
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Mettre à jour le texte dans la liste
                                currentMessageElement.querySelector('.message-text')
                                    .textContent = data.message;
                                currentEditButton.setAttribute('data-message', data.message);

                                resetEditMode();

                                // Optionnel : petit message flash
                                alert('Message mis à jour avec succès');
                            } else {
                                alert('Erreur lors de la mise à jour du message');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Une erreur est survenue');
                        });
                })

            })
            

        });
    </script> --}}


    <style>
        .chat-message {
            position: relative;
        }

        /* Conteneur des actions */
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

        /* Affichage au survol */
        .chat-message:hover .chat-message-actions {
            opacity: 1;
            pointer-events: auto;
        }

        /* Style des boutons */
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




    <script src="{{asset('chats.js')}}"></script>
@endsection
