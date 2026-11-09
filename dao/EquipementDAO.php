<?php
/** Package dao */
class EquipementDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT e.*, c.nom AS nom_commissariat FROM equipements e
             JOIN commissariats c ON e.id_commissariat = c.id_commissariat
             ORDER BY e.designation"
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM equipements WHERE id_equipement = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function findAllForSelect(): array
    {
        $stmt = $this->pdo->query(
            "SELECT id_equipement, numero_serie, designation FROM equipements
             WHERE etat != 'hors_service' AND etat != 'perdu' ORDER BY designation"
        );
        return $stmt->fetchAll();
    }

    public function numeroSerieExists(string $num, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM equipements WHERE numero_serie = :num";
        $params = ['num' => $num];
        if ($excludeId) { $sql .= " AND id_equipement != :id"; $params['id'] = $excludeId; }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function create(Equipement $e): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO equipements (numero_serie, type_equipement, designation, id_commissariat, etat, date_acquisition)
             VALUES (:num,:type,:desig,:com,:etat,:da)"
        );
        $stmt->execute([
            'num' => $e->getNumeroSerie(), 'type' => $e->getTypeEquipement(),
            'desig' => $e->getDesignation(), 'com' => $e->getIdCommissariat(),
            'etat' => $e->getEtat(), 'da' => $e->getDateAcquisition(),
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(Equipement $e): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE equipements SET numero_serie=:num, type_equipement=:type, designation=:desig,
             id_commissariat=:com, etat=:etat, date_acquisition=:da WHERE id_equipement=:id"
        );
        return $stmt->execute([
            'num' => $e->getNumeroSerie(), 'type' => $e->getTypeEquipement(),
            'desig' => $e->getDesignation(), 'com' => $e->getIdCommissariat(),
            'etat' => $e->getEtat(), 'da' => $e->getDateAcquisition(), 'id' => $e->getIdEquipement(),
        ]);
    }

    public function updateEtat(int $id, string $etat): bool
    {
        $stmt = $this->pdo->prepare("UPDATE equipements SET etat=:etat WHERE id_equipement=:id");
        return $stmt->execute(['etat' => $etat, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM equipements WHERE id_equipement=:id");
        return $stmt->execute(['id' => $id]);
    }
}
