<?php
/** Package controller */
class UtilisateurController
{
    private UtilisateurDAO $utilisateurDAO;
    private CommissariatDAO $commissariatDAO;

    public function __construct()
    {
        $this->utilisateurDAO = new UtilisateurDAO();
        $this->commissariatDAO = new CommissariatDAO();
    }

    public function liste(): void
    {
        requireRole(['super_admin', 'admin']);
        $utilisateurs = $this->utilisateurDAO->findAll();
        require __DIR__ . '/../vue/utilisateurs/liste.php';
    }

    public function formulaire(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $utilisateur = $id ? $this->utilisateurDAO->findById($id) : null;
        $commissariats = $this->commissariatDAO->findAll();
        $erreurs = $_SESSION['erreurs_form'] ?? [];
        unset($_SESSION['erreurs_form']);
        require __DIR__ . '/../vue/utilisateurs/form.php';
    }

    public function enregistrer(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = !empty($_POST['id_utilisateur']) ? (int)$_POST['id_utilisateur'] : null;
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $login = trim($_POST['login'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = $_POST['role'] ?? 'operateur';
        $idCommissariat = !empty($_POST['id_commissariat']) ? (int)$_POST['id_commissariat'] : null;
        $motDePasse = $_POST['mot_de_passe'] ?? '';

        $erreurs = [];
        if ($nom === '') $erreurs[] = "Le nom est obligatoire.";
        if ($prenom === '') $erreurs[] = "Le prénom est obligatoire.";
        if ($login === '' || strlen($login) < 3) $erreurs[] = "Le login doit contenir au moins 3 caractères.";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurs[] = "L'adresse email n'est pas valide.";
        if (!in_array($role, ['super_admin', 'admin', 'gestionnaire', 'operateur'], true)) {
            $erreurs[] = "Le rôle sélectionné n'est pas valide.";
        }
        if (!$id && strlen($motDePasse) < 6) {
            $erreurs[] = "Le mot de passe doit contenir au moins 6 caractères.";
        }
        if ($login !== '' && $email !== '' && $this->utilisateurDAO->loginOrEmailExists($login, $email, $id)) {
            $erreurs[] = "Ce login ou cet email est déjà utilisé par un autre compte.";
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            $redir = $id ? "index.php?page=utilisateurs&action=form&id=$id" : "index.php?page=utilisateurs&action=form";
            header('Location: ' . $redir);
            exit;
        }

        $utilisateur = new Utilisateur($nom, $prenom, $login, $email, '', $role, $idCommissariat, 'actif', $id);

        if ($id) {
            $this->utilisateurDAO->update($utilisateur);
            if ($motDePasse !== '') {
                $this->utilisateurDAO->updateMotDePasse($id, password_hash($motDePasse, PASSWORD_DEFAULT));
            }
        } else {
            $utilisateur->setMotDePasse(password_hash($motDePasse, PASSWORD_DEFAULT));
            $this->utilisateurDAO->create($utilisateur);
        }

        header('Location: index.php?page=utilisateurs');
        exit;
    }

    public function toggleStatut(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = (int)($_GET['id'] ?? 0);
        if ($id === (int)$_SESSION['utilisateur_id']) {
            header('Location: index.php?page=utilisateurs');
            exit;
        }
        $this->utilisateurDAO->toggleStatut($id);
        header('Location: index.php?page=utilisateurs');
        exit;
    }

    public function supprimer(): void
    {
        requireRole(['super_admin']);
        $id = (int)($_GET['id'] ?? 0);
        $cible = $this->utilisateurDAO->findById($id);
        if ($cible && $cible->getRole() === 'super_admin' && $this->utilisateurDAO->countSuperAdmins() <= 1) {
            header('Location: index.php?page=utilisateurs');
            exit;
        }
        $this->utilisateurDAO->delete($id);
        header('Location: index.php?page=utilisateurs');
        exit;
    }
}
