<?php /** Package vue */ ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion — <?= e(APP_NAME) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="public/css/style.css" rel="stylesheet">
</head>
<body>
<div class="auth-wrapper fade-in">
  <div class="auth-visual d-none d-lg-flex">
    <img src="public/img/logo-pnh.svg" class="badge-shield float-slow" alt="Logo PNH">
    <h2>Plateforme de Gestion de la PNH</h2>
    <p>Un accès sécurisé pour le personnel autorisé : agents, plaintes, gardes à vue, interventions et armement, centralisés en un seul endroit.</p>
    <div class="mt-5 text-white-50 small">
      <i class="bi bi-shield-check me-2"></i>Connexion protégée &amp; sessions sécurisées
    </div>
  </div>
  <div class="auth-form-side">
    <div class="auth-card">
      <h3>Connexion</h3>
      <p class="subtitle">Entrez vos identifiants pour accéder au tableau de bord.</p>

      <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger alert-auto"><i class="bi bi-exclamation-triangle me-2"></i><?= e($erreur) ?></div>
      <?php endif; ?>

      <form method="post" action="index.php?action=login">
        <div class="mb-3">
          <label class="form-label fw-semibold">Identifiant</label>
          <input type="text" name="login" class="form-control form-control-modern" placeholder="ex: superadmin" required autofocus>
        </div>
        <div class="mb-4">
          <label class="form-label fw-semibold">Mot de passe</label>
          <input type="password" name="mot_de_passe" class="form-control form-control-modern" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-primary-modern w-100 py-2">
          <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
        </button>
      </form>
      <div class="text-center mt-4">
        <a href="index.php" class="text-muted small"><i class="bi bi-arrow-left me-1"></i>Retour à l'accueil</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
