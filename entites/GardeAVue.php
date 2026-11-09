<?php
/** Package entites */
class GardeAVue
{
    private ?int $idGarde;
    private string $nomSuspect;
    private ?string $prenomSuspect;
    private ?string $dateNaissanceSuspect;
    private ?string $pieceIdentite;
    private string $motif;
    private int $idAgentResponsable;
    private int $idCommissariat;
    private ?int $idPlainte;
    private string $dateHeureEntree;
    private ?string $dateHeureSortie;
    private string $typeSortie;
    private ?string $observations;

    public function __construct(
        string $nomSuspect = '',
        ?string $prenomSuspect = null,
        ?string $dateNaissanceSuspect = null,
        ?string $pieceIdentite = null,
        string $motif = '',
        int $idAgentResponsable = 0,
        int $idCommissariat = 0,
        ?int $idPlainte = null,
        string $dateHeureEntree = '',
        ?string $dateHeureSortie = null,
        string $typeSortie = 'en_cours',
        ?string $observations = null,
        ?int $idGarde = null
    ) {
        $this->idGarde = $idGarde;
        $this->nomSuspect = $nomSuspect;
        $this->prenomSuspect = $prenomSuspect;
        $this->dateNaissanceSuspect = $dateNaissanceSuspect;
        $this->pieceIdentite = $pieceIdentite;
        $this->motif = $motif;
        $this->idAgentResponsable = $idAgentResponsable;
        $this->idCommissariat = $idCommissariat;
        $this->idPlainte = $idPlainte;
        $this->dateHeureEntree = $dateHeureEntree;
        $this->dateHeureSortie = $dateHeureSortie;
        $this->typeSortie = $typeSortie;
        $this->observations = $observations;
    }

    public function getIdGarde(): ?int { return $this->idGarde; }
    public function setIdGarde(?int $v): void { $this->idGarde = $v; }
    public function getNomSuspect(): string { return $this->nomSuspect; }
    public function setNomSuspect(string $v): void { $this->nomSuspect = $v; }
    public function getPrenomSuspect(): ?string { return $this->prenomSuspect; }
    public function setPrenomSuspect(?string $v): void { $this->prenomSuspect = $v; }
    public function getDateNaissanceSuspect(): ?string { return $this->dateNaissanceSuspect; }
    public function setDateNaissanceSuspect(?string $v): void { $this->dateNaissanceSuspect = $v; }
    public function getPieceIdentite(): ?string { return $this->pieceIdentite; }
    public function setPieceIdentite(?string $v): void { $this->pieceIdentite = $v; }
    public function getMotif(): string { return $this->motif; }
    public function setMotif(string $v): void { $this->motif = $v; }
    public function getIdAgentResponsable(): int { return $this->idAgentResponsable; }
    public function setIdAgentResponsable(int $v): void { $this->idAgentResponsable = $v; }
    public function getIdCommissariat(): int { return $this->idCommissariat; }
    public function setIdCommissariat(int $v): void { $this->idCommissariat = $v; }
    public function getIdPlainte(): ?int { return $this->idPlainte; }
    public function setIdPlainte(?int $v): void { $this->idPlainte = $v; }
    public function getDateHeureEntree(): string { return $this->dateHeureEntree; }
    public function setDateHeureEntree(string $v): void { $this->dateHeureEntree = $v; }
    public function getDateHeureSortie(): ?string { return $this->dateHeureSortie; }
    public function setDateHeureSortie(?string $v): void { $this->dateHeureSortie = $v; }
    public function getTypeSortie(): string { return $this->typeSortie; }
    public function setTypeSortie(string $v): void { $this->typeSortie = $v; }
    public function getObservations(): ?string { return $this->observations; }
    public function setObservations(?string $v): void { $this->observations = $v; }
}
