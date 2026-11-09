<?php
/** Package entites */
class Utilisateur
{
    private ?int $idUtilisateur;
    private string $nom;
    private string $prenom;
    private string $login;
    private string $email;
    private string $motDePasse;
    private string $role; // super_admin, admin, gestionnaire, operateur
    private ?int $idCommissariat;
    private string $statut; // actif, inactif
    private ?string $derniereConnexion;

    public function __construct(
        string $nom = '',
        string $prenom = '',
        string $login = '',
        string $email = '',
        string $motDePasse = '',
        string $role = 'operateur',
        ?int $idCommissariat = null,
        string $statut = 'actif',
        ?int $idUtilisateur = null,
        ?string $derniereConnexion = null
    ) {
        $this->idUtilisateur = $idUtilisateur;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        $this->email = $email;
        $this->motDePasse = $motDePasse;
        $this->role = $role;
        $this->idCommissariat = $idCommissariat;
        $this->statut = $statut;
        $this->derniereConnexion = $derniereConnexion;
    }

    public function getIdUtilisateur(): ?int { return $this->idUtilisateur; }
    public function setIdUtilisateur(?int $v): void { $this->idUtilisateur = $v; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $v): void { $this->nom = $v; }

    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $v): void { $this->prenom = $v; }

    public function getLogin(): string { return $this->login; }
    public function setLogin(string $v): void { $this->login = $v; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $v): void { $this->email = $v; }

    public function getMotDePasse(): string { return $this->motDePasse; }
    public function setMotDePasse(string $v): void { $this->motDePasse = $v; }

    public function getRole(): string { return $this->role; }
    public function setRole(string $v): void { $this->role = $v; }

    public function getIdCommissariat(): ?int { return $this->idCommissariat; }
    public function setIdCommissariat(?int $v): void { $this->idCommissariat = $v; }

    public function getStatut(): string { return $this->statut; }
    public function setStatut(string $v): void { $this->statut = $v; }

    public function getDerniereConnexion(): ?string { return $this->derniereConnexion; }
    public function setDerniereConnexion(?string $v): void { $this->derniereConnexion = $v; }

    public function getNomComplet(): string { return $this->prenom . ' ' . $this->nom; }
}
