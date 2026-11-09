<?php
/** Package dao */
class PlainteDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT p.*, c.nom AS nom_commissariat,
                    CONCAT(a.prenom,' ',a.nom) AS nom_agent
             FROM plaintes p
             JOIN commissariats c ON p.id_commissariat = c.id_commissariat
             LEFT JOIN agents a ON p.id_agent_traitant = a.id_agent
             ORDER BY p.date_plainte DESC"
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM plaintes WHERE id_plainte = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function numeroExists(string $numero, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) FROM plaintes WHERE numero_plainte = :num";
        $params = ['num' => $numero];
        if ($excludeId) { $sql .= " AND id_plainte != :id"; $params['id'] = $excludeId; }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function findAllForSelect(): array
    {
        $stmt = $this->pdo->query("SELECT id_plainte, numero_plainte, nom_declarant FROM plaintes ORDER BY date_plainte DESC");
        return $stmt->fetchAll();
    }

    public function create(Plainte $p): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO plaintes (numero_plainte, nom_declarant, telephone_declarant, adresse_declarant,
             nature, description, date_plainte, lieu_incident, id_agent_traitant, id_commissariat, statut)
             VALUES (:num,:nomd,:teld,:adrd,:nature,:desc,:dp,:lieu,:agent,:com,:statut)"
        );
        $stmt->execute([
            'num' => $p->getNumeroPlainte(), 'nomd' => $p->getNomDeclarant(),
            'teld' => $p->getTelephoneDeclarant(), 'adrd' => $p->getAdresseDeclarant(),
            'nature' => $p->getNature(), 'desc' => $p->getDescription(), 'dp' => $p->getDatePlainte(),
            'lieu' => $p->getLieuIncident(), 'agent' => $p->getIdAgentTraitant(),
            'com' => $p->getIdCommissariat(), 'statut' => $p->getStatut(),
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(Plainte $p): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE plaintes SET numero_plainte=:num, nom_declarant=:nomd, telephone_declarant=:teld,
             adresse_declarant=:adrd, nature=:nature, description=:desc, date_plainte=:dp,
             lieu_incident=:lieu, id_agent_traitant=:agent, id_commissariat=:com, statut=:statut,
             date_cloture=:dc WHERE id_plainte=:id"
        );
        return $stmt->execute([
            'num' => $p->getNumeroPlainte(), 'nomd' => $p->getNomDeclarant(),
            'teld' => $p->getTelephoneDeclarant(), 'adrd' => $p->getAdresseDeclarant(),
            'nature' => $p->getNature(), 'desc' => $p->getDescription(), 'dp' => $p->getDatePlainte(),
            'lieu' => $p->getLieuIncident(), 'agent' => $p->getIdAgentTraitant(),
            'com' => $p->getIdCommissariat(), 'statut' => $p->getStatut(),
            'dc' => $p->getDateCloture(), 'id' => $p->getIdPlainte(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM plaintes WHERE id_plainte=:id");
        return $stmt->execute(['id' => $id]);
    }

    public function countByStatut(string $statut): int
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM plaintes WHERE statut = :s");
        $stmt->execute(['s' => $statut]);
        return (int)$stmt->fetchColumn();
    }
}
