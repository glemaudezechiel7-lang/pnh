<?php
/** Package controller */
class AgentController
{
    private AgentDAO $agentDAO;
    private CommissariatDAO $commissariatDAO;

    public function __construct()
    {
        $this->agentDAO = new AgentDAO();
        $this->commissariatDAO = new CommissariatDAO();
    }

    public function liste(): void
    {
        requireAuth();
        $agents = $this->agentDAO->findAll();
        require __DIR__ . '/../vue/agents/liste.php';
    }

    public function fiche(): void
    {
        requireAuth();
        $id = (int)($_GET['id'] ?? 0);
        $agent = $this->agentDAO->findById($id);
        if (!$agent) { header('Location: index.php?page=agents'); exit; }
        $affectationDAO = new AffectationDAO();
        $historique = $affectationDAO->findByAgent($id);
        require __DIR__ . '/../vue/agents/fiche.php';
    }

    public function formulaire(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $agent = $id ? $this->agentDAO->findById($id) : null;
        $commissariats = $this->commissariatDAO->findAll();
        $erreurs = $_SESSION['erreurs_form'] ?? [];
        unset($_SESSION['erreurs_form']);
        require __DIR__ . '/../vue/agents/form.php';
    }

    public function enregistrer(): void
    {
        requireRole(['super_admin', 'admin', 'gestionnaire']);
        $id = !empty($_POST['id_agent']) ? (int)$_POST['id_agent'] : null;
        $matricule = trim($_POST['matricule'] ?? '');
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $grade = $_POST['grade'] ?? '';
        $sexe = $_POST['sexe'] ?? 'M';
        $dateNaissance = $_POST['date_naissance'] ?? '';
        $telephone = trim($_POST['telephone'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        $idCommissariat = (int)($_POST['id_commissariat'] ?? 0);
        $dateEntree = $_POST['date_entree'] ?? '';
        $statut = $_POST['statut'] ?? 'en_service';

        $erreurs = [];
        if ($matricule === '') $erreurs[] = "Le matricule est obligatoire.";
        if ($nom === '') $erreurs[] = "Le nom est obligatoire.";
        if ($prenom === '') $erreurs[] = "Le prénom est obligatoire.";
        if ($grade === '') $erreurs[] = "Le grade est obligatoire.";
        if ($dateNaissance === '') $erreurs[] = "La date de naissance est obligatoire.";
        if ($idCommissariat <= 0) $erreurs[] = "Le commissariat d'affectation est obligatoire.";
        if ($dateEntree === '') $erreurs[] = "La date d'entrée en service est obligatoire.";
        if ($dateNaissance !== '' && $dateEntree !== '' && strtotime($dateEntree) < strtotime($dateNaissance)) {
            $erreurs[] = "La date d'entrée ne peut précéder la date de naissance.";
        }
        if ($matricule !== '' && $this->agentDAO->matriculeExists($matricule, $id)) {
            $erreurs[] = "Ce matricule est déjà attribué à un autre agent.";
        }

        // Gestion de la photo (optionnelle)
        $photo = null;
        if ($id) {
            $existant = $this->agentDAO->findById($id);
            $photo = $existant ? $existant->getPhoto() : null;
        }
        if (!empty($_FILES['photo']['name'])) {
            $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $nomFichier = 'agent_' . uniqid() . '.' . $ext;
                $cheminDest = __DIR__ . '/../public/img/agents/' . $nomFichier;
                if (!is_dir(dirname($cheminDest))) mkdir(dirname($cheminDest), 0755, true);
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $cheminDest)) {
                    $photo = 'public/img/agents/' . $nomFichier;
                }
            } else {
                $erreurs[] = "Format de photo non supporté (jpg, png, webp uniquement).";
            }
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            $redir = $id ? "index.php?page=agents&action=form&id=$id" : "index.php?page=agents&action=form";
            header('Location: ' . $redir);
            exit;
        }

        $agent = new Agent($matricule, $nom, $prenom, $grade, $sexe, $dateNaissance, $telephone,
            $adresse, $photo, $idCommissariat, $dateEntree, $statut, $id);

        if ($id) {
            $this->agentDAO->update($agent);
        } else {
            $nouvelId = $this->agentDAO->create($agent);
            // Création automatique de l'affectation initiale
            $affectationDAO = new AffectationDAO();
            $affectation = new Affectation($nouvelId, $idCommissariat, 'Poste général', 'initiale', $dateEntree);
            $affectationDAO->create($affectation);
        }

        header('Location: index.php?page=agents');
        exit;
    }

    public function supprimer(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = (int)($_GET['id'] ?? 0);
        $this->agentDAO->delete($id);
        header('Location: index.php?page=agents');
        exit;
    }
}
