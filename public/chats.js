
document.addEventListener('DOMContentLoaded', function () {
    // ==== ELEMENTS DU FORMULAIRE PRINCIPAL ====
    const chatForm = document.querySelector('.chat-widget_input')?.closest('form');
    const chatInput = document.querySelector('.chat-widget_input textarea[name="message"]');
    const sendButton = document.querySelector('.chat-widget_input button');

    if (!chatForm || !chatInput || !sendButton) {
        console.warn('Formulaire de chat non trouvé');
        return;
    }

    const originalAction = chatForm.action;
    const originalMethod = chatForm.method;
    const originalBtnHTML = sendButton.innerHTML;

    let isEditing = false;
    let currentUpdateUrl = null;
    let currentMessageBlock = null;
    let currentEditButton = null;

    //Remet le formulaire en mode "nouveau message"
    function resetEditMode() {
        isEditing = false;
        currentUpdateUrl = null;
        currentMessageBlock = null;
        currentEditButton = null;

        chatInput.value = '';
        sendButton.innerHTML = originalBtnHTML;
        sendButton.classList.remove('updating');

        chatForm.action = originalAction;
        chatForm.method = originalMethod;
    }

    // ==== CLICK SUR "MODIFIER" ====
    document.querySelectorAll('.edit-message').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const messageText = this.getAttribute('data-message');
            const updateUrl = this.getAttribute('data-update-url');
            const messageElem = this.closest('.chat-message');

            if (!updateUrl || !messageElem) {
                console.error('Impossible de trouver l’URL d’update ou le bloc message');
                return;
            }

            //Placer le texte dans le textarea du bas
            chatInput.value = messageText || '';
            chatInput.focus();

            //Passer en mode édition
            isEditing = true;
            currentUpdateUrl = updateUrl;
            currentMessageBlock = messageElem;
            currentEditButton = this;

            sendButton.innerHTML = '<i class="fal fa-save"></i> Modifier';
            sendButton.classList.add('updating');
        });
    });

    // ==== SUBMIT DU FORMULAIRE ====
    chatForm.addEventListener('submit', function (e) {
        // Mode "nouveau message" → on laisse Laravel gérer (création)
        if (!isEditing) {
            return;
        }

        // Mode "édition" → on intercepte pour faire un UPDATE
        e.preventDefault();

        if (!currentUpdateUrl) {
            console.error('Pas d’URL pour la mise à jour du message.');
            return;
        }

        const texte = chatInput.value.trim();
        if (!texte) {
            alert('Le message ne peut pas être vide.');
            return;
        }

        const formData = new FormData();
        formData.append('message', texte);
        formData.append('_method', 'PUT');

        fetch(currentUpdateUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData
        })
            .then(response => {
                if (!response.ok) throw new Error('Erreur HTTP ' + response.status);
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    //Mettre à jour le texte dans la liste
                    const textEl = currentMessageBlock.querySelector('.message-text');
                    if (textEl) {
                        textEl.textContent = data.message;
                    }

                    //Mettre à jour le data-message pour les prochaines éditions
                    if (currentEditButton) {
                        currentEditButton.setAttribute('data-message', data.message);
                    }
                    resetEditMode();
                    // Petit feedback utilisateur
                    Swal.fire({
                        icon: 'success',
                        title: 'Message mis à jour',
                        text: 'Votre message a été mis à jour avec succès.',
                        timer: 2000,
                        showConfirmButton: true
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        text: 'Erreur lors de la mise à jour du message'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                alert('Une erreur est survenue lors de la mise à jour du message.');
            });
    });

    // ==== ANNULER AVEC ESC ====
    chatInput.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isEditing) {
            resetEditMode();
        }
    });

    // === le reste de ton script (recherche, suppression, etc.) peut rester en dessous ===
    // Suppression d'un message
    /** document.querySelectorAll('.delete-message-btn').forEach(button => {
         button.addEventListener('click', function(e) {
             if (!confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
                 e.preventDefault();
             }
         });
     }); ***/


    // ==== SUPPRESSION D'UN MESSAGE AVEC SWEETALERT ====
    document.querySelectorAll('.delete-message-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const form = this.closest('form');
            const url = form.action;
            const messageBloc = this.closest('.chat-message');

            Swal.fire({
                title: 'Supprimer ce message ?',
                text: "Cette action est irréversible.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                // Appel AJAX vers ta route destroy()
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector(
                            'meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({
                        '_method': 'DELETE'
                    })
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur HTTP ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Retirer le message du DOM
                            if (messageBloc) {
                                messageBloc.remove();
                            }

                            // SweetAlert de succès
                            Swal.fire({
                                icon: 'success',
                                title: 'Message supprimé',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erreur',
                                text: data.message ||
                                    'Impossible de supprimer ce message.'
                            });
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Erreur',
                            text: 'Une erreur est survenue lors de la suppression.'
                        });
                    });
            });
        });
    });


    const input = document.getElementById('chatMessageSearch');

    if (!input) return;

    // Recherche dynamique
    input.addEventListener('keyup', function () {
        filterMessages();
        filterConversations();
    });

    // Filtrer les messages au milieu
    function filterMessages() {
        const query = input.value.toLowerCase().trim();
        const messages = document.querySelectorAll('.chat-message');

        messages.forEach(function (msg) {
            const nameEl = msg.querySelector('.chat-message-user-name');
            const textEl = msg.querySelector('p');

            const name = nameEl ? nameEl.textContent.toLowerCase() : '';
            const texte = textEl ? textEl.textContent.toLowerCase() : '';

            // Match si le nom OU le contenu contient la recherche
            const match = !query || name.includes(query) || texte.includes(query);

            msg.style.display = match ? '' : 'none';
        });
    }

    // Filtrer les conversations à droite
    function filterConversations() {
        const query = input.value.toLowerCase().trim();
        const items = document.querySelectorAll('.chat-contacts-item');

        items.forEach(function (item) {
            const nameEl = item.querySelector('h4');
            const msgEl = item.querySelector('p');

            const name = nameEl ? nameEl.textContent.toLowerCase() : '';
            const texte = msgEl ? msgEl.textContent.toLowerCase() : '';

            const match = !query || name.includes(query) || texte.includes(query);

            item.style.display = match ? '' : 'none';
        });
    }

});