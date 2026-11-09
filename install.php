<?php
/**
 * install.php — Script d'installation (à exécuter UNE SEULE FOIS, dans le navigateur)
 *
 * Conformément au cahier des charges : « Par défaut, le système crée automatiquement
 * un compte super administrateur lors de la première installation. »
 *
 * Ce script :
 *   1. Vérifie la connexion à la base de données pnh_gestion (importée via sql/pnh_database.sql)
 *   2. Si aucun compte utilisateur n'existe encore, crée le compte super administrateur
 *      avec un mot de passe correctement haché (password_hash).
 *
 * Une fois l'installation terminée, il est recommandé de supprimer ou de renommer ce fichier.
 */

require_once __DIR__ . '/config/config.php';

$loginDefaut = 'superadmin';
$motDePasseDefaut = 'Admin@2026';
$emailDefaut = '[email protected]';

$messages = [];
$erreur = null;

try {
    $pdo = Connexion::getInstance();

    $stmt = $pdo->query("SELECT COUNT(*) FROM utilisateurs");
    $nbUtilisateurs = (int)$stmt->fetchColumn();

    if ($nbUtilisateurs === 0) {
        $stmtCom = $pdo->query("SELECT id_commissariat FROM commissariats ORDER BY id_commissariat LIMIT 1");
        $idCommissariat = $stmtCom->fetchColumn();

        $hash = password_hash($motDePasseDefaut, PASSWORD_DEFAULT);

        $insert = $pdo->prepare(
            "INSERT INTO utilisateurs (nom, prenom, login, email, mot_de_passe, role, id_commissariat, statut)
             VALUES ('Administrateur', 'Système', :login, :email, :mdp, 'super_admin', :com, 'actif')"
        );
        $insert->execute([
            'login' => $loginDefaut,
            'email' => $emailDefaut,
            'mdp' => $hash,
            'com' => $idCommissariat ?: null,
        ]);

        $messages[] = "Le compte super administrateur a été créé avec succès.";
    } else {
        $messages[] = "L'installation a déjà été effectuée : des comptes utilisateurs existent déjà.";
    }
} catch (Throwable $e) {
    $erreur = "Impossible de se connecter à la base de données. Vérifiez que la base 'pnh_gestion' "
        . "a bien été importée (sql/pnh_database.sql) et que les identifiants dans config/config.php sont corrects.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Installation — <?= e(APP_NAME) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="public/css/style.css" rel="stylesheet">
</head>
<body style="background:var(--gray-100);">
<div class="d-flex align-items-center justify-content-center" style="min-height:100vh;">
  <div class="card-panel" style="max-width:520px;width:100%;">
    <div class="card-panel-header"><span class="fw-bold">Installation de l'application</span></div>
    <div class="card-panel-body">
      <?php if ($erreur): ?>
        <div class="alert alert-danger"><?= e($erreur) ?></div>
      <?php else: ?>
        <?php foreach ($messages as $m): ?>
          <div class="alert alert-success"><?= e($m) ?></div>
        <?php endforeach; ?>
        <p class="mb-1">Identifiant : <strong><?= e($loginDefaut) ?></strong></p>
        <p class="mb-3">Mot de passe : <strong><?= e($motDePasseDefaut) ?></strong></p>
        <p class="text-muted small">Merci de changer ce mot de passe dès votre première connexion, puis de supprimer ce fichier install.php.</p>
        <a href="index.php?page=login" class="btn btn-primary-modern w-100 mt-2">Aller à la connexion</a>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
