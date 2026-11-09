<?php
/** Package vue */
$titrePage = "Gestion des agents";
require __DIR__ . '/../layout/header.php';
$roleUser = $_SESSION['utilisateur_role'];
?>
<div class="card-panel">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-person-badge me-2"></i>Liste des agents (<?= count($agents) ?>)</span>
    <?php if (in_array($roleUser, ['super_admin','admin','gestionnaire'], true)): ?>
    <a href="index.php?page=agents&action=form" class="btn btn-primary-modern btn-sm">
      <i class="bi bi-plus-lg me-1"></i>Nouvel agent
    </a>
    <?php endif; ?>
  </div>
  <div class="card-panel-body table-responsive">
    <table class="table table-modern align-middle">
      <thead><tr>
        <th>Agent</th><th>Matricule</th><th>Grade</th><th>Commissariat</th><th>Entrée</th><th>Statut</th><th class="text-end">Actions</th>
      </tr></thead>
      <tbody>
        <?php if (empty($agents)): ?>
        <tr><td colspan="7" class="text-center text-muted py-4">Aucun agent enregistré.</td></tr>
        <?php else: foreach ($agents as $a): ?>
        <tr>
          <td>
            <div class="d-flex align-items-center gap-2">
              <img src="<?= e($a['photo'] ?: 'public/img/avatar-default.svg') ?>" class="avatar-agent" alt="photo">
              <span class="fw-semibold"><?= e($a['prenom'].' '.$a['nom']) ?></span>
            </div>
          </td>
          <td><?= e($a['matricule']) ?></td>
          <td><?= e($a['grade']) ?></td>
          <td><?= e($a['nom_commissariat']) ?></td>
          <td><?= e(date('d/m/Y', strtotime($a['date_entree']))) ?></td>
          <td><span class="badge-statut badge-<?= e($a['statut']) ?>"><?= e(str_replace('_',' ',$a['statut'])) ?></span></td>
          <td class="text-end">
            <a href="index.php?page=agents&action=fiche&id=<?= (int)$a['id_agent'] ?>" class="btn-action" title="Voir"><i class="bi bi-eye"></i></a>
            <?php if (in_array($roleUser, ['super_admin','admin','gestionnaire'], true)): ?>
            <a href="index.php?page=agents&action=form&id=<?= (int)$a['id_agent'] ?>" class="btn-action" title="Modifier"><i class="bi bi-pencil"></i></a>
            <?php endif; ?>
            <?php if (in_array($roleUser, ['super_admin','admin'], true)): ?>
            <a href="index.php?page=agents&action=supprimer&id=<?= (int)$a['id_agent'] ?>" class="btn-action danger" title="Supprimer"
               data-confirm-delete="Supprimer définitivement cet agent ?"><i class="bi bi-trash"></i></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
