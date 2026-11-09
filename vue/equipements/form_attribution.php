<?php
/** Package vue */
$titrePage = "Attribuer un équipement";
require __DIR__ . '/../layout/header.php';
?>
<div class="card-panel" style="max-width:640px;margin:auto;">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-person-check me-2"></i>Attribuer un équipement</span>
    <a href="index.php?page=equipements" class="small"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
  <div class="card-panel-body">
    <?php if (!empty($erreurs)): ?>
      <div class="alert alert-danger alert-auto"><ul class="mb-0"><?php foreach ($erreurs as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" action="index.php?page=equipements&action=enregistrer_attribution">
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label fw-semibold">Équipement *</label>
          <select name="id_equipement" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($equipements as $e): ?>
            <option value="<?= (int)$e['id_equipement'] ?>"><?= e($e['designation'].' — '.$e['numero_serie']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label fw-semibold">Agent *</label>
          <select name="id_agent" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($agents as $ag): ?>
            <option value="<?= (int)$ag['id_agent'] ?>"><?= e($ag['prenom'].' '.$ag['nom'].' ('.$ag['matricule'].')') ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-12">
          <label class="form-label fw-semibold">Date d'attribution *</label>
          <input type="datetime-local" name="date_attribution" class="form-control form-control-modern" required
                 value="<?= date('Y-m-d\TH:i') ?>">
        </div>
        <div class="col-12">
          <label class="form-label fw-semibold">Observations</label>
          <textarea name="observations" class="form-control form-control-modern" rows="2"></textarea>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary-modern"><i class="bi bi-check2 me-1"></i>Attribuer</button>
        <a href="index.php?page=equipements" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
