<?php
/** Package vue */
$titrePage = "Fiche de l'agent";
require __DIR__ . '/../layout/header.php';
?>
<div class="row g-4">
  <div class="col-lg-4">
    <div class="card-panel text-center card-panel-body">
      <img src="<?= e($agent->getPhoto() ?: 'public/img/avatar-default.svg') ?>" class="rounded-circle mb-3"
           style="width:120px;height:120px;object-fit:cover;">
      <h4 class="fw-bold mb-0"><?= e($agent->getNomComplet()) ?></h4>
      <p class="text-muted"><?= e($agent->getGrade()) ?> — Matricule <?= e($agent->getMatricule()) ?></p>
      <span class="badge-statut badge-<?= e($agent->getStatut()) ?>"><?= e(str_replace('_',' ',$agent->getStatut())) ?></span>

      <hr>
      <div class="text-start small">
        <p><i class="bi bi-telephone me-2"></i><?= e($agent->getTelephone() ?: 'Non renseigné') ?></p>
        <p><i class="bi bi-geo-alt me-2"></i><?= e($agent->getAdresse() ?: 'Non renseignée') ?></p>
        <p><i class="bi bi-calendar-event me-2"></i>Né(e) le <?= e(date('d/m/Y', strtotime($agent->getDateNaissance()))) ?></p>
        <p><i class="bi bi-calendar-check me-2"></i>Entré(e) en service le <?= e(date('d/m/Y', strtotime($agent->getDateEntree()))) ?></p>
      </div>
      <a href="index.php?page=agents" class="btn btn-outline-secondary btn-sm mt-2">
        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
      </a>
    </div>
  </div>

  <div class="col-lg-8">
    <div class="card-panel">
      <div class="card-panel-header">
        <span class="fw-bold"><i class="bi bi-arrow-left-right me-2"></i>Historique des affectations</span>
      </div>
      <div class="card-panel-body table-responsive">
        <table class="table table-modern">
          <thead><tr><th>Commissariat</th><th>Poste</th><th>Type</th><th>Début</th><th>Fin</th><th>Statut</th></tr></thead>
          <tbody>
            <?php if (empty($historique)): ?>
            <tr><td colspan="6" class="text-center text-muted py-3">Aucune affectation enregistrée.</td></tr>
            <?php else: foreach ($historique as $h): ?>
            <tr>
              <td><?= e($h['nom_commissariat']) ?></td>
              <td><?= e($h['poste']) ?></td>
              <td><?= e(ucfirst($h['type_affectation'])) ?></td>
              <td><?= e(date('d/m/Y', strtotime($h['date_debut']))) ?></td>
              <td><?= $h['date_fin'] ? e(date('d/m/Y', strtotime($h['date_fin']))) : '—' ?></td>
              <td><span class="badge-statut badge-<?= e($h['statut']) ?>"><?= e(ucfirst($h['statut'])) ?></span></td>
            </tr>
            <?php endforeach; endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
