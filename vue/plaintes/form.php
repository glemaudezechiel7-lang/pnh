<?php
/** Package vue */
$titrePage = $plainte ? "Modifier la plainte" : "Nouvelle plainte";
require __DIR__ . '/../layout/header.php';
$statuts = ['ouverte'=>'Ouverte','en_cours'=>'En cours','cloturee'=>'Clôturée','classee_sans_suite'=>'Classée sans suite'];
?>
<div class="card-panel" style="max-width:820px;margin:auto;">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-file-earmark-text me-2"></i><?= e($titrePage) ?></span>
    <a href="index.php?page=plaintes" class="small"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
  <div class="card-panel-body">
    <?php if (!empty($erreurs)): ?>
      <div class="alert alert-danger alert-auto"><ul class="mb-0"><?php foreach ($erreurs as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" action="index.php?page=plaintes&action=enregistrer">
      <?php if ($plainte): ?>
        <input type="hidden" name="id_plainte" value="<?= (int)$plainte['id_plainte'] ?>">
        <input type="hidden" name="numero_plainte" value="<?= e($plainte['numero_plainte']) ?>">
      <?php endif; ?>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Nom du déclarant *</label>
          <input type="text" name="nom_declarant" class="form-control form-control-modern" required
                 value="<?= e($plainte['nom_declarant'] ?? '') ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">Téléphone</label>
          <input type="text" name="telephone_declarant" class="form-control form-control-modern"
                 value="<?= e($plainte['telephone_declarant'] ?? '') ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label fw-semibold">Date de la plainte *</label>
          <input type="datetime-local" name="date_plainte" class="form-control form-control-modern" required
                 value="<?= e($plainte ? date('Y-m-d\TH:i', strtotime($plainte['date_plainte'])) : date('Y-m-d\TH:i')) ?>">
        </div>
        <div class="col-md-12">
          <label class="form-label fw-semibold">Adresse du déclarant</label>
          <input type="text" name="adresse_declarant" class="form-control form-control-modern"
                 value="<?= e($plainte['adresse_declarant'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Nature de la plainte *</label>
          <input type="text" name="nature" class="form-control form-control-modern" placeholder="ex: Vol, Agression, Tapage nocturne..." required
                 value="<?= e($plainte['nature'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Lieu de l'incident</label>
          <input type="text" name="lieu_incident" class="form-control form-control-modern"
                 value="<?= e($plainte['lieu_incident'] ?? '') ?>">
        </div>
        <div class="col-md-12">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" rows="3" class="form-control form-control-modern"><?= e($plainte['description'] ?? '') ?></textarea>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Commissariat *</label>
          <select name="id_commissariat" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($commissariats as $c): ?>
            <option value="<?= (int)$c->getIdCommissariat() ?>" <?= (isset($plainte['id_commissariat']) && (int)$plainte['id_commissariat']===$c->getIdCommissariat())?'selected':'' ?>>
              <?= e($c->getNom()) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Agent traitant</label>
          <select name="id_agent_traitant" class="form-select form-control-modern">
            <option value="">-- Non assigné --</option>
            <?php foreach ($agents as $ag): ?>
            <option value="<?= (int)$ag['id_agent'] ?>" <?= (isset($plainte['id_agent_traitant']) && (int)$plainte['id_agent_traitant']===(int)$ag['id_agent'])?'selected':'' ?>>
              <?= e($ag['prenom'].' '.$ag['nom']) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Statut *</label>
          <select name="statut" class="form-select form-control-modern" required>
            <?php foreach ($statuts as $val=>$lbl): ?>
            <option value="<?= $val ?>" <?= (isset($plainte['statut']) && $plainte['statut']===$val)?'selected':'' ?>><?= e($lbl) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary-modern"><i class="bi bi-check2 me-1"></i>Enregistrer</button>
        <a href="index.php?page=plaintes" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
