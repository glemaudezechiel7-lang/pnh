<?php
/**
 * index.php — Front Controller unique de l'application
 * Gestion PNH — Police Nationale d'Haïti
 * Toute requête transite par ce fichier (architecture MVC stricte).
 */

require_once __DIR__ . '/config/config.php';

$page = $_GET['page'] ?? null;
$action = $_GET['action'] ?? null;

try {
    // ------------------------------------------------------------
    // Actions d'authentification (indépendantes de "page")
    // ------------------------------------------------------------
    if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        (new AuthController())->traiterLogin();
        exit;
    }
    if ($action === 'logout') {
        (new AuthController())->deconnexion();
        exit;
    }

    // ------------------------------------------------------------
    // Page d'accueil publique (aucune page demandée)
    // ------------------------------------------------------------
    if ($page === null) {
        require __DIR__ . '/vue/accueil.php';
        exit;
    }

    // ------------------------------------------------------------
    // Page de connexion
    // ------------------------------------------------------------
    if ($page === 'login') {
        (new AuthController())->afficherLogin();
        exit;
    }

    // ------------------------------------------------------------
    // Routes protégées (nécessitent une session active)
    // ------------------------------------------------------------
    switch ($page) {

        case 'dashboard':
            (new DashboardController())->afficher();
            break;

        // ---------------- AGENTS ----------------
        case 'agents':
            $ctrl = new AgentController();
            match ($action) {
                'form'       => $ctrl->formulaire(),
                'fiche'      => $ctrl->fiche(),
                'enregistrer'=> $ctrl->enregistrer(),
                'supprimer'  => $ctrl->supprimer(),
                default      => $ctrl->liste(),
            };
            break;

        // ---------------- AFFECTATIONS ----------------
        case 'affectations':
            $ctrl = new AffectationController();
            match ($action) {
                'form'       => $ctrl->formulaire(),
                'enregistrer'=> $ctrl->enregistrer(),
                'supprimer'  => $ctrl->supprimer(),
                default      => $ctrl->liste(),
            };
            break;

        // ---------------- PLAINTES ----------------
        case 'plaintes':
            $ctrl = new PlainteController();
            match ($action) {
                'form'       => $ctrl->formulaire(),
                'enregistrer'=> $ctrl->enregistrer(),
                'supprimer'  => $ctrl->supprimer(),
                default      => $ctrl->liste(),
            };
            break;

        // ---------------- GARDES A VUE ----------------
        case 'gardes':
            $ctrl = new GardeAVueController();
            match ($action) {
                'form'       => $ctrl->formulaire(),
                'enregistrer'=> $ctrl->enregistrer(),
                'supprimer'  => $ctrl->supprimer(),
                default      => $ctrl->liste(),
            };
            break;

        // ---------------- RAPPORTS D'INTERVENTION ----------------
        case 'rapports':
            $ctrl = new RapportInterventionController();
            match ($action) {
                'form'       => $ctrl->formulaire(),
                'enregistrer'=> $ctrl->enregistrer(),
                'supprimer'  => $ctrl->supprimer(),
                default      => $ctrl->liste(),
            };
            break;

        // ---------------- EQUIPEMENTS / ARMEMENT ----------------
        case 'equipements':
            $ctrl = new EquipementController();
            match ($action) {
                'form'                  => $ctrl->formulaire(),
                'enregistrer'           => $ctrl->enregistrer(),
                'attribuer'             => $ctrl->formulaireAttribution(),
                'enregistrer_attribution'=> $ctrl->enregistrerAttribution(),
                'retour'                => $ctrl->enregistrerRetour(),
                'supprimer'             => $ctrl->supprimer(),
                default                 => $ctrl->liste(),
            };
            break;

        // ---------------- COMMISSARIATS ----------------
        case 'commissariats':
            $ctrl = new CommissariatController();
            match ($action) {
                'form'       => $ctrl->formulaire(),
                'enregistrer'=> $ctrl->enregistrer(),
                'supprimer'  => $ctrl->supprimer(),
                default      => $ctrl->liste(),
            };
            break;

        // ---------------- UTILISATEURS (module transversal) ----------------
        case 'utilisateurs':
            $ctrl = new UtilisateurController();
            match ($action) {
                'form'       => $ctrl->formulaire(),
                'enregistrer'=> $ctrl->enregistrer(),
                'toggle'     => $ctrl->toggleStatut(),
                'supprimer'  => $ctrl->supprimer(),
                default      => $ctrl->liste(),
            };
            break;

        default:
            http_response_code(404);
            echo "<div style='padding:60px;text-align:center;font-family:sans-serif'>
                    <h1>404</h1><p>Page introuvable.</p>
                    <a href='index.php?page=dashboard'>Retour au tableau de bord</a>
                  </div>";
    }
} catch (Throwable $e) {
    http_response_code(500);
    // En production, ne jamais exposer le message brut : journaliser plutôt qu'afficher.
    echo "<div style='padding:60px;text-align:center;font-family:sans-serif'>
            <h1>Erreur</h1><p>Une erreur inattendue est survenue. Veuillez réessayer.</p>
            <a href='index.php'>Retour à l'accueil</a>
          </div>";
    // error_log($e->getMessage());
}
