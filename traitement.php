<?php
require_once 'db.php';

// Vérifier que la requête vient bien du formulaire (méthode POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Récupérer et nettoyer les données reçues
$nom       = trim($_POST['nom'] ?? '');
$prenom    = trim($_POST['prenom'] ?? '');
$filiere_id = (int) ($_POST['filiere_id'] ?? 0);

// Vérification côté serveur (sécurité en plus du JS)
if ($nom === '' || $prenom === '') {
    header('Location: index.php?msg=erreur');
    exit;
}

// Insérer dans la base avec une requête préparée (sécurisée)
$sql = "INSERT INTO etudiants (nom, prenom, filiere_id) VALUES (:nom, :prenom, :filiere_id)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nom'       => $nom,
    ':prenom'    => $prenom,
    ':filiere_id' => $filiere_id
]);

// Rediriger vers la page principale avec un message de succès
header('Location: index.php?msg=ajout');
exit;
?>
