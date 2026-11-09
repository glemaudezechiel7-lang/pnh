<?php
/** Package vue */
$titrePage = $equipement ? "Modifier un équipement" : "Nouvel équipement";
require __DIR__ . '/../layout/header.php';
$types = ['arme_de_poing'=>'Arme de poing','fusil'=>'Fusil','gilet_pare_balles'=>'Gilet pare-balles','radio'=>'Radio','vehicule'=>'Véhicule','menottes'=>'Menottes','autre'=>'Autre'];
$etats = ['bon_etat'=>'Bon état','endommage'=>'Endommagé','hors_service'=>'Hors service','perdu'=>'Perdu'];
?>
<div class="card-panel" style="max-width:720px;margin:auto;">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-box-seam me-2"></i><?= e($titrePage) ?></span>
    <a href="index.php?page=equipements" class="small"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
  <div class="card-panel-body">
    <?php if (!empty($erreurs)): ?>
      <div class="alert alert-danger alert-auto"><ul class="mb-0"><?php foreach ($erreurs as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" action="index.php?page=equipements&action=enregistrer">
      <?php if ($equipement): ?><input type="hidden" name="id_equipement" value="<?= (int)$equipement['id_equipement'] ?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Numéro de série *</label>
          <input type="text" name="numero_serie" class="form-control form-control-modern" required
                 value="<?= e($equipement['numero_serie'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Type d'équipement *</label>
          <select name="type_equipement" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($types as $val=>$lbl): ?>
            <option value="<?= $val ?>" <?= (isset($equipement['type_equipement']) && $equipement['type_equipement']===$val)?'selected':'' ?>><?= e($lbl) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-12">
          <label class="form-label fw-semibold">Désignation *</label>
          <input type="text" name="designation" class="form-control form-control-modern" required
                 placeholder="ex: Pistolet Glock 19, Radio Motorola..."
                 value="<?= e($equipement['designation'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Commissariat (armurerie) *</label>
          <select name="id_commissariat" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($commissariats as $c): ?>
            <option value="<?= (int)$c->getIdCommissariat() ?>" <?= (isset($equipement['id_commissariat']) && $equipement['id_commissariat']==$c->getIdCommissariat())?'selected':'' ?>>
              <?= e($c->getNom()) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">État *</label>
          <select name="etat" class="form-select form-control-modern" required>
            <?php foreach ($etats as $val=>$lbl): ?>
            <option value="<?= $val ?>" <?= (isset($equipement['etat']) && $equipement['etat']===$val)?'selected':'' ?>><?= e($lbl) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">Date d'acquisition</label>
          <input type="date" name="date_acquisition" class="form-control form-control-modern"
                 value="<?= e($equipement['date_acquisition'] ?? '') ?>">
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary-modern"><i class="bi bi-check2 me-1"></i>Enregistrer</button>
        <a href="index.php?page=equipements" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
