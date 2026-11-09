<?php
/** Package vue */
$titrePage = "Gardes à vue";
require __DIR__ . '/../layout/header.php';
$roleUser = $_SESSION['utilisateur_role'];
?>
<div class="card-panel">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-shield-lock me-2"></i>Gardes à vue (<?= count($gardes) ?>)</span>
    <a href="index.php?page=gardes&action=form" class="btn btn-primary-modern btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouvelle garde à vue</a>
  </div>
  <div class="card-panel-body table-responsive">
    <table class="table table-modern align-middle">
      <thead><tr><th>Suspect</th><th>Motif</th><th>Agent responsable</th><th>Entrée</th><th>Sortie</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php if (empty($gardes)): ?>
        <tr><td colspan="7" class="text-center text-muted py-4">Aucune garde à vue enregistrée.</td></tr>
        <?php else: foreach ($gardes as $g): ?>
        <tr>
          <td class="fw-semibold"><?= e($g['nom_suspect'].' '.$g['prenom_suspect']) ?></td>
          <td><?= e($g['motif']) ?></td>
          <td><?= e($g['nom_agent']) ?></td>
          <td><?= e(date('d/m/Y H:i', strtotime($g['date_heure_entree']))) ?></td>
          <td><?= $g['date_heure_sortie'] ? e(date('d/m/Y H:i', strtotime($g['date_heure_sortie']))) : '—' ?></td>
          <td><span class="badge-statut badge-<?= e($g['type_sortie']) ?>"><?= e(str_replace('_',' ',$g['type_sortie'])) ?></span></td>
          <td class="text-end">
            <a href="index.php?page=gardes&action=form&id=<?= (int)$g['id_garde'] ?>" class="btn-action"><i class="bi bi-pencil"></i></a>
            <?php if (in_array($roleUser, ['super_admin','admin'], true)): ?>
            <a href="index.php?page=gardes&action=supprimer&id=<?= (int)$g['id_garde'] ?>" class="btn-action danger"
               data-confirm-delete="Supprimer cette garde à vue ?"><i class="bi bi-trash"></i></a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
