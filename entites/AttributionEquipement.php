<?php
/** Package entites */
class AttributionEquipement
{
    private ?int $idAttribution;
    private int $idEquipement;
    private int $idAgent;
    private string $dateAttribution;
    private ?string $dateRetour;
    private ?string $etatRetour;
    private string $statut;
    private ?string $observations;

    public function __construct(
        int $idEquipement = 0,
        int $idAgent = 0,
        string $dateAttribution = '',
        ?string $dateRetour = null,
        ?string $etatRetour = null,
        string $statut = 'en_possession',
        ?string $observations = null,
        ?int $idAttribution = null
    ) {
        $this->idAttribution = $idAttribution;
        $this->idEquipement = $idEquipement;
        $this->idAgent = $idAgent;
        $this->dateAttribution = $dateAttribution;
        $this->dateRetour = $dateRetour;
        $this->etatRetour = $etatRetour;
        $this->statut = $statut;
        $this->observations = $observations;
    }

    public function getIdAttribution(): ?int { return $this->idAttribution; }
    public function setIdAttribution(?int $v): void { $this->idAttribution = $v; }
    public function getIdEquipement(): int { return $this->idEquipement; }
    public function setIdEquipement(int $v): void { $this->idEquipement = $v; }
    public function getIdAgent(): int { return $this->idAgent; }
    public function setIdAgent(int $v): void { $this->idAgent = $v; }
    public function getDateAttribution(): string { return $this->dateAttribution; }
    public function setDateAttribution(string $v): void { $this->dateAttribution = $v; }
    public function getDateRetour(): ?string { return $this->dateRetour; }
    public function setDateRetour(?string $v): void { $this->dateRetour = $v; }
    public function getEtatRetour(): ?string { return $this->etatRetour; }
    public function setEtatRetour(?string $v): void { $this->etatRetour = $v; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $v): void { $this->statut = $v; }
    public function getObservations(): ?string { return $this->observations; }
    public function setObservations(?string $v): void { $this->observations = $v; }
}
