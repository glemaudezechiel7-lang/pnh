<?php
/** Package dao */
class RapportInterventionDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT r.*, c.nom AS nom_commissariat, CONCAT(a.prenom,' ',a.nom) AS nom_agent
             FROM rapports_interventions r
             JOIN commissariats c ON r.id_commissariat = c.id_commissariat
             JOIN agents a ON r.id_agent_responsable = a.id_agent
             ORDER BY r.date_intervention DESC"
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM rapports_interventions WHERE id_rapport = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function referenceExists(string $ref, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM rapports_interventions WHERE reference = :ref";
        $params = ['ref' => $ref];
        if ($excludeId) { $sql .= " AND id_rapport != :id"; $params['id'] = $excludeId; }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function create(RapportIntervention $r): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO rapports_interventions (reference, type_operation, description, zone_geographique,
             id_commissariat, id_agent_responsable, effectifs_deployes, date_intervention, resultats, statut)
             VALUES (:ref,:type,:desc,:zone,:com,:agent,:eff,:date,:res,:statut)"
        );
        $stmt->execute([
            'ref' => $r->getReference(), 'type' => $r->getTypeOperation(), 'desc' => $r->getDescription(),
            'zone' => $r->getZoneGeographique(), 'com' => $r->getIdCommissariat(),
            'agent' => $r->getIdAgentResponsable(), 'eff' => $r->getEffectifsDeployes(),
            'date' => $r->getDateIntervention(), 'res' => $r->getResultats(), 'statut' => $r->getStatut(),
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(RapportIntervention $r): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE rapports_interventions SET reference=:ref, type_operation=:type, description=:desc,
             zone_geographique=:zone, id_commissariat=:com, id_agent_responsable=:agent,
             effectifs_deployes=:eff, date_intervention=:date, resultats=:res, statut=:statut
             WHERE id_rapport=:id"
        );
        return $stmt->execute([
            'ref' => $r->getReference(), 'type' => $r->getTypeOperation(), 'desc' => $r->getDescription(),
            'zone' => $r->getZoneGeographique(), 'com' => $r->getIdCommissariat(),
            'agent' => $r->getIdAgentResponsable(), 'eff' => $r->getEffectifsDeployes(),
            'date' => $r->getDateIntervention(), 'res' => $r->getResultats(), 'statut' => $r->getStatut(),
            'id' => $r->getIdRapport(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM rapports_interventions WHERE id_rapport=:id");
        return $stmt->execute(['id' => $id]);
    }

    public function countCeMois(): int
    {
        return (int)$this->pdo->query(
            "SELECT COUNT(*) FROM rapports_interventions
             WHERE MONTH(date_intervention)=MONTH(CURDATE()) AND YEAR(date_intervention)=YEAR(CURDATE())"
        )->fetchColumn();
    }
}
