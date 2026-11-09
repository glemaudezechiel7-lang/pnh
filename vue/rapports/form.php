<?php
/** Package vue */
$titrePage = $rapport ? "Modifier le rapport" : "Nouveau rapport d'intervention";
require __DIR__ . '/../layout/header.php';
$statuts = ['planifiee'=>'Planifiée','en_cours'=>'En cours','terminee'=>'Terminée','annulee'=>'Annulée'];
?>
<div class="card-panel" style="max-width:820px;margin:auto;">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-clipboard-data me-2"></i><?= e($titrePage) ?></span>
    <a href="index.php?page=rapports" class="small"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
  <div class="card-panel-body">
    <?php if (!empty($erreurs)): ?>
      <div class="alert alert-danger alert-auto"><ul class="mb-0"><?php foreach ($erreurs as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" action="index.php?page=rapports&action=enregistrer">
      <?php if ($rapport): ?>
        <input type="hidden" name="id_rapport" value="<?= (int)$rapport['id_rapport'] ?>">
        <input type="hidden" name="reference" value="<?= e($rapport['reference']) ?>">
      <?php endif; ?>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Type d'opération *</label>
          <input type="text" name="type_operation" class="form-control form-control-modern" required
                 placeholder="ex: Patrouille, Perquisition, Contrôle routier"
                 value="<?= e($rapport['type_operation'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Zone géographique *</label>
          <input type="text" name="zone_geographique" class="form-control form-control-modern" required
                 value="<?= e($rapport['zone_geographique'] ?? '') ?>">
        </div>

        <div class="col-md-12">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control form-control-modern" rows="3"><?= e($rapport['description'] ?? '') ?></textarea>
        </div>

        <div class="col-md-4">
          <label class="form-label fw-semibold">Commissariat *</label>
          <select name="id_commissariat" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($commissariats as $c): ?>
            <option value="<?= (int)$c->getIdCommissariat() ?>" <?= (isset($rapport['id_commissariat']) && $rapport['id_commissariat']==$c->getIdCommissariat())?'selected':'' ?>>
              <?= e($c->getNom()) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Agent responsable *</label>
          <select name="id_agent_responsable" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($agents as $ag): ?>
            <option value="<?= (int)$ag['id_agent'] ?>" <?= (isset($rapport['id_agent_responsable']) && $rapport['id_agent_responsable']==$ag['id_agent'])?'selected':'' ?>>
              <?= e($ag['prenom'].' '.$ag['nom']) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Effectifs déployés *</label>
          <input type="number" min="1" name="effectifs_deployes" class="form-control form-control-modern" required
                 value="<?= e($rapport['effectifs_deployes'] ?? 1) ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Date de l'intervention *</label>
          <input type="datetime-local" name="date_intervention" class="form-control form-control-modern" required
                 value="<?= e($rapport ? date('Y-m-d\TH:i', strtotime($rapport['date_intervention'])) : date('Y-m-d\TH:i')) ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Statut *</label>
          <select name="statut" class="form-select form-control-modern" required>
            <?php foreach ($statuts as $val=>$lbl): ?>
            <option value="<?= $val ?>" <?= (isset($rapport['statut']) && $rapport['statut']===$val)?'selected':'' ?>><?= e($lbl) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-12">
          <label class="form-label fw-semibold">Résultats de l'opération</label>
          <textarea name="resultats" class="form-control form-control-modern" rows="3"><?= e($rapport['resultats'] ?? '') ?></textarea>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary-modern"><i class="bi bi-check2 me-1"></i>Enregistrer</button>
        <a href="index.php?page=rapports" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
