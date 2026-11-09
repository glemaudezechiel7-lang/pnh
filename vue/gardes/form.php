<?php
/** Package vue */
$titrePage = $garde ? "Modifier la garde à vue" : "Nouvelle garde à vue";
require __DIR__ . '/../layout/header.php';
$typesSortie = ['en_cours'=>'En cours','relache'=>'Relâché','transfere_tribunal'=>'Transféré au tribunal','transfere_prison'=>'Transféré en prison'];
?>
<div class="card-panel" style="max-width:820px;margin:auto;">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-shield-lock me-2"></i><?= e($titrePage) ?></span>
    <a href="index.php?page=gardes" class="small"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
  <div class="card-panel-body">
    <?php if (!empty($erreurs)): ?>
      <div class="alert alert-danger alert-auto"><ul class="mb-0"><?php foreach ($erreurs as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" action="index.php?page=gardes&action=enregistrer">
      <?php if ($garde): ?><input type="hidden" name="id_garde" value="<?= (int)$garde['id_garde'] ?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Nom du suspect *</label>
          <input type="text" name="nom_suspect" class="form-control form-control-modern" required
                 value="<?= e($garde['nom_suspect'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Prénom du suspect</label>
          <input type="text" name="prenom_suspect" class="form-control form-control-modern"
                 value="<?= e($garde['prenom_suspect'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Date de naissance du suspect</label>
          <input type="date" name="date_naissance_suspect" class="form-control form-control-modern"
                 value="<?= e($garde['date_naissance_suspect'] ?? '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Pièce d'identité</label>
          <input type="text" name="piece_identite" class="form-control form-control-modern"
                 value="<?= e($garde['piece_identite'] ?? '') ?>">
        </div>

        <div class="col-md-12">
          <label class="form-label fw-semibold">Motif de la garde à vue *</label>
          <input type="text" name="motif" class="form-control form-control-modern" required
                 value="<?= e($garde['motif'] ?? '') ?>">
        </div>

        <div class="col-md-4">
          <label class="form-label fw-semibold">Agent responsable *</label>
          <select name="id_agent_responsable" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($agents as $ag): ?>
            <option value="<?= (int)$ag['id_agent'] ?>" <?= (isset($garde['id_agent_responsable']) && $garde['id_agent_responsable']==$ag['id_agent'])?'selected':'' ?>>
              <?= e($ag['prenom'].' '.$ag['nom']) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Commissariat *</label>
          <select name="id_commissariat" class="form-select form-control-modern" required>
            <option value="">-- Choisir --</option>
            <?php foreach ($commissariats as $c): ?>
            <option value="<?= (int)$c->getIdCommissariat() ?>" <?= (isset($garde['id_commissariat']) && $garde['id_commissariat']==$c->getIdCommissariat())?'selected':'' ?>>
              <?= e($c->getNom()) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Plainte liée</label>
          <select name="id_plainte" class="form-select form-control-modern">
            <option value="">-- Aucune --</option>
            <?php foreach ($plaintes as $p): ?>
            <option value="<?= (int)$p['id_plainte'] ?>" <?= (isset($garde['id_plainte']) && $garde['id_plainte']==$p['id_plainte'])?'selected':'' ?>>
              <?= e($p['numero_plainte'].' — '.$p['nom_declarant']) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Date et heure d'entrée *</label>
          <input type="datetime-local" name="date_heure_entree" class="form-control form-control-modern" required
                 value="<?= e($garde ? date('Y-m-d\TH:i', strtotime($garde['date_heure_entree'])) : date('Y-m-d\TH:i')) ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Date et heure de sortie</label>
          <input type="datetime-local" name="date_heure_sortie" class="form-control form-control-modern"
                 value="<?= e(!empty($garde['date_heure_sortie']) ? date('Y-m-d\TH:i', strtotime($garde['date_heure_sortie'])) : '') ?>">
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold">Type de sortie *</label>
          <select name="type_sortie" class="form-select form-control-modern" required>
            <?php foreach ($typesSortie as $val=>$lbl): ?>
            <option value="<?= $val ?>" <?= (isset($garde['type_sortie']) && $garde['type_sortie']===$val)?'selected':'' ?>><?= e($lbl) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-12">
          <label class="form-label fw-semibold">Observations</label>
          <textarea name="observations" class="form-control form-control-modern" rows="2"><?= e($garde['observations'] ?? '') ?></textarea>
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary-modern"><i class="bi bi-check2 me-1"></i>Enregistrer</button>
        <a href="index.php?page=gardes" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
