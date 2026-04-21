<?php
require_once 'db.php';

// Récupérer le message de session si présent
$message = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'ajout') {
        $message = '<div class="alert alert-success">✔ Étudiant ajouté avec succès.</div>';
    } elseif ($_GET['msg'] === 'modif') {
        $message = '<div class="alert alert-success">✔ Étudiant modifié avec succès.</div>';
    } elseif ($_GET['msg'] === 'suppr') {
        $message = '<div class="alert alert-success">✔ Étudiant supprimé avec succès.</div>';
    }
}

// Récupérer les filières pour la liste déroulante
$filieres = $pdo->query("SELECT * FROM filieres ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer tous les étudiants avec leur filière (jointure)
$etudiants = $pdo->query("
    SELECT e.id, e.nom, e.prenom, f.nom AS filiere
    FROM etudiants e
    JOIN filieres f ON e.filiere_id = f.id
    ORDER BY e.nom, e.prenom
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants</title>
    <link rel="stylesheet" href="assests/css/style.css">
</head>
<body>

<header>
    <h1>🎓 Gestion des Étudiants</h1>
    <span>UATM GASA FORMATION</span>
</header>

<div class="container">

    <?= $message ?>

    <!-- ===== FORMULAIRE D'AJOUT ===== -->
    <div class="card">
        <h2 class="section-title">Ajouter un étudiant</h2>

        <form id="form-ajout" action="traitement.php" method="POST">

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" placeholder="Ex : Dupont">
                <span class="error-msg" id="erreur-nom"></span>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" id="prenom" name="prenom" placeholder="Ex : Jean">
                <span class="error-msg" id="erreur-prenom"></span>
            </div>

            <div class="form-group">
                <label for="filiere_id">Filière</label>
                <select id="filiere_id" name="filiere_id">
                    <option value="">-- Choisir une filière --</option>
                    <?php foreach ($filieres as $f): ?>
                        <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>

        </form>
    </div>

    <!-- ===== TABLEAU DES ÉTUDIANTS ===== -->
    <div class="card">
        <h2 class="section-title">Liste des étudiants (<?= count($etudiants) ?>)</h2>

        <?php if (count($etudiants) === 0): ?>
            <div class="empty-state">Aucun étudiant enregistré pour le moment.</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Filière</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($etudiants as $i => $etudiant): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                            <td><?= htmlspecialchars($etudiant['prenom']) ?></td>
                            <td><?= htmlspecialchars($etudiant['filiere']) ?></td>
                            <td>
                                <div class="actions">
                                    <a href="update.php?id=<?= $etudiant['id'] ?>" class="btn btn-warning">✏ Modifier</a>
                                    <a href="delete.php?id=<?= $etudiant['id'] ?>" class="btn btn-danger"
                                       onclick="return confirmerSuppression(this)">🗑 Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>

<script src="assests/js/script.js"></script>
</body>
</html> 
