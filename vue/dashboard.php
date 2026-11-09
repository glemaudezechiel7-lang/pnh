<?php
/** Package vue */
$titrePage = "Tableau de bord";
require __DIR__ . '/layout/header.php';
?>
<div class="row g-4 mb-2">
  <div class="col-sm-6 col-lg-3">
    <div class="stat-card">
      <div class="stat-icon bg-icon-blue"><i class="bi bi-person-badge"></i></div>
      <h3><?= (int)$stats['agents_en_service'] ?> / <?= (int)$stats['agents_total'] ?></h3>
      <span class="label">Agents en service</span>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="stat-card">
      <div class="stat-icon bg-icon-red"><i class="bi bi-file-earmark-text"></i></div>
      <h3><?= (int)$stats['plaintes_ouvertes'] ?></h3>
      <span class="label">Plaintes ouvertes / en cours</span>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="stat-card">
      <div class="stat-icon bg-icon-gold"><i class="bi bi-shield-lock"></i></div>
      <h3><?= (int)$stats['gardes_en_cours'] ?></h3>
      <span class="label">Gardes à vue en cours</span>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <div class="stat-card">
      <div class="stat-icon bg-icon-green"><i class="bi bi-clipboard-data"></i></div>
      <h3><?= (int)$stats['operations_du_mois'] ?></h3>
      <span class="label">Opérations ce mois-ci</span>
    </div>
  </div>
</div>

<div class="row g-4 mt-1">
  <div class="col-lg-4">
    <div class="card-panel">
      <div class="card-panel-header">
        <span class="fw-bold"><i class="bi bi-file-earmark-text me-2"></i>Dernières plaintes</span>
        <a href="index.php?page=plaintes" class="small">Voir tout</a>
      </div>
      <div class="card-panel-body">
        <?php if (empty($dernieresPlaintes)): ?>
          <p class="text-muted small mb-0">Aucune plainte enregistrée.</p>
        <?php else: foreach ($dernieresPlaintes as $p): ?>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <div class="fw-semibold"><?= e($p['nom_declarant']) ?></div>
              <div class="text-muted small"><?= e($p['nature']) ?></div>
            </div>
            <span class="badge-statut badge-<?= e($p['statut']) ?>"><?= e(str_replace('_',' ',$p['statut'])) ?></span>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card-panel">
      <div class="card-panel-header">
        <span class="fw-bold"><i class="bi bi-shield-lock me-2"></i>Gardes à vue récentes</span>
        <a href="index.php?page=gardes" class="small">Voir tout</a>
      </div>
      <div class="card-panel-body">
        <?php if (empty($dernieresGardes)): ?>
          <p class="text-muted small mb-0">Aucune garde à vue enregistrée.</p>
        <?php else: foreach ($dernieresGardes as $g): ?>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <div class="fw-semibold"><?= e($g['nom_suspect']) ?> <?= e($g['prenom_suspect']) ?></div>
              <div class="text-muted small"><?= e($g['motif']) ?></div>
            </div>
            <span class="badge-statut badge-<?= e($g['type_sortie']) ?>"><?= e(str_replace('_',' ',$g['type_sortie'])) ?></span>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="card-panel">
      <div class="card-panel-header">
        <span class="fw-bold"><i class="bi bi-clipboard-data me-2"></i>Dernières interventions</span>
        <a href="index.php?page=rapports" class="small">Voir tout</a>
      </div>
      <div class="card-panel-body">
        <?php if (empty($derniersRapports)): ?>
          <p class="text-muted small mb-0">Aucune intervention enregistrée.</p>
        <?php else: foreach ($derniersRapports as $r): ?>
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <div class="fw-semibold"><?= e($r['type_operation']) ?></div>
              <div class="text-muted small"><?= e($r['zone_geographique']) ?></div>
            </div>
            <span class="badge-statut badge-<?= e($r['statut']) ?>"><?= e(str_replace('_',' ',$r['statut'])) ?></span>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/layout/footer.php'; ?>
