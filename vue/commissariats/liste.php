<?php
/** Package vue */
$titrePage = "Commissariats";
require __DIR__ . '/../layout/header.php';
$roleUser = $_SESSION['utilisateur_role'];
?>
<div class="card-panel">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-building me-2"></i>Commissariats (<?= count($commissariats) ?>)</span>
    <?php if (in_array($roleUser, ['super_admin','admin'], true)): ?>
    <a href="index.php?page=commissariats&action=form" class="btn btn-primary-modern btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouveau commissariat</a>
    <?php endif; ?>
  </div>
  <div class="card-panel-body table-responsive">
    <table class="table table-modern align-middle">
      <thead><tr><th>Nom</th><th>Code</th><th>Département</th><th>Commune</th><th>Téléphone</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php if (empty($commissariats)): ?>
        <tr><td colspan="6" class="text-center text-muted py-4">Aucun commissariat enregistré.</td></tr>
        <?php else: foreach ($commissariats as $c): ?>
        <tr>
          <td class="fw-semibold"><?= e($c->getNom()) ?></td>
          <td><?= e($c->getCode()) ?></td>
          <td><?= e($c->getDepartement()) ?></td>
          <td><?= e($c->getCommune()) ?></td>
          <td><?= e($c->getTelephone() ?: '—') ?></td>
          <td class="text-end">
            <?php if (in_array($roleUser, ['super_admin','admin'], true)): ?>
            <a href="index.php?page=commissariats&action=form&id=<?= (int)$c->getIdCommissariat() ?>" class="btn-action"><i class="bi bi-pencil"></i></a>
            <?php endif; ?>
            <?php if ($roleUser === 'super_admin'): ?>
            <a href="index.php?page=commissariats&action=supprimer&id=<?= (int)$c->getIdCommissariat() ?>" class="btn-action danger"
               data-confirm-delete="Supprimer ce commissariat ?"><i class="bi bi-trash"></i></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
