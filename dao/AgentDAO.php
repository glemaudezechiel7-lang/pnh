<?php
/** Package dao */
class AgentDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
    }

    private function mapper(array $row): Agent
    {
        return new Agent(
            $row['matricule'], $row['nom'], $row['prenom'], $row['grade'], $row['sexe'],
            $row['date_naissance'], $row['telephone'], $row['adresse'], $row['photo'],
            (int)$row['id_commissariat'], $row['date_entree'], $row['statut'], (int)$row['id_agent']
        );
    }

    public function findAll(?int $idCommissariat = null): array
    {
        $sql = "SELECT a.*, c.nom AS nom_commissariat FROM agents a
                JOIN commissariats c ON a.id_commissariat = c.id_commissariat";
        $params = [];
        if ($idCommissariat) {
            $sql .= " WHERE a.id_commissariat = :com";
            $params['com'] = $idCommissariat;
        }
        $sql .= " ORDER BY a.nom, a.prenom";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?Agent
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agents WHERE id_agent = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $this->mapper($row) : null;
    }

    public function findAllForSelect(): array
    {
        $stmt = $this->pdo->query(
            "SELECT id_agent, matricule, nom, prenom FROM agents WHERE statut='en_service' ORDER BY nom"
        );
        return $stmt->fetchAll();
    }

    public function matriculeExists(string $matricule, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM agents WHERE matricule = :mat";
        $params = ['mat' => $matricule];
        if ($excludeId) { $sql .= " AND id_agent != :id"; $params['id'] = $excludeId; }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function create(Agent $a): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO agents (matricule, nom, prenom, grade, sexe, date_naissance, telephone,
             adresse, photo, id_commissariat, date_entree, statut)
             VALUES (:mat,:nom,:prenom,:grade,:sexe,:dn,:tel,:adr,:photo,:com,:de,:statut)"
        );
        $stmt->execute([
            'mat' => $a->getMatricule(), 'nom' => $a->getNom(), 'prenom' => $a->getPrenom(),
            'grade' => $a->getGrade(), 'sexe' => $a->getSexe(), 'dn' => $a->getDateNaissance(),
            'tel' => $a->getTelephone(), 'adr' => $a->getAdresse(), 'photo' => $a->getPhoto(),
            'com' => $a->getIdCommissariat(), 'de' => $a->getDateEntree(), 'statut' => $a->getStatut(),
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(Agent $a): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE agents SET matricule=:mat, nom=:nom, prenom=:prenom, grade=:grade, sexe=:sexe,
             date_naissance=:dn, telephone=:tel, adresse=:adr, photo=:photo, id_commissariat=:com,
             date_entree=:de, statut=:statut WHERE id_agent=:id"
        );
        return $stmt->execute([
            'mat' => $a->getMatricule(), 'nom' => $a->getNom(), 'prenom' => $a->getPrenom(),
            'grade' => $a->getGrade(), 'sexe' => $a->getSexe(), 'dn' => $a->getDateNaissance(),
            'tel' => $a->getTelephone(), 'adr' => $a->getAdresse(), 'photo' => $a->getPhoto(),
            'com' => $a->getIdCommissariat(), 'de' => $a->getDateEntree(), 'statut' => $a->getStatut(),
            'id' => $a->getIdAgent(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM agents WHERE id_agent=:id");
        return $stmt->execute(['id' => $id]);
    }

    public function countByStatut(string $statut): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM agents WHERE statut = :s");
        $stmt->execute(['s' => $statut]);
        return (int)$stmt->fetchColumn();
    }

    public function countTotal(): int
    {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM agents")->fetchColumn();
    }
}
