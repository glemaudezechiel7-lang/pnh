<?php
/** Package controller */
class CommissariatController
{
    private CommissariatDAO $commissariatDAO;

    public function __construct()
    {
        $this->commissariatDAO = new CommissariatDAO();
    }

    public function liste(): void
    {
        requireAuth();
        $commissariats = $this->commissariatDAO->findAll();
        require __DIR__ . '/../vue/commissariats/liste.php';
    }

    public function formulaire(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $commissariat = $id ? $this->commissariatDAO->findById($id) : null;
        $erreurs = $_SESSION['erreurs_form'] ?? [];
        unset($_SESSION['erreurs_form']);
        require __DIR__ . '/../vue/commissariats/form.php';
    }

    public function enregistrer(): void
    {
        requireRole(['super_admin', 'admin']);
        $id = !empty($_POST['id_commissariat']) ? (int)$_POST['id_commissariat'] : null;
        $nom = trim($_POST['nom'] ?? '');
        $code = trim(strtoupper($_POST['code'] ?? ''));
        $departement = trim($_POST['departement'] ?? '');
        $commune = trim($_POST['commune'] ?? '');
        $adresse = trim($_POST['adresse'] ?? '');
        $telephone = trim($_POST['telephone'] ?? '');
        $dateCreation = $_POST['date_creation'] ?: null;

        $erreurs = [];
        if ($nom === '') $erreurs[] = "Le nom du commissariat est obligatoire.";
        if ($code === '') $erreurs[] = "Le code du commissariat est obligatoire.";
        if ($departement === '') $erreurs[] = "Le département est obligatoire.";
        if ($commune === '') $erreurs[] = "La commune est obligatoire.";
        if ($code !== '' && $this->commissariatDAO->codeExists($code, $id)) {
            $erreurs[] = "Ce code est déjà utilisé par un autre commissariat.";
        }

        $photo = null;
        if ($id) {
            $existant = $this->commissariatDAO->findById($id);
            $photo = $existant ? $existant->getPhoto() : null;
        }
        if (!empty($_FILES['photo']['name'])) {
            $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                $nomFichier = 'commissariat_' . uniqid() . '.' . $ext;
                $cheminDest = __DIR__ . '/../public/img/commissariats/' . $nomFichier;
                if (!is_dir(dirname($cheminDest))) mkdir(dirname($cheminDest), 0755, true);
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $cheminDest)) {
                    $photo = 'public/img/commissariats/' . $nomFichier;
                }
            }
        }

        if (!empty($erreurs)) {
            $_SESSION['erreurs_form'] = $erreurs;
            $redir = $id ? "index.php?page=commissariats&action=form&id=$id" : "index.php?page=commissariats&action=form";
            header('Location: ' . $redir);
            exit;
        }

        $commissariat = new Commissariat($nom, $code, $departement, $commune, $adresse, $telephone, $photo, $dateCreation, $id);

        if ($id) {
            $this->commissariatDAO->update($commissariat);
        } else {
            $this->commissariatDAO->create($commissariat);
        }

        header('Location: index.php?page=commissariats');
        exit;
    }

    public function supprimer(): void
    {
        requireRole(['super_admin']);
        $id = (int)($_GET['id'] ?? 0);
        $this->commissariatDAO->delete($id);
        header('Location: index.php?page=commissariats');
        exit;
    }
}
