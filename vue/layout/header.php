<?php
/**
 * Package vue — en-tête commun des pages internes (après connexion).
 * Aucune logique métier ici : uniquement de l'affichage.
 */
$pageActuelle = $_GET['page'] ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="public/css/style.css" rel="stylesheet">
</head>
<body>
<div class="app-shell">
  <!-- Overlay affiché derrière la sidebar mobile ouverte (clic pour refermer) -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <img src="public/img/logo-pnh.svg" alt="Logo PNH" class="brand-logo">
      <div>
        <div class="brand-title">PNH</div>
        <div class="brand-sub">Gestion Commissariat</div>
      </div>
    </div>
    <nav class="sidebar-nav">
      <a href="index.php?page=dashboard" class="nav-link <?= $pageActuelle==='dashboard'?'active':'' ?>">
        <i class="bi bi-speedometer2"></i><span>Tableau de bord</span>
      </a>
      <a href="index.php?page=agents" class="nav-link <?= $pageActuelle==='agents'?'active':'' ?>">
        <i class="bi bi-person-badge"></i><span>Agents</span>
      </a>
      <a href="index.php?page=affectations" class="nav-link <?= $pageActuelle==='affectations'?'active':'' ?>">
        <i class="bi bi-arrow-left-right"></i><span>Affectations</span>
      </a>
      <a href="index.php?page=plaintes" class="nav-link <?= $pageActuelle==='plaintes'?'active':'' ?>">
        <i class="bi bi-file-earmark-text"></i><span>Plaintes</span>
      </a>
      <a href="index.php?page=gardes" class="nav-link <?= $pageActuelle==='gardes'?'active':'' ?>">
        <i class="bi bi-shield-lock"></i><span>Gardes à vue</span>
      </a>
      <a href="index.php?page=rapports" class="nav-link <?= $pageActuelle==='rapports'?'active':'' ?>">
        <i class="bi bi-clipboard-data"></i><span>Interventions</span>
      </a>
      <a href="index.php?page=equipements" class="nav-link <?= $pageActuelle==='equipements'?'active':'' ?>">
        <i class="bi bi-box-seam"></i><span>Armement &amp; Équipements</span>
      </a>
      <a href="index.php?page=commissariats" class="nav-link <?= $pageActuelle==='commissariats'?'active':'' ?>">
        <i class="bi bi-building"></i><span>Commissariats</span>
      </a>
      <?php if (in_array($_SESSION['utilisateur_role'] ?? '', ['super_admin', 'admin'], true)): ?>
      <a href="index.php?page=utilisateurs" class="nav-link <?= $pageActuelle==='utilisateurs'?'active':'' ?>">
        <i class="bi bi-people"></i><span>Utilisateurs</span>
      </a>
      <?php endif; ?>
    </nav>
    <div class="sidebar-footer">
      <a href="index.php?action=logout" class="nav-link text-danger">
        <i class="bi bi-box-arrow-right"></i><span>Déconnexion</span>
      </a>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="main-area">
    <header class="topbar">
      <button class="btn-burger d-lg-none" id="burgerBtn" type="button" aria-label="Ouvrir le menu">
        <i class="bi bi-list"></i>
      </button>
      <div class="topbar-title"><?= e($titrePage ?? '') ?></div>
      <div class="topbar-user">
        <span class="user-role-badge role-<?= e($_SESSION['utilisateur_role'] ?? '') ?>">
          <?= e(ucfirst(str_replace('_',' ', $_SESSION['utilisateur_role'] ?? ''))) ?>
        </span>
        <div class="user-avatar"><?= e(mb_substr($_SESSION['utilisateur_nom'] ?? '?', 0, 1)) ?></div>
        <span class="user-name d-none d-md-inline"><?= e($_SESSION['utilisateur_nom'] ?? '') ?></span>
      </div>
    </header>
    <main class="content-area fade-in">
      </main>

      
<script>
document.addEventListener("DOMContentLoaded", function() {
  const burgerBtn = document.getElementById("burgerBtn");
  const sidebar = document.getElementById("sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  // Ouvrir la sidebar
  burgerBtn.addEventListener("click", function() {
    sidebar.classList.toggle("open");
    overlay.classList.toggle("active");
  });

  // Fermer la sidebar en cliquant sur l’overlay
  overlay.addEventListener("click", function() {
    sidebar.classList.remove("open");
    overlay.classList.remove("active");
  });
});
</script>


</body>
</html>
