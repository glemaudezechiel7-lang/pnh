<?php
/** Package entites */
class RapportIntervention
{
    private ?int $idRapport;
    private string $reference;
    private string $typeOperation;
    private ?string $description;
    private string $zoneGeographique;
    private int $idCommissariat;
    private int $idAgentResponsable;
    private int $effectifsDeployes;
    private string $dateIntervention;
    private ?string $resultats;
    private string $statut;

    public function __construct(
        string $reference = '',
        string $typeOperation = '',
        ?string $description = null,
        string $zoneGeographique = '',
        int $idCommissariat = 0,
        int $idAgentResponsable = 0,
        int $effectifsDeployes = 1,
        string $dateIntervention = '',
        ?string $resultats = null,
        string $statut = 'planifiee',
        ?int $idRapport = null
    ) {
        $this->idRapport = $idRapport;
        $this->reference = $reference;
        $this->typeOperation = $typeOperation;
        $this->description = $description;
        $this->zoneGeographique = $zoneGeographique;
        $this->idCommissariat = $idCommissariat;
        $this->idAgentResponsable = $idAgentResponsable;
        $this->effectifsDeployes = $effectifsDeployes;
        $this->dateIntervention = $dateIntervention;
        $this->resultats = $resultats;
        $this->statut = $statut;
    }

    public function getIdRapport(): ?int { return $this->idRapport; }
    public function setIdRapport(?int $v): void { $this->idRapport = $v; }
    public function getReference(): string { return $this->reference; }
    public function setReference(string $v): void { $this->reference = $v; }
    public function getTypeOperation(): string { return $this->typeOperation; }
    public function setTypeOperation(string $v): void { $this->typeOperation = $v; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $v): void { $this->description = $v; }
    public function getZoneGeographique(): string { return $this->zoneGeographique; }
    public function setZoneGeographique(string $v): void { $this->zoneGeographique = $v; }
    public function getIdCommissariat(): int { return $this->idCommissariat; }
    public function setIdCommissariat(int $v): void { $this->idCommissariat = $v; }
    public function getIdAgentResponsable(): int { return $this->idAgentResponsable; }
    public function setIdAgentResponsable(int $v): void { $this->idAgentResponsable = $v; }
    public function getEffectifsDeployes(): int { return $this->effectifsDeployes; }
    public function setEffectifsDeployes(int $v): void { $this->effectifsDeployes = $v; }
    public function getDateIntervention(): string { return $this->dateIntervention; }
    public function setDateIntervention(string $v): void { $this->dateIntervention = $v; }
    public function getResultats(): ?string { return $this->resultats; }
    public function setResultats(?string $v): void { $this->resultats = $v; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $v): void { $this->statut = $v; }
}
