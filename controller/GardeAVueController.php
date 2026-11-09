<?php
/** Package controller */
class GardeAVueController
{
    private GardeAVueDAO $gardeDAO;
    private AgentDAO $agentDAO;
    private CommissariatDAO $commissariatDAO;
    private PlainteDAO $plainteDAO;

    public function __construct()
    {
        $this->gardeDAO = new GardeAVueDAO();
        $this->agentDAO = new AgentDAO();
        $this->commissariatDAO = new CommissariatDAO();
        $this->plainteDAO = new PlainteDAO();
    }

    public function liste(): void
    {
        requireAuth();
        $gardes = $this->gardeDAO->findAll();
        require __DIR__ . '/../vue/gardes/liste.php';
    }

    public function formulaire(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire', 'operateur']);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $garde = $id ? $this->gardeDAO->findById($id) : null;
        $agents = $this->agentDAO->findAllForSelect();
        $commissariats = $this->commissariatDAO->findAll();
        $plaintes = $this->plainteDAO->findAllForSelect();
        $erreurs = $_SESSION['erreurs_form'] ?? [];
        unset($_SESSION['erreurs_form']);
        require __DIR__ . '/../vue/gardes/form.php';
    }

    public function enregistrer(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire', 'operateur']);
        $id = !empty($_POST['id_garde']) ? (int)$_POST['id_garde'] : null;
        $nomSuspect = trim($_POST['nom_suspect'] ?? '');
        $prenomSuspect = trim($_POST['prenom_suspect'] ?? '');
        $dateNaissanceSuspect = $_POST['date_naissance_suspect'] ?: null;
        $pieceIdentite = trim($_POST['piece_identite'] ?? '');
        $motif = trim($_POST['motif'] ?? '');
        $idAgentResponsable = (int)($_POST['id_agent_responsable'] ?? 0);
        $idCommissariat = (int)($_POST['id_commissariat'] ?? 0);
        $idPlainte = !empty($_POST['id_plainte']) ? (int)$_POST['id_plainte'] : null;
        $dateHeureEntree = $_POST['date_heure_entree'] ?? '';
        $dateHeureSortie = $_POST['date_heure_sortie'] ?: null;
        $typeSortie = $_POST['type_sortie'] ?? 'en_cours';
        $observations = trim($_POST['observations'] ?? '');

        $erreurs = [];
        if ($nomSuspect === '') $erreurs[] = "Le nom du suspect est obligatoire.";
        if ($motif === '') $erreurs[] = "Le motif de la garde à vue est obligatoire.";
        if ($idAgentResponsable <= 0) $erreurs[] = "L'agent responsable est obligatoire.";
        if ($idCommissariat <= 0) $erreurs[] = "Le commissariat est obligatoire.";
        if ($dateHeureEntree === '') $erreurs[] = "La date et l'heure d'entrée sont obligatoires.";
        if ($typeSortie !== 'en_cours' && $dateHeureSortie === null) {
            $erreurs[] = "La date de sortie est obligatoire lorsque le suspect n'est plus en garde à vue.";
        }
        if ($dateHeureSortie && $dateHeureEntree && strtotime($dateHeureSortie) < strtotime($dateHeureEntree)) {
            $erreurs[] = "La date de sortie ne peut précéder la date d'entrée.";
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            $redir = $id ? "index.php?page=gardes&action=form&id=$id" : "index.php?page=gardes&action=form";
            header('Location: ' . $redir);
            exit;
        }

        $garde = new GardeAVue($nomSuspect, $prenomSuspect, $dateNaissanceSuspect, $pieceIdentite, $motif,
            $idAgentResponsable, $idCommissariat, $idPlainte, $dateHeureEntree, $dateHeureSortie,
            $typeSortie, $observations, $id);

        if ($id) {
            $this->gardeDAO->update($garde);
        } else {
            $this->gardeDAO->create($garde);
        }

        header('Location: index.php?page=gardes');
        exit;
    }

    public function supprimer(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = (int)($_GET['id'] ?? 0);
        $this->gardeDAO->delete($id);
        header('Location: index.php?page=gardes');
        exit;
    }
}
