<?php
/** Package controller */
class RapportInterventionController
{
    private RapportInterventionDAO $rapportDAO;
    private AgentDAO $agentDAO;
    private CommissariatDAO $commissariatDAO;

    public function __construct()
    {
        $this->rapportDAO = new RapportInterventionDAO();
        $this->agentDAO = new AgentDAO();
        $this->commissariatDAO = new CommissariatDAO();
    }

    public function liste(): void
    {
        requireAuth();
        $rapports = $this->rapportDAO->findAll();
        require __DIR__ . '/../vue/rapports/liste.php';
    }

    public function formulaire(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $rapport = $id ? $this->rapportDAO->findById($id) : null;
        $agents = $this->agentDAO->findAllForSelect();
        $commissariats = $this->commissariatDAO->findAll();
        $erreurs = $_SESSION['erreurs_form'] ?? [];
        unset($_SESSION['erreurs_form']);
        require __DIR__ . '/../vue/rapports/form.php';
    }

    private function genererReference(): string
    {
        return 'OP-' . date('Y') . '-' . str_pad((string)random_int(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    public function enregistrer(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $id = !empty($_POST['id_rapport']) ? (int)$_POST['id_rapport'] : null;
        $typeOperation = trim($_POST['type_operation'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $zoneGeographique = trim($_POST['zone_geographique'] ?? '');
        $idCommissariat = (int)($_POST['id_commissariat'] ?? 0);
        $idAgentResponsable = (int)($_POST['id_agent_responsable'] ?? 0);
        $effectifs = (int)($_POST['effectifs_deployes'] ?? 1);
        $dateIntervention = $_POST['date_intervention'] ?? '';
        $resultats = trim($_POST['resultats'] ?? '');
        $statut = $_POST['statut'] ?? 'planifiee';

        $erreurs = [];
        if ($typeOperation === '') $erreurs[] = "Le type d'opération est obligatoire.";
        if ($zoneGeographique === '') $erreurs[] = "La zone géographique est obligatoire.";
        if ($idCommissariat <= 0) $erreurs[] = "Le commissariat est obligatoire.";
        if ($idAgentResponsable <= 0) $erreurs[] = "L'agent responsable est obligatoire.";
        if ($effectifs <= 0) $erreurs[] = "Les effectifs déployés doivent être supérieurs à zéro.";
        if ($dateIntervention === '') $erreurs[] = "La date d'intervention est obligatoire.";

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            $redir = $id ? "index.php?page=rapports&action=form&id=$id" : "index.php?page=rapports&action=form";
            header('Location: ' . $redir);
            exit;
        }

        $reference = $id ? ($_POST['reference'] ?? $this->genererReference()) : $this->genererReference();

        $rapport = new RapportIntervention($reference, $typeOperation, $description, $zoneGeographique,
            $idCommissariat, $idAgentResponsable, $effectifs, $dateIntervention, $resultats, $statut, $id);

        if ($id) {
            $this->rapportDAO->update($rapport);
        } else {
            $this->rapportDAO->create($rapport);
        }

        header('Location: index.php?page=rapports');
        exit;
    }

    public function supprimer(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = (int)($_GET['id'] ?? 0);
        $this->rapportDAO->delete($id);
        header('Location: index.php?page=rapports');
        exit;
    }
}
