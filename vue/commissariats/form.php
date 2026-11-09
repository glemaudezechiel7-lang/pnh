<?php
/** Package vue */
$titrePage = $commissariat ? "Modifier un commissariat" : "Nouveau commissariat";
require __DIR__ . '/../layout/header.php';
?>
<div class="card-panel" style="max-width:760px;margin:auto;">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-building me-2"></i><?= e($titrePage) ?></span>
    <a href="index.php?page=commissariats" class="small"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
  <div class="card-panel-body">
    <?php if (!empty($erreurs)): ?>
      <div class="alert alert-danger alert-auto"><ul class="mb-0"><?php foreach ($erreurs as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" action="index.php?page=commissariats&action=enregistrer" enctype="multipart/form-data">
      <?php if ($commissariat): ?><input type="hidden" name="id_commissariat" value="<?= (int)$commissariat->getIdCommissariat() ?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-8">
          <label class="form-label fw-semibold">Nom *</label>
          <input type="text" name="nom" class="form-control form-control-modern" required value="<?= e($commissariat ? $commissariat->getNom() : '') ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Code *</label>
          <input type="text" name="code" class="form-control form-control-modern" required value="<?= e($commissariat ? $commissariat->getCode() : '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Département *</label>
          <input type="text" name="departement" class="form-control form-control-modern" required value="<?= e($commissariat ? $commissariat->getDepartement() : '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Commune *</label>
          <input type="text" name="commune" class="form-control form-control-modern" required value="<?= e($commissariat ? $commissariat->getCommune() : '') ?>">
        </div>
        <div class="col-md-8">
          <label class="form-label fw-semibold">Adresse</label>
          <input type="text" name="adresse" class="form-control form-control-modern" value="<?= e($commissariat ? $commissariat->getAdresse() : '') ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Téléphone</label>
          <input type="text" name="telephone" class="form-control form-control-modern" value="<?= e($commissariat ? $commissariat->getTelephone() : '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Date de création</label>
          <input type="date" name="date_creation" class="form-control form-control-modern" value="<?= e($commissariat ? $commissariat->getDateCreation() : '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Photo du commissariat</label>
          <input type="file" name="photo" class="form-control form-control-modern" accept=".jpg,.jpeg,.png,.webp">
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary-modern"><i class="bi bi-check2 me-1"></i>Enregistrer</button>
        <a href="index.php?page=commissariats" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
