<?php
/** Package vue */
$titrePage = $utilisateur ? "Modifier un utilisateur" : "Nouvel utilisateur";
require __DIR__ . '/../layout/header.php';
$roles = ['super_admin'=>'Super administrateur','admin'=>'Administrateur','gestionnaire'=>'Gestionnaire','operateur'=>'Opérateur'];
?>
<div class="card-panel" style="max-width:680px;margin:auto;">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-people me-2"></i><?= e($titrePage) ?></span>
    <a href="index.php?page=utilisateurs" class="small"><i class="bi bi-arrow-left me-1"></i>Retour</a>
  </div>
  <div class="card-panel-body">
    <?php if (!empty($erreurs)): ?>
      <div class="alert alert-danger alert-auto"><ul class="mb-0"><?php foreach ($erreurs as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul></div>
    <?php endif; ?>
    <form method="post" action="index.php?page=utilisateurs&action=enregistrer">
      <?php if ($utilisateur): ?><input type="hidden" name="id_utilisateur" value="<?= (int)$utilisateur->getIdUtilisateur() ?>"><?php endif; ?>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label fw-semibold">Nom *</label>
          <input type="text" name="nom" class="form-control form-control-modern" required
                 value="<?= e($utilisateur ? $utilisateur->getNom() : '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Prénom *</label>
          <input type="text" name="prenom" class="form-control form-control-modern" required
                 value="<?= e($utilisateur ? $utilisateur->getPrenom() : '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Login *</label>
          <input type="text" name="login" class="form-control form-control-modern" required
                 value="<?= e($utilisateur ? $utilisateur->getLogin() : '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Email *</label>
          <input type="email" name="email" class="form-control form-control-modern" required
                 value="<?= e($utilisateur ? $utilisateur->getEmail() : '') ?>">
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Rôle *</label>
          <select name="role" class="form-select form-control-modern" required>
            <?php foreach ($roles as $val=>$lbl): ?>
            <option value="<?= $val ?>" <?= ($utilisateur && $utilisateur->getRole()===$val)?'selected':'' ?>><?= e($lbl) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label fw-semibold">Commissariat de rattachement</label>
          <select name="id_commissariat" class="form-select form-control-modern">
            <option value="">-- Aucun --</option>
            <?php foreach ($commissariats as $c): ?>
            <option value="<?= (int)$c->getIdCommissariat() ?>" <?= ($utilisateur && $utilisateur->getIdCommissariat()===$c->getIdCommissariat())?'selected':'' ?>>
              <?= e($c->getNom()) ?>
            </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-12">
          <label class="form-label fw-semibold">Mot de passe <?= $utilisateur ? '(laisser vide pour ne pas changer)' : '*' ?></label>
          <input type="password" name="mot_de_passe" class="form-control form-control-modern"
                 <?= $utilisateur ? '' : 'required' ?> minlength="6">
        </div>
      </div>
      <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-primary-modern"><i class="bi bi-check2 me-1"></i>Enregistrer</button>
        <a href="index.php?page=utilisateurs" class="btn btn-outline-secondary">Annuler</a>
      </div>
    </form>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
