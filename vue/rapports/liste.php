<?php
/** Package vue */
$titrePage = "Rapports d'intervention";
require __DIR__ . '/../layout/header.php';
$roleUser = $_SESSION['utilisateur_role'];
?>
<div class="card-panel">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-clipboard-data me-2"></i>Interventions (<?= count($rapports) ?>)</span>
    <?php if (in_array($roleUser, ['super_admin','admin','gestionnaire'], true)): ?>
    <a href="index.php?page=rapports&action=form" class="btn btn-primary-modern btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouveau rapport</a>
    <?php endif; ?>
  </div>
  <div class="card-panel-body table-responsive">
    <table class="table table-modern align-middle">
      <thead><tr><th>Réf.</th><th>Type d'opération</th><th>Zone</th><th>Effectifs</th><th>Date</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php if (empty($rapports)): ?>
        <tr><td colspan="7" class="text-center text-muted py-4">Aucun rapport enregistré.</td></tr>
        <?php else: foreach ($rapports as $r): ?>
        <tr>
          <td class="fw-semibold"><?= e($r['reference']) ?></td>
          <td><?= e($r['type_operation']) ?></td>
          <td><?= e($r['zone_geographique']) ?></td>
          <td><?= (int)$r['effectifs_deployes'] ?></td>
          <td><?= e(date('d/m/Y H:i', strtotime($r['date_intervention']))) ?></td>
          <td><span class="badge-statut badge-<?= e($r['statut']) ?>"><?= e(ucfirst($r['statut'])) ?></span></td>
          <td class="text-end">
            <?php if (in_array($roleUser, ['super_admin','admin','gestionnaire'], true)): ?>
            <a href="index.php?page=rapports&action=form&id=<?= (int)$r['id_rapport'] ?>" class="btn-action"><i class="bi bi-pencil"></i></a>
            <?php endif; ?>
            <?php if (in_array($roleUser, ['super_admin','admin'], true)): ?>
            <a href="index.php?page=rapports&action=supprimer&id=<?= (int)$r['id_rapport'] ?>" class="btn-action danger"
               data-confirm-delete="Supprimer ce rapport ?"><i class="bi bi-trash"></i></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
