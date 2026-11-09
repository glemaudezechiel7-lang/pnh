<?php
/** Package entites */
class Affectation
{
    private ?int $idAffectation;
    private int $idAgent;
    private int $idCommissariat;
    private string $poste;
    private string $typeAffectation;
    private string $dateDebut;
    private ?string $dateFin;
    private ?string $motif;
    private string $statut;

    public function __construct(
        int $idAgent = 0,
        int $idCommissariat = 0,
        string $poste = '',
        string $typeAffectation = 'initiale',
        string $dateDebut = '',
        ?string $dateFin = null,
        ?string $motif = null,
        string $statut = 'active',
        ?int $idAffectation = null
    ) {
        $this->idAffectation = $idAffectation;
        $this->idAgent = $idAgent;
        $this->idCommissariat = $idCommissariat;
        $this->poste = $poste;
        $this->typeAffectation = $typeAffectation;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->motif = $motif;
        $this->statut = $statut;
    }

    public function getIdAffectation(): ?int { return $this->idAffectation; }
    public function setIdAffectation(?int $v): void { $this->idAffectation = $v; }
    public function getIdAgent(): int { return $this->idAgent; }
    public function setIdAgent(int $v): void { $this->idAgent = $v; }
    public function getIdCommissariat(): int { return $this->idCommissariat; }
    public function setIdCommissariat(int $v): void { $this->idCommissariat = $v; }
    public function getPoste(): string { return $this->poste; }
    public function setPoste(string $v): void { $this->poste = $v; }
    public function getTypeAffectation(): string { return $this->typeAffectation; }
    public function setTypeAffectation(string $v): void { $this->typeAffectation = $v; }
    public function getDateDebut(): string { return $this->dateDebut; }
    public function setDateDebut(string $v): void { $this->dateDebut = $v; }
    public function getDateFin(): ?string { return $this->dateFin; }
    public function setDateFin(?string $v): void { $this->dateFin = $v; }
    public function getMotif(): ?string { return $this->motif; }
    public function setMotif(?string $v): void { $this->motif = $v; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $v): void { $this->statut = $v; }
}
