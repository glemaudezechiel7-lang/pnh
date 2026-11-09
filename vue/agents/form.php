<?php
/** Package vue */
$titrePage = $agent ? "Modifier un agent" : "Nouvel agent";
require __DIR__ . '/../layout/header.php';
$grades = ['Agent 1','Agent 2','Corporal','Sergent','Sergent-Chef','Inspecteur','Commissaire','Commissaire Principal','Directeur'];
$statuts = ['en_service'=>'En service','en_conge'=>'En congé','suspendu'=>'Suspendu','retraite'=>'Retraité','radie'=>'Radié'];
?>
<div class="card-panel" style="max-width:820px;margin:auto;">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-person-badge me-2"></i><?= e($titrePage) ?></span>
    <a href="index.php?page=agents" class="small"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
  <div class="card-panel-body">
    <?php if (!empty($erreurs)): ?>
      <div class="alert alert-danger alert-auto">
        <ul class="mb-0"><?php foreach ($erreurs as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
      </div>
    <?php endif; ?>

    <form method="post" action="index.php?page=agents&action=enregistrer" enctype="multipart/form-data">
      <?php if ($agent): ?><input type="hidden" name="id_agent" value="<?= (int)$agent->getIdAgent() ?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Matricule *</label>
          <input type="text" name="matricule" class="form-control form-control-modern" required
                 value="<?= e($agent ? $agent->getMatricule() : '') ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Nom *</label>
          <input type="text" name="nom" class="form-control form-control-modern" required
                 value="<?= e($agent ? $agent->getNom() : '') ?>">
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Prénom *</label>
          <input type="text" name="prenom" class="form-control form-control-modern" required
                 value="<?= e($agent ? $agent->getPrenom() : '') ?>">
        </div>

        <div class="col-md-4">
          <label class="form-label fw-semibold">Grade *</label>
          <select name="grade" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($grades as $g): ?>
            <option value="<?= e($g) ?>" <?= ($agent && $agent->getGrade()===$g)?'selected':'' ?>><?= e($g) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Sexe *</label>
          <select name="sexe" class="form-select form-control-modern" required>
            <option value="M" <?= ($agent && $agent->getSexe()==='M')?'selected':'' ?>>Masculin</option>
            <option value="F" <?= ($agent && $agent->getSexe()==='F')?'selected':'' ?>>Féminin</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Date de naissance *</label>
          <input type="date" name="date_naissance" class="form-control form-control-modern" required
                 value="<?= e($agent ? $agent->getDateNaissance() : '') ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Téléphone</label>
          <input type="text" name="telephone" class="form-control form-control-modern"
                 value="<?= e($agent ? $agent->getTelephone() : '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Adresse</label>
          <input type="text" name="adresse" class="form-control form-control-modern"
                 value="<?= e($agent ? $agent->getAdresse() : '') ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Commissariat d'affectation *</label>
          <select name="id_commissariat" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($commissariats as $c): ?>
            <option value="<?= (int)$c->getIdCommissariat() ?>" <?= ($agent && $agent->getIdCommissariat()===$c->getIdCommissariat())?'selected':'' ?>>
              <?= e($c->getNom()) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">Date d'entrée *</label>
          <input type="date" name="date_entree" class="form-control form-control-modern" required
                 value="<?= e($agent ? $agent->getDateEntree() : '') ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">Statut *</label>
          <select name="statut" class="form-select form-control-modern" required>
            <?php foreach ($statuts as $val=>$lbl): ?>
            <option value="<?= $val ?>" <?= ($agent && $agent->getStatut()===$val)?'selected':'' ?>><?= e($lbl) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Photo</label>
          <input type="file" name="photo" class="form-control form-control-modern" accept=".jpg,.jpeg,.png,.webp">
        </div>
      </div>

      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary-modern"><i class="bi bi-check2 me-1"></i>Enregistrer</button>
        <a href="index.php?page=agents" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
