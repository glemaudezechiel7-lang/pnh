<?php
/** Package entites */
class Equipement
{
    private ?int $idEquipement;
    private string $numeroSerie;
    private string $typeEquipement;
    private string $designation;
    private int $idCommissariat;
    private string $etat;
    private ?string $dateAcquisition;

    public function __construct(
        string $numeroSerie = '',
        string $typeEquipement = '',
        string $designation = '',
        int $idCommissariat = 0,
        string $etat = 'bon_etat',
        ?string $dateAcquisition = null,
        ?int $idEquipement = null
    ) {
        $this->idEquipement = $idEquipement;
        $this->numeroSerie = $numeroSerie;
        $this->typeEquipement = $typeEquipement;
        $this->designation = $designation;
        $this->idCommissariat = $idCommissariat;
        $this->etat = $etat;
        $this->dateAcquisition = $dateAcquisition;
    }

    public function getIdEquipement(): ?int { return $this->idEquipement; }
    public function setIdEquipement(?int $v): void { $this->idEquipement = $v; }
    public function getNumeroSerie(): string { return $this->numeroSerie; }
    public function setNumeroSerie(string $v): void { $this->numeroSerie = $v; }
    public function getTypeEquipement(): string { return $this->typeEquipement; }
    public function setTypeEquipement(string $v): void { $this->typeEquipement = $v; }
    public function getDesignation(): string { return $this->designation; }
    public function setDesignation(string $v): void { $this->designation = $v; }
    public function getIdCommissariat(): int { return $this->idCommissariat; }
    public function setIdCommissariat(int $v): void { $this->idCommissariat = $v; }
    public function getEtat(): string { return $this->etat; }
    public function setEtat(string $v): void { $this->etat = $v; }
    public function getDateAcquisition(): ?string { return $this->dateAcquisition; }
    public function setDateAcquisition(?string $v): void { $this->dateAcquisition = $v; }
}
