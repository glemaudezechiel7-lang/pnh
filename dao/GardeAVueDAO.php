<?php
/** Package dao */
class GardeAVueDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT g.*, CONCAT(ag.prenom,' ',ag.nom) AS nom_agent, c.nom AS nom_commissariat
             FROM gardes_a_vue g
             JOIN agents ag ON g.id_agent_responsable = ag.id_agent
             JOIN commissariats c ON g.id_commissariat = c.id_commissariat
             ORDER BY g.date_heure_entree DESC"
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM gardes_a_vue WHERE id_garde = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(GardeAVue $g): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO gardes_a_vue (nom_suspect, prenom_suspect, date_naissance_suspect, piece_identite,
             motif, id_agent_responsable, id_commissariat, id_plainte, date_heure_entree, date_heure_sortie,
             type_sortie, observations)
             VALUES (:nom,:prenom,:dn,:piece,:motif,:agent,:com,:plainte,:entree,:sortie,:type,:obs)"
        );
        $stmt->execute([
            'nom' => $g->getNomSuspect(), 'prenom' => $g->getPrenomSuspect(),
            'dn' => $g->getDateNaissanceSuspect(), 'piece' => $g->getPieceIdentite(),
            'motif' => $g->getMotif(), 'agent' => $g->getIdAgentResponsable(),
            'com' => $g->getIdCommissariat(), 'plainte' => $g->getIdPlainte(),
            'entree' => $g->getDateHeureEntree(), 'sortie' => $g->getDateHeureSortie(),
            'type' => $g->getTypeSortie(), 'obs' => $g->getObservations(),
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(GardeAVue $g): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE gardes_a_vue SET nom_suspect=:nom, prenom_suspect=:prenom,
             date_naissance_suspect=:dn, piece_identite=:piece, motif=:motif,
             id_agent_responsable=:agent, id_commissariat=:com, id_plainte=:plainte,
             date_heure_entree=:entree, date_heure_sortie=:sortie, type_sortie=:type,
             observations=:obs WHERE id_garde=:id"
        );
        return $stmt->execute([
            'nom' => $g->getNomSuspect(), 'prenom' => $g->getPrenomSuspect(),
            'dn' => $g->getDateNaissanceSuspect(), 'piece' => $g->getPieceIdentite(),
            'motif' => $g->getMotif(), 'agent' => $g->getIdAgentResponsable(),
            'com' => $g->getIdCommissariat(), 'plainte' => $g->getIdPlainte(),
            'entree' => $g->getDateHeureEntree(), 'sortie' => $g->getDateHeureSortie(),
            'type' => $g->getTypeSortie(), 'obs' => $g->getObservations(), 'id' => $g->getIdGarde(),
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM gardes_a_vue WHERE id_garde=:id");
        return $stmt->execute(['id' => $id]);
    }

    public function countEnCours(): int
    {
        return (int)$this->pdo->query("SELECT COUNT(*) FROM gardes_a_vue WHERE type_sortie='en_cours'")->fetchColumn();
    }
}
