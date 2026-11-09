<?php
/** Package vue */
$titrePage = "Armement & Équipements";
require __DIR__ . '/../layout/header.php';
$roleUser = $_SESSION['utilisateur_role'];
$peutGerer = in_array($roleUser, ['super_admin','admin','gestionnaire'], true);
?>
<ul class="nav nav-tabs mb-3" role="tablist">
  <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-equip">Inventaire</button></li>
  <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-attrib">Attributions</button></li>
</ul>
<div class="tab-content">
  <div class="tab-pane fade show active" id="tab-equip">
    <div class="card-panel">
      <div class="card-panel-header">
        <span class="fw-bold"><i class="bi bi-box-seam me-2"></i>Inventaire (<?= count($equipements) ?>)</span>
        <?php if ($peutGerer): ?>
        <a href="index.php?page=equipements&action=form" class="btn btn-primary-modern btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouvel équipement</a>
        <?php endif; ?>
      </div>
      <div class="card-panel-body table-responsive">
        <table class="table table-modern align-middle">
          <thead><tr><th>N° Série</th><th>Type</th><th>Désignation</th><th>Commissariat</th><th>État</th><th class="text-end">Actions</th></tr></thead>
          <tbody>
            <?php if (empty($equipements)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">Aucun équipement enregistré.</td></tr>
            <?php else: foreach ($equipements as $e): ?>
            <tr>
              <td class="fw-semibold"><?= e($e['numero_serie']) ?></td>
              <td><?= e(str_replace('_',' ',$e['type_equipement'])) ?></td>
              <td><?= e($e['designation']) ?></td>
              <td><?= e($e['nom_commissariat']) ?></td>
              <td><span class="badge-statut badge-<?= e($e['etat']) ?>"><?= e(str_replace('_',' ',$e['etat'])) ?></span></td>
              <td class="text-end">
                <?php if ($peutGerer): ?>
                <a href="index.php?page=equipements&action=form&id=<?= (int)$e['id_equipement'] ?>" class="btn-action"><i class="bi bi-pencil"></i></a>
                <?php endif; ?>
                <?php if (in_array($roleUser, ['super_admin','admin'], true)): ?>
                <a href="index.php?page=equipements&action=supprimer&id=<?= (int)$e['id_equipement'] ?>" class="btn-action danger"
                   data-confirm-delete="Supprimer cet équipement ?"><i class="bi bi-trash"></i></a>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="tab-pane fade" id="tab-attrib">
    <div class="card-panel">
      <div class="card-panel-header">
        <span class="fw-bold"><i class="bi bi-person-check me-2"></i>Attributions (<?= count($attributions) ?>)</span>
        <?php if ($peutGerer): ?>
        <a href="index.php?page=equipements&action=attribuer" class="btn btn-primary-modern btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouvelle attribution</a>
        <?php endif; ?>
      </div>
      <div class="card-panel-body table-responsive">
        <table class="table table-modern align-middle">
          <thead><tr><th>Équipement</th><th>Agent</th><th>Attribution</th><th>Retour</th><th>Statut</th><?php if($peutGerer):?><th class="text-end">Retour</th><?php endif; ?></tr></thead>
          <tbody>
            <?php if (empty($attributions)): ?>
            <tr><td colspan="6" class="text-center text-muted py-4">Aucune attribution enregistrée.</td></tr>
            <?php else: foreach ($attributions as $at): ?>
            <tr>
              <td class="fw-semibold"><?= e($at['designation']) ?> <span class="text-muted small">(<?= e($at['numero_serie']) ?>)</span></td>
              <td><?= e($at['nom_agent']) ?></td>
              <td><?= e(date('d/m/Y H:i', strtotime($at['date_attribution']))) ?></td>
              <td><?= $at['date_retour'] ? e(date('d/m/Y H:i', strtotime($at['date_retour']))) : '—' ?></td>
              <td><span class="badge-statut badge-<?= e($at['statut']) ?>"><?= e(str_replace('_',' ',$at['statut'])) ?></span></td>
              <?php if ($peutGerer): ?>
              <td class="text-end">
                <?php if ($at['statut'] === 'en_possession'): ?>
                <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRetour<?= (int)$at['id_attribution'] ?>">
                  <i class="bi bi-box-arrow-in-left"></i> Retour
                </button>
                <div class="modal fade" id="modalRetour<?= (int)$at['id_attribution'] ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form method="post" action="index.php?page=equipements&action=retour">
                        <input type="hidden" name="id_attribution" value="<?= (int)$at['id_attribution'] ?>">
                        <div class="modal-header"><h5 class="modal-title">Enregistrer le retour</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                        <div class="modal-body">
                          <label class="form-label fw-semibold">État au retour</label>
                          <select name="etat_retour" class="form-select form-control-modern mb-3">
                            <option value="bon_etat">Bon état</option>
                            <option value="endommage">Endommagé</option>
                            <option value="hors_service">Hors service</option>
                            <option value="perdu">Perdu</option>
                          </select>
                          <label class="form-label fw-semibold">Observations</label>
                          <textarea name="observations_retour" class="form-control form-control-modern" rows="2"></textarea>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary-modern">Confirmer le retour</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <?php endif; ?>
              </td>
              <?php endif; ?>
            </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
