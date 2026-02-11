document.addEventListener('click', function (e) {
    const toggle = e.target.closest('.vh-action-btn');
    const dropdowns = document.querySelectorAll('.vh-action-dropdown');

    // Fermer tous les dropdowns si on clique ailleurs
    dropdowns.forEach(function (dd) {
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