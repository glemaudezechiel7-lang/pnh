<?php
/** Package vue */
$titrePage = "Affectations & Rotations";
require __DIR__ . '/../layout/header.php';
$roleUser = $_SESSION['utilisateur_role'];
?>
<div class="card-panel">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-arrow-left-right me-2"></i>Affectations (<?= count($affectations) ?>)</span>
    <?php if (in_array($roleUser, ['super_admin','admin','gestionnaire'], true)): ?>
    <a href="index.php?page=affectations&action=form" class="btn btn-primary-modern btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouvelle affectation</a>
    <?php endif; ?>
  </div>
  <div class="card-panel-body table-responsive">
    <table class="table table-modern align-middle">
      <thead><tr><th>Agent</th><th>Commissariat</th><th>Poste</th><th>Type</th><th>Début</th><th>Fin</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php if (empty($affectations)): ?>
        <tr><td colspan="8" class="text-center text-muted py-4">Aucune affectation enregistrée.</td></tr>
        <?php else: foreach ($affectations as $a): ?>
        <tr>
          <td><?= e($a['prenom_agent'].' '.$a['nom_agent']) ?> <span class="text-muted small">(<?= e($a['matricule']) ?>)</span></td>
          <td><?= e($a['nom_commissariat']) ?></td>
          <td><?= e($a['poste']) ?></td>
          <td><?= e(ucfirst($a['type_affectation'])) ?></td>
          <td><?= e(date('d/m/Y', strtotime($a['date_debut']))) ?></td>
          <td><?= $a['date_fin'] ? e(date('d/m/Y', strtotime($a['date_fin']))) : '—' ?></td>
          <td><span class="badge-statut badge-<?= e($a['statut']) ?>"><?= e(ucfirst($a['statut'])) ?></span></td>
          <td class="text-end">
            <?php if (in_array($roleUser, ['super_admin','admin'], true)): ?>
            <a href="index.php?page=affectations&action=supprimer&id=<?= (int)$a['id_affectation'] ?>" class="btn-action danger"
               data-confirm-delete="Supprimer cette affectation ?"><i class="bi bi-trash"></i></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
