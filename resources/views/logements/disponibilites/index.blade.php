@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Tableau de bord
        </div>
        <div class="container dasboard-container">
            <!-- Titre dashboard -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Calendrier {{ $logement->titre }}</span>
                </div>
                @include('partials/hearder2')
            </div>
            <!-- Titre dashboard end -->
    
            <div class="mb-3 d-flex align-items-center justify-content-center gap-4 flex-wrap">
            <!-- Type de période -->
            <div class="d-flex align-items-center gap-3">
                {{-- <span class="label-type"><strong>Type de période à créer :</strong></span> --}}

                <div class="listsearch-input-item dispo-type-wrapper">
                    <select id="dispoType" class="chosen-select on-radius no-search-select">
                        <option value="disponible">Disponible (jaune)</option>
                        <option value="indisponible">Indisponible (violet)</option>
                    </select>
                </div>
            </div>

            <!-- Légende -->
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span><strong>Légende :</strong></span>
                <span class="badge" style="background: #D1B11B;">Disponible</span>
                <span class="badge" style="background: #E892E0;">Indisponible</span>
                <span class="badge" style="background: #F0BC75;">Réservé</span>
            </div>
       
            <div id="logement-calendar"></div>

        </div>
    </div>


    {{-- FullCalendar CSS & JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('logement-calendar');
            const storeUrl = @json(route('hoost.logements.disponibilites.store', $logement));
            const deleteBaseUrl = @json(route('hoost.logements.disponibilites.destroy', [$logement, 0]));
            const csrfToken = @json(csrf_token());
            const initialEvents = @json($events);
            const typeSelect = document.getElementById('dispoType');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                firstDay: 1,
                height: 'auto',
                selectable: true, // <== on permet la sélection
                selectMirror: true,
                selectOverlap: true,
                events: initialEvents,


                //Ici on désactive carrément le clic sur les périodes réservées
                eventDidMount: function(info) {
                    const statut = info.event.extendedProps.statut;

                    if (statut === 'reserver') {
                        // On désactive les clics
                        info.el.style.pointerEvents = 'none';
                        // Optionnel : style un peu différent
                        info.el.style.opacity = '0.95';
                        info.el.style.border = '1px solid #F0BC75';
                    }
                },

                // Quand l'hôte sélectionne une plage sur le calendrier
                select: function(info) {
                    // info.startStr (inclus), info.endStr (exclus)
                    const start = info.startStr;

                    // end est exclusif → on enlève un jour pour la date_fin réelle
                    const endDate = new Date(info.endStr);
                    endDate.setDate(endDate.getDate() - 1);
                    const end = endDate.toISOString().slice(0, 10);

                    const statut = typeSelect.value;
                    const label =
                        statut === 'disponible' ?
                        'Disponible (jaune)' :
                        'Indisponible (violet)';


                    if (!confirm(`Ajouter une période "${statut}" du ${start} au ${end} ?`)) {
                        calendar.unselect();
                        return;
                    }

                    fetch(storeUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                date_debut: start,
                                date_fin: end,
                                statut: statut,
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.event) {
                                // On ajoute l'événement sur le calendrier sans recharger la page
                                calendar.addEvent(data.event);
                                Swal.fire({
                                    title: 'Succès',
                                    text: 'La période a été créée avec succès.',
                                    icon: 'success',
                                    confirmButtonColor: '#D1B11B'
                                });

                            } else {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: data.message || 'Impossible de créer la période.',
                                    icon: 'error'
                                });
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Erreur réseau.');
                        })
                        .finally(() => {
                            calendar.unselect();
                        });
                },


                //Suppression d'une disponibilité / indispo au clic
                eventClick: function(info) {
                    const ev = info.event;
                    const statut = ev.extendedProps.statut || null;

                    // Sécurité supplémentaire : au cas où
                    if (statut === 'reserver') {
                        // Normalement, on ne passera jamais ici grâce à pointer-events:none
                        return;
                    }

                    // On ne supprime que les dispos/indispos (id = dispo-XX)
                    if (!ev.id || !ev.id.startsWith('dispo-')) {
                        return;
                    }

                    const dispoId = ev.id.replace('dispo-', '');

                    Swal.fire({
                        title: 'Supprimer cette période ?',
                        text: 'Voulez-vous vraiment supprimer cette période de disponibilité / indisponibilité ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#D1B11B',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (!result.isConfirmed) {
                            return;
                        }

                        const deleteUrl = deleteBaseUrl.replace(/0$/, dispoId);

                        fetch(deleteUrl, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'Accept': 'application/json',
                                },
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    ev.remove();
                                    Swal.fire({
                                        title: 'Supprimé',
                                        text: 'La période a bien été supprimée.',
                                        icon: 'success',
                                        confirmButtonColor: '#D1B11B'
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Erreur',
                                        text: data.message ||
                                            "Impossible de supprimer cette période.",
                                        icon: 'error'
                                    });
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                Swal.fire({
                                    title: 'Erreur réseau',
                                    text: 'Une erreur est survenue lors de la suppression.',
                                    icon: 'error'
                                });
                            });
                    });
                },



                // Empêcher de déplacer les events réservés si un jour tu actives drag & drop
                eventAllow: function(dropInfo, draggedEvent) {
                    if (draggedEvent.id && draggedEvent.id.startsWith('resa-')) {
                        return false; // on bloque le drag des réservations
                    }
                    return true;
                },
            });

            calendar.render();
        });
    </script>

    <style>
/* Wrapper du select de type de période */
.dispo-type-wrapper {
    width: auto;
}

/* Si Chosen est activé, c'est le container qui prend la largeur */
.dispo-type-wrapper .chosen-container {
    min-width: 200px;
    max-width: 260px;
    width: auto !important;
}

/* Si jamais Chosen n'est pas initialisé, on réduit aussi le <select> natif */
.dispo-type-wrapper select {
    width: auto;
    min-width: 200px;
}

    </style>
@endsection
