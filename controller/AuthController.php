<?php
/** Package controller */
class AuthController
{
    private UtilisateurDAO $utilisateurDAO;

    public function __construct()
    {
        $this->utilisateurDAO = new UtilisateurDAO();
    }

    public function afficherLogin(): void
    {
        if (!empty($_SESSION['utilisateur_id'])) {
            header('Location: index.php?page=dashboard');
            exit;
        }
        $erreur = $_SESSION['erreur_login'] ?? null;
        unset($_SESSION['erreur_login']);
        require __DIR__ . '/../vue/login.php';
    }

    public function traiterLogin(): void
    {
        $login = trim($_POST['login'] ?? '');
        $motDePasse = $_POST['mot_de_passe'] ?? '';

        if ($login === '' || $motDePasse === '') {
            $_SESSION['erreur_login'] = "Veuillez renseigner votre identifiant et votre mot de passe.";
            header('Location: index.php?page=login');
            exit;
        }

        $row = $this->utilisateurDAO->findByLogin($login);

        if (!$row || !password_verify($motDePasse, $row['mot_de_passe'])) {
            $_SESSION['erreur_login'] = "Identifiant ou mot de passe incorrect.";
            header('Location: index.php?page=login');
            exit;
        }

        if ($row['statut'] !== 'actif') {
            $_SESSION['erreur_login'] = "Ce compte a été désactivé. Contactez l'administrateur.";
            header('Location: index.php?page=login');
            exit;
        }

        $_SESSION['utilisateur_id'] = (int)$row['id_utilisateur'];
        $_SESSION['utilisateur_nom'] = $row['prenom'] . ' ' . $row['nom'];
        $_SESSION['utilisateur_role'] = $row['role'];
        $_SESSION['utilisateur_commissariat'] = $row['id_commissariat'];

        $this->utilisateurDAO->updateDerniereConnexion((int)$row['id_utilisateur']);

        header('Location: index.php?page=dashboard');
        exit;
    }

    public function deconnexion(): void
    {
        $_SESSION = [];
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
