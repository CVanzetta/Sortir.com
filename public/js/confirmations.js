
    const confirmationLinks = document.querySelectorAll('.confirmation-link');
    confirmationLinks.forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        const sortieId = link.getAttribute('data-sortie-id');
        const confirmation = window.confirm('Voulez-vous vraiment vous inscrire à cette sortie ?');

        if (confirmation) {
            window.location.href = link.href; // Redirige si la confirmation est acceptée
        }
    });
});