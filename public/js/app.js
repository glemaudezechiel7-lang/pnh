document.addEventListener('DOMContentLoaded', function () {
  // Ouverture / fermeture du menu latéral sur mobile.
  // Utilise la délégation d'événements (sur document) plutôt qu'un binding direct :
  // ça fonctionne même si le bouton est cloné/réinjecté, et évite tout souci de
  // timing si ce script venait à se charger avant que le DOM soit totalement prêt.
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');

  function ouvrirMenu() {
    if (sidebar) sidebar.classList.add('open');
    if (overlay) overlay.classList.add('visible');
  }

  function fermerMenu() {
    if (sidebar) sidebar.classList.remove('open');
    if (overlay) overlay.classList.remove('visible');
  }

  function toggleMenu() {
    if (!sidebar) return;
    if (sidebar.classList.contains('open')) {
      fermerMenu();
    } else {
      ouvrirMenu();
    }
  }

  document.addEventListener('click', function (e) {
    const burger = e.target.closest('#burgerBtn');
    if (burger) {
      e.preventDefault();
      toggleMenu();
      return;
    }
    // Clic sur l'overlay (en dehors du menu) : on referme
    if (e.target.closest('#sidebarOverlay')) {
      fermerMenu();
      return;
    }
    // Clic sur un lien du menu (mobile) : on referme après navigation
    if (sidebar && sidebar.classList.contains('open') && e.target.closest('.sidebar-nav .nav-link')) {
      fermerMenu();
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') fermerMenu();
  });

  // Confirmation avant toute suppression
  document.querySelectorAll('[data-confirm-delete]').forEach(function (el) {
    el.addEventListener('click', function (e) {
      const msg = el.getAttribute('data-confirm-delete') || 'Confirmez-vous cette suppression ?';
      if (!confirm(msg)) {
        e.preventDefault();
      }
    });
  });

  // Fermeture automatique des alertes après 5 secondes
  document.querySelectorAll('.alert-auto').forEach(function (alertEl) {
    setTimeout(function () {
      alertEl.style.transition = 'opacity .4s ease';
      alertEl.style.opacity = '0';
      setTimeout(function () { alertEl.remove(); }, 400);
    }, 5000);
  });
});
