<?php
/** Package vue */
$titrePage = "Gestion des utilisateurs";
require __DIR__ . '/../layout/header.php';
$roleUser = $_SESSION['utilisateur_role'];
?>
<div class="card-panel">
  <div class="card-panel-header">
    <span class="fw-bold"><i class="bi bi-people me-2"></i>Comptes utilisateurs (<?= count($utilisateurs) ?>)</span>
    <a href="index.php?page=utilisateurs&action=form" class="btn btn-primary-modern btn-sm"><i class="bi bi-plus-lg me-1"></i>Nouvel utilisateur</a>
  </div>
  <div class="card-panel-body table-responsive">
    <table class="table table-modern align-middle">
      <thead><tr><th>Nom</th><th>Login</th><th>Email</th><th>Rôle</th><th>Commissariat</th><th>Statut</th><th class="text-end">Actions</th></tr></thead>
      <tbody>
        <?php if (empty($utilisateurs)): ?>
        <tr><td colspan="7" class="text-center text-muted py-4">Aucun utilisateur enregistré.</td></tr>
        <?php else: foreach ($utilisateurs as $u): ?>
        <tr>
          <td class="fw-semibold"><?= e($u['prenom'].' '.$u['nom']) ?></td>
          <td><?= e($u['login']) ?></td>
          <td><?= e($u['email']) ?></td>
          <td><span class="user-role-badge role-<?= e($u['role']) ?>"><?= e(ucfirst(str_replace('_',' ',$u['role']))) ?></span></td>
          <td><?= e($u['nom_commissariat'] ?? '—') ?></td>
          <td><span class="badge-statut badge-<?= e($u['statut']) ?>"><?= e(ucfirst($u['statut'])) ?></span></td>
          <td class="text-end">
            <a href="index.php?page=utilisateurs&action=form&id=<?= (int)$u['id_utilisateur'] ?>" class="btn-action"><i class="bi bi-pencil"></i></a>
            <?php if ((int)$u['id_utilisateur'] !== (int)$_SESSION['utilisateur_id']): ?>
            <a href="index.php?page=utilisateurs&action=toggle&id=<?= (int)$u['id_utilisateur'] ?>" class="btn-action" title="Activer/Désactiver">
              <i class="bi bi-power"></i>
            </a>
            <?php if ($roleUser === 'super_admin'): ?>
            <a href="index.php?page=utilisateurs&action=supprimer&id=<?= (int)$u['id_utilisateur'] ?>" class="btn-action danger"
               data-confirm-delete="Supprimer définitivement ce compte ?"><i class="bi bi-trash"></i></a>
            <?php endif; ?>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
