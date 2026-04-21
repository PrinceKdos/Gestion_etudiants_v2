// ===== VALIDATION DU FORMULAIRE =====

function validerFormulaire(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    form.addEventListener('submit', function (e) {
        let valide = true;

        // Récupérer les champs
        const nom = document.getElementById('nom');
        const prenom = document.getElementById('prenom');

        // Réinitialiser les erreurs
        supprimerErreurs();

        // Vérifier le nom
        if (!nom || nom.value.trim() === '') {
            afficherErreur(nom, 'erreur-nom', 'Le nom est obligatoire.');
            valide = false;
        }

        // Vérifier le prénom
        if (!prenom || prenom.value.trim() === '') {
            afficherErreur(prenom, 'erreur-prenom', 'Le prénom est obligatoire.');
            valide = false;
        }

        // Bloquer l'envoi si invalide
        if (!valide) {
            e.preventDefault();
        }
    });
}

function afficherErreur(champ, idMsg, message) {
    if (champ) champ.classList.add('error');
    const msgEl = document.getElementById(idMsg);
    if (msgEl) {
        msgEl.textContent = message;
        msgEl.style.display = 'block';
    }
}

function supprimerErreurs() {
    // Retirer la classe error de tous les champs
    document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));
    // Cacher tous les messages d'erreur
    document.querySelectorAll('.error-msg').forEach(el => {
        el.style.display = 'none';
        el.textContent = '';
    });
}

// ===== CONFIRMATION DE SUPPRESSION =====

function confirmerSuppression(lien) {
    const confirmation = confirm('Voulez-vous vraiment supprimer cet étudiant ? Cette action est irréversible.');
    if (!confirmation) {
        // Annuler la navigation
        return false;
    }
    return true;
}

// ===== INITIALISATION =====
document.addEventListener('DOMContentLoaded', function () {
    // Valider le formulaire d'ajout (index.php)
    validerFormulaire('form-ajout');

    // Valider le formulaire de modification (update.php)
    validerFormulaire('form-modification');
});
