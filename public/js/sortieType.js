document.addEventListener('DOMContentLoaded', function() {
    const lieuField = document.querySelector('#sortie_lieu'); // Utilisez l'ID du champ Lieu de votre formulaire
    const villeField = document.querySelector('#sortie_ville'); // Utilisez l'ID du champ Ville de votre formulaire
    const rueField = document.querySelector('#sortie_rue'); // Utilisez l'ID du champ Rue de votre formulaire
    const codePostalField = document.querySelector('#sortie_code_postal'); // Utilisez l'ID du champ Code Postal de votre formulaire
    const latitudeField = document.querySelector('#sortie_latitude'); // Utilisez l'ID du champ Latitude de votre formulaire
    const longitudeField = document.querySelector('#sortie_longitude'); // Utilisez l'ID du champ Longitude de votre formulaire

    lieuField.addEventListener('change', function() {
        if (lieuField.value !== '') {
            villeField.removeAttribute('disabled');
            rueField.removeAttribute('disabled');
            codePostalField.removeAttribute('disabled');
            latitudeField.removeAttribute('disabled');
            longitudeField.removeAttribute('disabled');
        } else {
            villeField.setAttribute('disabled', 'disabled');
            rueField.setAttribute('disabled', 'disabled');
            codePostalField.setAttribute('disabled', 'disabled');
            latitudeField.setAttribute('disabled', 'disabled');
            longitudeField.setAttribute('disabled', 'disabled');
        }
    });
});
