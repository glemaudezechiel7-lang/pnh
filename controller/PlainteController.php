<?php
/** Package controller */
class PlainteController
{
    private PlainteDAO $plainteDAO;
    private AgentDAO $agentDAO;
    private CommissariatDAO $commissariatDAO;

    public function __construct()
    {
        $this->plainteDAO = new PlainteDAO();
        $this->agentDAO = new AgentDAO();
        $this->commissariatDAO = new CommissariatDAO();
    }

    public function liste(): void
    {
        requireAuth();
        $plaintes = $this->plainteDAO->findAll();
        require __DIR__ . '/../vue/plaintes/liste.php';
    }

    public function formulaire(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire', 'operateur']);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $plainte = $id ? $this->plainteDAO->findById($id) : null;
        $agents = $this->agentDAO->findAllForSelect();
        $commissariats = $this->commissariatDAO->findAll();
        $erreurs = $_SESSION['erreurs_form'] ?? [];
        unset($_SESSION['erreurs_form']);
        require __DIR__ . '/../vue/plaintes/form.php';
    }

    private function genererNumero(): string
    {
        return 'PL-' . date('Y') . '-' . str_pad((string)random_int(1, 99999), 5, '0', STR_PAD_LEFT);
    }

    public function enregistrer(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire', 'operateur']);
        $id = !empty($_POST['id_plainte']) ? (int)$_POST['id_plainte'] : null;
        $nomDeclarant = trim($_POST['nom_declarant'] ?? '');
        $telephoneDeclarant = trim($_POST['telephone_declarant'] ?? '');
        $adresseDeclarant = trim($_POST['adresse_declarant'] ?? '');
        $nature = trim($_POST['nature'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $datePlainte = $_POST['date_plainte'] ?? '';
        $lieuIncident = trim($_POST['lieu_incident'] ?? '');
        $idAgentTraitant = !empty($_POST['id_agent_traitant']) ? (int)$_POST['id_agent_traitant'] : null;
        $idCommissariat = (int)($_POST['id_commissariat'] ?? 0);
        $statut = $_POST['statut'] ?? 'ouverte';

        $erreurs = [];
        if ($nomDeclarant === '') $erreurs[] = "Le nom du déclarant est obligatoire.";
        if ($nature === '') $erreurs[] = "La nature de la plainte est obligatoire.";
        if ($datePlainte === '') $erreurs[] = "La date de la plainte est obligatoire.";
        if ($idCommissariat <= 0) $erreurs[] = "Le commissariat est obligatoire.";

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            $redir = $id ? "index.php?page=plaintes&action=form&id=$id" : "index.php?page=plaintes&action=form";
            header('Location: ' . $redir);
            exit;
        }

        $dateCloture = ($statut === 'cloturee' || $statut === 'classee_sans_suite') ? date('Y-m-d H:i:s') : null;
        $numero = $id ? ($_POST['numero_plainte'] ?? $this->genererNumero()) : $this->genererNumero();

        $plainte = new Plainte($numero, $nomDeclarant, $telephoneDeclarant, $adresseDeclarant, $nature,
            $description, $datePlainte, $lieuIncident, $idAgentTraitant, $idCommissariat, $statut, $dateCloture, $id);

        if ($id) {
            $this->plainteDAO->update($plainte);
        } else {
            $this->plainteDAO->create($plainte);
        }

        header('Location: index.php?page=plaintes');
        exit;
    }

    public function supprimer(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = (int)($_GET['id'] ?? 0);
        $this->plainteDAO->delete($id);
        header('Location: index.php?page=plaintes');
        exit;
    }
}
