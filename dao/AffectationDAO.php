<?php
/** Package dao */
class AffectationDAO
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connexion::getInstance();
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            "SELECT af.*, a.nom AS nom_agent, a.prenom AS prenom_agent, a.matricule,
                    c.nom AS nom_commissariat
             FROM affectations af
             JOIN agents a ON af.id_agent = a.id_agent
             JOIN commissariats c ON af.id_commissariat = c.id_commissariat
             ORDER BY af.date_debut DESC"
        );
        return $stmt->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM affectations WHERE id_affectation = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function findByAgent(int $idAgent): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT af.*, c.nom AS nom_commissariat FROM affectations af
             JOIN commissariats c ON af.id_commissariat = c.id_commissariat
             WHERE af.id_agent = :id ORDER BY af.date_debut DESC"
        );
        $stmt->execute(['id' => $idAgent]);
        return $stmt->fetchAll();
    }

    public function create(Affectation $a): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO affectations (id_agent, id_commissariat, poste, type_affectation,
             date_debut, date_fin, motif, statut)
             VALUES (:agent,:com,:poste,:type,:debut,:fin,:motif,:statut)"
        );
        $stmt->execute([
            'agent' => $a->getIdAgent(), 'com' => $a->getIdCommissariat(), 'poste' => $a->getPoste(),
            'type' => $a->getTypeAffectation(), 'debut' => $a->getDateDebut(), 'fin' => $a->getDateFin(),
            'motif' => $a->getMotif(), 'statut' => $a->getStatut(),
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function update(Affectation $a): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE affectations SET id_agent=:agent, id_commissariat=:com, poste=:poste,
             type_affectation=:type, date_debut=:debut, date_fin=:fin, motif=:motif, statut=:statut
             WHERE id_affectation=:id"
        );
        return $stmt->execute([
            'agent' => $a->getIdAgent(), 'com' => $a->getIdCommissariat(), 'poste' => $a->getPoste(),
            'type' => $a->getTypeAffectation(), 'debut' => $a->getDateDebut(), 'fin' => $a->getDateFin(),
            'motif' => $a->getMotif(), 'statut' => $a->getStatut(), 'id' => $a->getIdAffectation(),
        ]);
    }

    public function cloturerAnciennesAffectations(int $idAgent): void
    {
        $stmt = $this->pdo->prepare(
            "UPDATE affectations SET statut='terminee', date_fin=CURDATE()
             WHERE id_agent=:agent AND statut='active'"
        );
        $stmt->execute(['agent' => $idAgent]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM affectations WHERE id_affectation=:id");
        return $stmt->execute(['id' => $id]);
    }
}
