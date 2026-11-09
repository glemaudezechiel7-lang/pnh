<?php
/** Package dao */
class AttributionEquipementDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT at.*, e.designation, e.numero_serie, CONCAT(a.prenom,' ',a.nom) AS nom_agent
             FROM attributions_equipements at
             JOIN equipements e ON at.id_equipement = e.id_equipement
             JOIN agents a ON at.id_agent = a.id_agent
             ORDER BY at.date_attribution DESC"
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM attributions_equipements WHERE id_attribution = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(AttributionEquipement $a): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO attributions_equipements (id_equipement, id_agent, date_attribution,
             date_retour, etat_retour, statut, observations)
             VALUES (:eq,:agent,:da,:dr,:er,:statut,:obs)"
        );
        $stmt->execute([
            'eq' => $a->getIdEquipement(), 'agent' => $a->getIdAgent(), 'da' => $a->getDateAttribution(),
            'dr' => $a->getDateRetour(), 'er' => $a->getEtatRetour(), 'statut' => $a->getStatut(),
            'obs' => $a->getObservations(),
        ]);
        // L'équipement passe en "attribué" implicitement via le statut de l'attribution
        return (int)$this->pdo->lastInsertId();
    }

    public function enregistrerRetour(int $idAttribution, string $etatRetour, ?string $observations): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE attributions_equipements SET date_retour = NOW(), etat_retour = :etat,
             statut = 'retourne', observations = :obs WHERE id_attribution = :id"
        );
        return $stmt->execute(['etat' => $etatRetour, 'obs' => $observations, 'id' => $idAttribution]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM attributions_equipements WHERE id_attribution=:id");
        return $stmt->execute(['id' => $id]);
    }
}
