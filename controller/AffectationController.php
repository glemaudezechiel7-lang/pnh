<?php
/** Package controller */
class AffectationController
{
    private AffectationDAO $affectationDAO;
    private AgentDAO $agentDAO;
    private CommissariatDAO $commissariatDAO;

    public function __construct()
    {
        $this->affectationDAO = new AffectationDAO();
        $this->agentDAO = new AgentDAO();
        $this->commissariatDAO = new CommissariatDAO();
    }

    public function liste(): void
    {
        requireAuth();
        $affectations = $this->affectationDAO->findAll();
        require __DIR__ . '/../vue/affectations/liste.php';
    }

    public function formulaire(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $agents = $this->agentDAO->findAllForSelect();
        $commissariats = $this->commissariatDAO->findAll();
        $erreurs = $_SESSION['erreurs_form'] ?? [];
        unset($_SESSION['erreurs_form']);
        require __DIR__ . '/../vue/affectations/form.php';
    }

    public function enregistrer(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $idAgent = (int)($_POST['id_agent'] ?? 0);
        $idCommissariat = (int)($_POST['id_commissariat'] ?? 0);
        $poste = trim($_POST['poste'] ?? '');
        $type = $_POST['type_affectation'] ?? 'initiale';
        $dateDebut = $_POST['date_debut'] ?? '';
        $motif = trim($_POST['motif'] ?? '');

        $erreurs = [];
        if ($idAgent <= 0) $erreurs[] = "Veuillez sélectionner un agent.";
        if ($idCommissariat <= 0) $erreurs[] = "Veuillez sélectionner un commissariat.";
        if ($poste === '') $erreurs[] = "Le poste de travail est obligatoire.";
        if ($dateDebut === '') $erreurs[] = "La date de début est obligatoire.";
        if (in_array($type, ['mutation', 'rotation'], true) && $motif === '') {
            $erreurs[] = "Le motif est obligatoire pour une mutation ou une rotation.";
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            header('Location: index.php?page=affectations&action=form');
            exit;
        }

        // Clôture des affectations précédentes actives de l'agent (une seule affectation active à la fois)
        $this->affectationDAO->cloturerAnciennesAffectations($idAgent);

        $affectation = new Affectation($idAgent, $idCommissariat, $poste, $type, $dateDebut, null, $motif, 'active');
        $this->affectationDAO->create($affectation);

        // Met à jour le commissariat courant de l'agent
        $agent = $this->agentDAO->findById($idAgent);
        if ($agent) {
            $agent->setIdCommissariat($idCommissariat);
            $this->agentDAO->update($agent);
        }

        header('Location: index.php?page=affectations');
        exit;
    }

    public function supprimer(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = (int)($_GET['id'] ?? 0);
        $this->affectationDAO->delete($id);
        header('Location: index.php?page=affectations');
        exit;
    }
}
