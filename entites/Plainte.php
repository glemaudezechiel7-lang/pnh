<?php
/** Package entites */
class Plainte
{
    private ?int $idPlainte;
    private string $numeroPlainte;
    private string $nomDeclarant;
    private ?string $telephoneDeclarant;
    private ?string $adresseDeclarant;
    private string $nature;
    private ?string $description;
    private string $datePlainte;
    private ?string $lieuIncident;
    private ?int $idAgentTraitant;
    private int $idCommissariat;
    private string $statut;
    private ?string $dateCloture;

    public function __construct(
        string $numeroPlainte = '',
        string $nomDeclarant = '',
        ?string $telephoneDeclarant = null,
        ?string $adresseDeclarant = null,
        string $nature = '',
        ?string $description = null,
        string $datePlainte = '',
        ?string $lieuIncident = null,
        ?int $idAgentTraitant = null,
        int $idCommissariat = 0,
        string $statut = 'ouverte',
        ?string $dateCloture = null,
        ?int $idPlainte = null
    ) {
        $this->idPlainte = $idPlainte;
        $this->numeroPlainte = $numeroPlainte;
        $this->nomDeclarant = $nomDeclarant;
        $this->telephoneDeclarant = $telephoneDeclarant;
        $this->adresseDeclarant = $adresseDeclarant;
        $this->nature = $nature;
        $this->description = $description;
        $this->datePlainte = $datePlainte;
        $this->lieuIncident = $lieuIncident;
        $this->idAgentTraitant = $idAgentTraitant;
        $this->idCommissariat = $idCommissariat;
        $this->statut = $statut;
        $this->dateCloture = $dateCloture;
    }

    public function getIdPlainte(): ?int { return $this->idPlainte; }
    public function setIdPlainte(?int $v): void { $this->idPlainte = $v; }
    public function getNumeroPlainte(): string { return $this->numeroPlainte; }
    public function setNumeroPlainte(string $v): void { $this->numeroPlainte = $v; }
    public function getNomDeclarant(): string { return $this->nomDeclarant; }
    public function setNomDeclarant(string $v): void { $this->nomDeclarant = $v; }
    public function getTelephoneDeclarant(): ?string { return $this->telephoneDeclarant; }
    public function setTelephoneDeclarant(?string $v): void { $this->telephoneDeclarant = $v; }
    public function getAdresseDeclarant(): ?string { return $this->adresseDeclarant; }
    public function setAdresseDeclarant(?string $v): void { $this->adresseDeclarant = $v; }
    public function getNature(): string { return $this->nature; }
    public function setNature(string $v): void { $this->nature = $v; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $v): void { $this->description = $v; }
    public function getDatePlainte(): string { return $this->datePlainte; }
    public function setDatePlainte(string $v): void { $this->datePlainte = $v; }
    public function getLieuIncident(): ?string { return $this->lieuIncident; }
    public function setLieuIncident(?string $v): void { $this->lieuIncident = $v; }
    public function getIdAgentTraitant(): ?int { return $this->idAgentTraitant; }
    public function setIdAgentTraitant(?int $v): void { $this->idAgentTraitant = $v; }
    public function getIdCommissariat(): int { return $this->idCommissariat; }
    public function setIdCommissariat(int $v): void { $this->idCommissariat = $v; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $v): void { $this->statut = $v; }
    public function getDateCloture(): ?string { return $this->dateCloture; }
    public function setDateCloture(?string $v): void { $this->dateCloture = $v; }
}
