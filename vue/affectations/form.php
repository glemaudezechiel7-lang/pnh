<?php
/** Package vue */
$titrePage = "Nouvelle affectation";
require __DIR__ . '/../layout/header.php';
?>
<div class="card-panel" style="max-width:760px;margin:auto;">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-arrow-left-right me-2"></i>Nouvelle affectation / rotation</span>
    <a href="index.php?page=affectations" class="small"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
  <div class="card-panel-body">
    <?php if (!empty($erreurs)): ?>
      <div class="alert alert-danger alert-auto"><ul class="mb-0"><?php foreach ($erreurs as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" action="index.php?page=affectations&action=enregistrer">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Agent *</label>
          <select name="id_agent" class="form-select form-control-modern" required>
            <option value="">-- Choisir un agent --</option>
            <?php foreach ($agents as $ag): ?>
            <option value="<?= (int)$ag['id_agent'] ?>"><?= e($ag['prenom'].' '.$ag['nom'].' ('.$ag['matricule'].')') ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Commissariat *</label>
          <select name="id_commissariat" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($commissariats as $c): ?>
            <option value="<?= (int)$c->getIdCommissariat() ?>"><?= e($c->getNom()) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Poste de travail *</label>
          <input type="text" name="poste" class="form-control form-control-modern" placeholder="ex: Accueil, Patrouille, Bureau des plaintes" required>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Type d'affectation *</label>
          <select name="type_affectation" class="form-select form-control-modern" required>
            <option value="initiale">Initiale</option>
            <option value="mutation">Mutation</option>
            <option value="rotation">Rotation</option>
            <option value="detachement">Détachement</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Date de début *</label>
          <input type="date" name="date_debut" class="form-control form-control-modern" required>
        </div>
        <div class="col-md-12">
          <label class="form-label fw-semibold">Motif</label>
          <input type="text" name="motif" class="form-control form-control-modern" placeholder="Motif de la mutation/rotation (si applicable)">
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary-modern"><i class="bi bi-check2 me-1"></i>Enregistrer</button>
        <a href="index.php?page=affectations" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
