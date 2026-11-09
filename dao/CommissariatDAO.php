<?php
/** Package dao */
class CommissariatDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
    }

    private function mapper(array $row): Commissariat
    {
        return new Commissariat(
            $row['nom'], $row['code'], $row['departement'], $row['commune'],
            $row['adresse'], $row['telephone'], $row['photo'], $row['date_creation'],
            (int)$row['id_commissariat']
        );
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM commissariats ORDER BY nom");
        return array_map([$this, 'mapper'], $stmt->fetchAll());
    }

    public function findById(int $id): ?Commissariat
    {
        $stmt = $this->pdo->prepare("SELECT * FROM commissariats WHERE id_commissariat = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ? $this->mapper($row) : null;
    }

    public function codeExists(string $code, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM commissariats WHERE code = :code";
        $params = ['code' => $code];
        if ($excludeId) { $sql .= " AND id_commissariat != :id"; $params['id'] = $excludeId; }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function create(Commissariat $c): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO commissariats (nom, code, departement, commune, adresse, telephone, photo, date_creation)
             VALUES (:nom,:code,:dep,:com,:adr,:tel,:photo,:dc)"
        );
        $stmt->execute([
            'nom' => $c->getNom(), 'code' => $c->getCode(), 'dep' => $c->getDepartement(),
            'com' => $c->getCommune(), 'adr' => $c->getAdresse(), 'tel' => $c->getTelephone(),
            'photo' => $c->getPhoto(), 'dc' => $c->getDateCreation(),
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(Commissariat $c): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE commissariats SET nom=:nom, code=:code, departement=:dep, commune=:com,
             adresse=:adr, telephone=:tel, photo=:photo, date_creation=:dc WHERE id_commissariat=:id"
        );
        return $stmt->execute([
            'nom' => $c->getNom(), 'code' => $c->getCode(), 'dep' => $c->getDepartement(),
            'com' => $c->getCommune(), 'adr' => $c->getAdresse(), 'tel' => $c->getTelephone(),
            'photo' => $c->getPhoto(), 'dc' => $c->getDateCreation(), 'id' => $c->getIdCommissariat(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM commissariats WHERE id_commissariat=:id");
        return $stmt->execute(['id' => $id]);
    }
}
