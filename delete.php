<?php
require_once 'db.php';

// Vérifier qu'un ID valide est fourni dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

// Supprimer l'étudiant avec une requête préparée
$stmt = $pdo->prepare("DELETE FROM etudiants WHERE id = :id");
$stmt->execute([':id' => $id]);

// Rediriger vers la page principale avec un message de succès
header('Location: index.php?msg=suppr');
exit;
?>
