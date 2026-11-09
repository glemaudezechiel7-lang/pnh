<?php
/** Package dao */
class UtilisateurDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
    }

    private function mapper(array $row): Utilisateur
    {
        return new Utilisateur(
            $row['nom'], $row['prenom'], $row['login'], $row['email'], $row['mot_de_passe'],
            $row['role'], $row['id_commissariat'] !== null ? (int)$row['id_commissariat'] : null,
            $row['statut'], (int)$row['id_utilisateur'], $row['derniere_connexion']
        );
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT u.*, c.nom AS nom_commissariat FROM utilisateurs u
             LEFT JOIN commissariats c ON u.id_commissariat = c.id_commissariat
             ORDER BY u.nom, u.prenom"
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?Utilisateur
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $this->mapper($row) : null;
    }

    public function findByLogin(string $login): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateurs WHERE login = :login");
        $stmt->execute(['login' => $login]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function loginOrEmailExists(string $login, string $email, ?int 
$excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM utilisateurs WHERE (login = :login OR email = :email)";
        $params = ['login' => $login, 'email' => $email];
        if ($excludeId) {
            $sql .= " AND id_utilisateur != :id";
            $params['id'] = $excludeId;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function create(Utilisateur $u): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO utilisateurs (nom, prenom, login, email, mot_de_passe, role, id_commissariat, statut)
             VALUES (:nom, :prenom, :login, :email, :mdp, :role, :commissariat, :statut)"
        );
        $stmt->execute([
            'nom' => $u->getNom(), 'prenom' => $u->getPrenom(), 'login' => $u->getLogin(),
            'email' => $u->getEmail(), 'mdp' => $u->getMotDePasse(), 'role' => $u->getRole(),
            'commissariat' => $u->getIdCommissariat(), 'statut' => $u->getStatut(),
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(Utilisateur $u): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE utilisateurs SET nom=:nom, prenom=:prenom, login=:login, email=:email,
             role=:role, id_commissariat=:commissariat, statut=:statut WHERE id_utilisateur=:id"
        );
        return $stmt->execute([
            'nom' => $u->getNom(), 'prenom' => $u->getPrenom(), 'login' => $u->getLogin(),
            'email' => $u->getEmail(), 'role' => $u->getRole(),
            'commissariat' => $u->getIdCommissariat(), 'statut' => $u->getStatut(),
            'id' => $u->getIdUtilisateur(),
        ]);
    }

    public function updateMotDePasse(int $id, string $hash): bool
    {
        $stmt = $this->pdo->prepare("UPDATE utilisateurs SET mot_de_passe=:mdp WHERE id_utilisateur=:id");
        return $stmt->execute(['mdp' => $hash, 'id' => $id]);
    }

    public function toggleStatut(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE utilisateurs SET statut = IF(statut='actif','inactif','actif') WHERE id_utilisateur=:id"
        );
        return $stmt->execute(['id' => $id]);
    }

    public function updateDerniereConnexion(int $id): void
    {
        $stmt = $this->pdo->prepare("UPDATE utilisateurs SET derniere_connexion = NOW() WHERE id_utilisateur=:id");
        $stmt->execute(['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM utilisateurs WHERE id_utilisateur=:id");
        return $stmt->execute(['id' => $id]);
    }

    public function countSuperAdmins(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM utilisateurs WHERE role='super_admin' AND statut='actif'");
        return (int)$stmt->fetchColumn();
    }
}
