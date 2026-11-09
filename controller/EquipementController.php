<?php
/** Package controller */
class EquipementController
{
    private EquipementDAO $equipementDAO;
    private AttributionEquipementDAO $attributionDAO;
    private AgentDAO $agentDAO;
    private CommissariatDAO $commissariatDAO;

    public function __construct()
    {
        $this->equipementDAO = new EquipementDAO();
        $this->attributionDAO = new AttributionEquipementDAO();
        $this->agentDAO = new AgentDAO();
        $this->commissariatDAO = new CommissariatDAO();
    }

    public function liste(): void
    {
        requireAuth();
        $equipements = $this->equipementDAO->findAll();
        $attributions = $this->attributionDAO->findAll();
        require __DIR__ . '/../vue/equipements/liste.php';
    }

    public function formulaire(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $equipement = $id ? $this->equipementDAO->findById($id) : null;
        $commissariats = $this->commissariatDAO->findAll();
        $erreurs = $_SESSION['erreurs_form'] ?? [];
        unset($_SESSION['erreurs_form']);
        require __DIR__ . '/../vue/equipements/form.php';
    }

    public function enregistrer(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $id = !empty($_POST['id_equipement']) ? (int)$_POST['id_equipement'] : null;
        $numeroSerie = trim($_POST['numero_serie'] ?? '');
        $type = $_POST['type_equipement'] ?? '';
        $designation = trim($_POST['designation'] ?? '');
        $idCommissariat = (int)($_POST['id_commissariat'] ?? 0);
        $etat = $_POST['etat'] ?? 'bon_etat';
        $dateAcquisition = $_POST['date_acquisition'] ?: null;

        $erreurs = [];
        if ($numeroSerie === '') $erreurs[] = "Le numéro de série est obligatoire.";
        if ($type === '') $erreurs[] = "Le type d'équipement est obligatoire.";
        if ($designation === '') $erreurs[] = "La désignation est obligatoire.";
        if ($idCommissariat <= 0) $erreurs[] = "Le commissariat (armurerie) est obligatoire.";
        if ($numeroSerie !== '' && $this->equipementDAO->numeroSerieExists($numeroSerie, $id)) {
            $erreurs[] = "Ce numéro de série est déjà enregistré.";
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            $redir = $id ? "index.php?page=equipements&action=form&id=$id" : "index.php?page=equipements&action=form";
            header('Location: ' . $redir);
            exit;
        }

        $equipement = new Equipement($numeroSerie, $type, $designation, $idCommissariat, $etat, $dateAcquisition, $id);

        if ($id) {
            $this->equipementDAO->update($equipement);
        } else {
            $this->equipementDAO->create($equipement);
        }

        header('Location: index.php?page=equipements');
        exit;
    }

    public function formulaireAttribution(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $equipements = $this->equipementDAO->findAllForSelect();
        $agents = $this->agentDAO->findAllForSelect();
        $erreurs = $_SESSION['erreurs_form'] ?? [];
        unset($_SESSION['erreurs_form']);
        require __DIR__ . '/../vue/equipements/form_attribution.php';
    }

    public function enregistrerAttribution(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $idEquipement = (int)($_POST['id_equipement'] ?? 0);
        $idAgent = (int)($_POST['id_agent'] ?? 0);
        $dateAttribution = $_POST['date_attribution'] ?? '';
        $observations = trim($_POST['observations'] ?? '');

        $erreurs = [];
        if ($idEquipement <= 0) $erreurs[] = "Veuillez sélectionner un équipement.";
        if ($idAgent <= 0) $erreurs[] = "Veuillez sélectionner un agent.";
        if ($dateAttribution === '') $erreurs[] = "La date d'attribution est obligatoire.";

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            header('Location: index.php?page=equipements&action=attribuer');
            exit;
        }

        $attribution = new AttributionEquipement($idEquipement, $idAgent, $dateAttribution, null, null, 'en_possession', $observations);
        $this->attributionDAO->create($attribution);
        $this->equipementDAO->updateEtat($idEquipement, 'bon_etat');

        header('Location: index.php?page=equipements');
        exit;
    }

    public function enregistrerRetour(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $idAttribution = (int)($_POST['id_attribution'] ?? 0);
        $etatRetour = $_POST['etat_retour'] ?? 'bon_etat';
        $observations = trim($_POST['observations_retour'] ?? '');

        $attribution = $this->attributionDAO->findById($idAttribution);
        if ($attribution) {
            $this->attributionDAO->enregistrerRetour($idAttribution, $etatRetour, $observations);
            $this->equipementDAO->updateEtat((int)$attribution['id_equipement'], $etatRetour);
        }

        header('Location: index.php?page=equipements');
        exit;
    }

    public function supprimer(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = (int)($_GET['id'] ?? 0);
        $this->equipementDAO->delete($id);
        header('Location: index.php?page=equipements');
        exit;
    }
}
