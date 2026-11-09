<?php
/** Package entites */
class Agent
{
    private ?int $idAgent;
    private string $matricule;
    private string $nom;
    private string $prenom;
    private string $grade;
    private string $sexe;
    private string $dateNaissance;
    private ?string $telephone;
    private ?string $adresse;
    private ?string $photo;
    private int $idCommissariat;
    private string $dateEntree;
    private string $statut;

    public function __construct(
        string $matricule = '',
        string $nom = '',
        string $prenom = '',
        string $grade = '',
        string $sexe = 'M',
        string $dateNaissance = '',
        ?string $telephone = null,
        ?string $adresse = null,
        ?string $photo = null,
        int $idCommissariat = 0,
        string $dateEntree = '',
        string $statut = 'en_service',
        ?int $idAgent = null
    ) {
        $this->idAgent = $idAgent;
        $this->matricule = $matricule;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->grade = $grade;
        $this->sexe = $sexe;
        $this->dateNaissance = $dateNaissance;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->photo = $photo;
        $this->idCommissariat = $idCommissariat;
        $this->dateEntree = $dateEntree;
        $this->statut = $statut;
    }

    public function getIdAgent(): ?int { return $this->idAgent; }
    public function setIdAgent(?int $v): void { $this->idAgent = $v; }
    public function getMatricule(): string { return $this->matricule; }
    public function setMatricule(string $v): void { $this->matricule = $v; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $v): void { $this->nom = $v; }
    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $v): void { $this->prenom = $v; }
    public function getGrade(): string { return $this->grade; }
    public function setGrade(string $v): void { $this->grade = $v; }
    public function getSexe(): string { return $this->sexe; }
    public function setSexe(string $v): void { $this->sexe = $v; }
    public function getDateNaissance(): string { return $this->dateNaissance; }
    public function setDateNaissance(string $v): void { $this->dateNaissance = $v; }
    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(?string $v): void { $this->telephone = $v; }
    public function getAdresse(): ?string { return $this->adresse; }
    public function setAdresse(?string $v): void { $this->adresse = $v; }
    public function getPhoto(): ?string { return $this->photo; }
    public function setPhoto(?string $v): void { $this->photo = $v; }
    public function getIdCommissariat(): int { return $this->idCommissariat; }
    public function setIdCommissariat(int $v): void { $this->idCommissariat = $v; }
    public function getDateEntree(): string { return $this->dateEntree; }
    public function setDateEntree(string $v): void { $this->dateEntree = $v; }
    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $v): void { $this->statut = $v; }

    public function getNomComplet(): string { return $this->prenom . ' ' . $this->nom; }
}
