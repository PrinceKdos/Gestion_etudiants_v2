<?php
require_once 'db.php';

// Vérifier qu'un ID est fourni dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int) $_GET['id'];

// ===== TRAITEMENT DE LA MODIFICATION =====
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom        = trim($_POST['nom'] ?? '');
    $prenom     = trim($_POST['prenom'] ?? '');
    $filiere_id = (int) ($_POST['filiere_id'] ?? 0);

    // Vérification côté serveur
    if ($nom === '' || $prenom === '') {
        header("Location: update.php?id=$id&msg=erreur");
        exit;
    }

    // Mettre à jour avec une requête préparée
    $sql = "UPDATE etudiants SET nom = :nom, prenom = :prenom, filiere_id = :filiere_id WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nom'        => $nom,
        ':prenom'     => $prenom,
        ':filiere_id' => $filiere_id,
        ':id'         => $id
    ]);

    header('Location: index.php?msg=modif');
    exit;
}

// ===== AFFICHAGE DU FORMULAIRE PRÉ-REMPLI =====

// Récupérer l'étudiant à modifier
$stmt = $pdo->prepare("SELECT * FROM etudiants WHERE id = :id");
$stmt->execute([':id' => $id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

// Si l'étudiant n'existe pas, on redirige
if (!$etudiant) {
    header('Location: index.php');
    exit;
}

// Récupérer les filières pour la liste déroulante
$filieres = $pdo->query("SELECT * FROM filieres ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un étudiant</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <h1>🎓 Gestion des Étudiants</h1>
    <a href="index.php">← Retour à l'accueil</a>
</header>

<div class="container">
    <div class="card">
        <h2 class="section-title">Modifier un étudiant</h2>

        <form id="form-modification" action="update.php?id=<?= $id ?>" method="POST">

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom"
                       value="<?= htmlspecialchars($etudiant['nom']) ?>"
                       placeholder="Ex : Dupont">
                <span class="error-msg" id="erreur-nom"></span>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom"
                       value="<?= htmlspecialchars($etudiant['prenom']) ?>"
                       placeholder="Ex : Jean">
                <span class="error-msg" id="erreur-prenom"></span>
            </div>

            <div class="form-group">
                <label for="filiere_id">Filière</label>
                <select id="filiere_id" name="filiere_id">
                    <option value="">-- Choisir une filière --</option>
                    <?php foreach ($filieres as $f): ?>
                        <option value="<?= $f['id'] ?>"
                            <?= $f['id'] == $etudiant['filiere_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($f['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn btn-primary">✔ Enregistrer</button>
                <a href="index.php" class="btn btn-secondary">Annuler</a>
            </div>

        </form>
    </div>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
