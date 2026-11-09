<?php
/** Package entites */
class Commissariat
{
    private ?int $idCommissariat;
    private string $nom;
    private string $code;
    private string $departement;
    private string $commune;
    private ?string $adresse;
    private ?string $telephone;
    private ?string $photo;
    private ?string $dateCreation;

    public function __construct(
        string $nom = '',
        string $code = '',
        string $departement = '',
        string $commune = '',
        ?string $adresse = null,
        ?string $telephone = null,
        ?string $photo = null,
        ?string $dateCreation = null,
        ?int $idCommissariat = null
    ) {
        $this->idCommissariat = $idCommissariat;
        $this->nom = $nom;
        $this->code = $code;
        $this->departement = $departement;
        $this->commune = $commune;
        $this->adresse = $adresse;
        $this->telephone = $telephone;
        $this->photo = $photo;
        $this->dateCreation = $dateCreation;
    }

    public function getIdCommissariat(): ?int { return $this->idCommissariat; }
    public function setIdCommissariat(?int $v): void { $this->idCommissariat = $v; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $v): void { $this->nom = $v; }
    public function getCode(): string { return $this->code; }
    public function setCode(string $v): void { $this->code = $v; }
    public function getDepartement(): string { return $this->departement; }
    public function setDepartement(string $v): void { $this->departement = $v; }
    public function getCommune(): string { return $this->commune; }
    public function setCommune(string $v): void { $this->commune = $v; }
    public function getAdresse(): ?string { return $this->adresse; }
    public function setAdresse(?string $v): void { $this->adresse = $v; }
    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(?string $v): void { $this->telephone = $v; }
    public function getPhoto(): ?string { return $this->photo; }
    public function setPhoto(?string $v): void { $this->photo = $v; }
    public function getDateCreation(): ?string { return $this->dateCreation; }
    public function setDateCreation(?string $v): void { $this->dateCreation = $v; }
}
