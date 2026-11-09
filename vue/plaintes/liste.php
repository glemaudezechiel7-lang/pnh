<?php
/** Package vue */
$titrePage = "Plaintes citoyennes";
require __DIR__ . '/../layout/header.php';
$roleUser = $_SESSION['utilisateur_role'];
?>
<div class="card-panel">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-file-earmark-text me-2"></i>Plaintes (<?= count($plaintes) ?>)</span>
    <a href="index.php?page=plaintes&action=form" class="btn btn-primary-modern btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouvelle plainte</a>
  </div>
  <div class="card-panel-body table-responsive">
    <table class="table table-modern align-middle">
      <thead><tr><th>N°</th><th>Déclarant</th><th>Nature</th><th>Date</th><th>Agent traitant</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php if (empty($plaintes)): ?>
        <tr><td colspan="7" class="text-center text-muted py-4">Aucune plainte enregistrée.</td></tr>
        <?php else: foreach ($plaintes as $p): ?>
        <tr>
          <td class="fw-semibold"><?= e($p['numero_plainte']) ?></td>
          <td><?= e($p['nom_declarant']) ?></td>
          <td><?= e($p['nature']) ?></td>
          <td><?= e(date('d/m/Y H:i', strtotime($p['date_plainte']))) ?></td>
          <td><?= e($p['nom_agent'] ?: 'Non assigné') ?></td>
          <td><span class="badge-statut badge-<?= e($p['statut']) ?>"><?= e(str_replace('_',' ',$p['statut'])) ?></span></td>
          <td class="text-end">
            <a href="index.php?page=plaintes&action=form&id=<?= (int)$p['id_plainte'] ?>" class="btn-action"><i class="bi bi-pencil"></i></a>
            <?php if (in_array($roleUser, ['super_admin','admin'], true)): ?>
            <a href="index.php?page=plaintes&action=supprimer&id=<?= (int)$p['id_plainte'] ?>" class="btn-action danger"
               data-confirm-delete="Supprimer cette plainte ?"><i class="bi bi-trash"></i></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
