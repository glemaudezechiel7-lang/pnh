-- ============================================================================
-- BASE DE DONNÉES — GESTION DE LA PNH (Police Nationale d'Haïti)
-- Moteur : MySQL / MariaDB
-- Encodage : utf8mb4
-- ============================================================================

DROP DATABASE IF EXISTS pnh_gestion;
CREATE DATABASE pnh_gestion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pnh_gestion;

-- ============================================================================
-- TABLE : commissariats
-- ============================================================================
CREATE TABLE commissariats (
    id_commissariat      INT AUTO_INCREMENT PRIMARY KEY,
    nom                  VARCHAR(150) NOT NULL,
    code                 VARCHAR(20)  NOT NULL UNIQUE,
    departement          VARCHAR(100) NOT NULL,
    commune              VARCHAR(100) NOT NULL,
    adresse              VARCHAR(255),
    telephone            VARCHAR(30),
    photo                VARCHAR(255) DEFAULT NULL,
    date_creation        DATE DEFAULT NULL,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ============================================================================
-- TABLE : utilisateurs (module transversal de gestion des comptes)
-- ============================================================================
CREATE TABLE utilisateurs (
    id_utilisateur       INT AUTO_INCREMENT PRIMARY KEY,
    nom                  VARCHAR(100) NOT NULL,
    prenom               VARCHAR(100) NOT NULL,
    login                VARCHAR(60)  NOT NULL UNIQUE,
    email                VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe         VARCHAR(255) NOT NULL,
    role                 ENUM('super_admin','admin','gestionnaire','operateur') NOT NULL DEFAULT 'operateur',
    id_commissariat      INT DEFAULT NULL,
    statut               ENUM('actif','inactif') NOT NULL DEFAULT 'actif',
    derniere_connexion   DATETIME DEFAULT NULL,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_util_commissariat FOREIGN KEY (id_commissariat)
        REFERENCES commissariats(id_commissariat) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ============================================================================
-- TABLE : agents
-- ============================================================================
CREATE TABLE agents (
    id_agent             INT AUTO_INCREMENT PRIMARY KEY,
    matricule            VARCHAR(30) NOT NULL UNIQUE,
    nom                  VARCHAR(100) NOT NULL,
    prenom               VARCHAR(100) NOT NULL,
    grade                ENUM('Agent 1','Agent 2','Corporal','Sergent','Sergent-Chef',
                               'Inspecteur','Commissaire','Commissaire Principal','Directeur') NOT NULL,
    sexe                 ENUM('M','F') NOT NULL,
    date_naissance       DATE NOT NULL,
    telephone            VARCHAR(30),
    adresse              VARCHAR(255),
    photo                VARCHAR(255) DEFAULT NULL,
    id_commissariat      INT NOT NULL,
    date_entree           DATE NOT NULL,
    statut               ENUM('en_service','en_conge','suspendu','retraite','radie') NOT NULL DEFAULT 'en_service',
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_agent_commissariat FOREIGN KEY (id_commissariat)
        REFERENCES commissariats(id_commissariat) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================================================
-- TABLE : affectations (postes, rotations, mutations)
-- ============================================================================
CREATE TABLE affectations (
    id_affectation       INT AUTO_INCREMENT PRIMARY KEY,
    id_agent             INT NOT NULL,
    id_commissariat      INT NOT NULL,
    poste                VARCHAR(100) NOT NULL,
    type_affectation      ENUM('initiale','mutation','rotation','detachement') NOT NULL DEFAULT 'initiale',
    date_debut           DATE NOT NULL,
    date_fin             DATE DEFAULT NULL,
    motif                VARCHAR(255),
    statut               ENUM('active','terminee') NOT NULL DEFAULT 'active',
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_affect_agent FOREIGN KEY (id_agent)
        REFERENCES agents(id_agent) ON DELETE CASCADE,
    CONSTRAINT fk_affect_commissariat FOREIGN KEY (id_commissariat)
        REFERENCES commissariats(id_commissariat) ON DELETE RESTRICT,
    CONSTRAINT chk_affect_dates CHECK (date_fin IS NULL OR date_fin >= date_debut)
) ENGINE=InnoDB;

-- ============================================================================
-- TABLE : plaintes
-- ============================================================================
CREATE TABLE plaintes (
    id_plainte           INT AUTO_INCREMENT PRIMARY KEY,
    numero_plainte       VARCHAR(30) NOT NULL UNIQUE,
    nom_declarant        VARCHAR(150) NOT NULL,
    telephone_declarant  VARCHAR(30),
    adresse_declarant    VARCHAR(255),
    nature               VARCHAR(150) NOT NULL,
    description          TEXT,
    date_plainte         DATETIME NOT NULL,
    lieu_incident        VARCHAR(255),
    id_agent_traitant    INT DEFAULT NULL,
    id_commissariat      INT NOT NULL,
    statut               ENUM('ouverte','en_cours','cloturee','classee_sans_suite') NOT NULL DEFAULT 'ouverte',
    date_cloture         DATETIME DEFAULT NULL,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_plainte_agent FOREIGN KEY (id_agent_traitant)
        REFERENCES agents(id_agent) ON DELETE SET NULL,
    CONSTRAINT fk_plainte_commissariat FOREIGN KEY (id_commissariat)
        REFERENCES commissariats(id_commissariat) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================================================
-- TABLE : gardes_a_vue
-- ============================================================================
CREATE TABLE gardes_a_vue (
    id_garde             INT AUTO_INCREMENT PRIMARY KEY,
    nom_suspect          VARCHAR(150) NOT NULL,
    prenom_suspect       VARCHAR(150),
    date_naissance_suspect DATE DEFAULT NULL,
    piece_identite       VARCHAR(60),
    motif                VARCHAR(255) NOT NULL,
    id_agent_responsable INT NOT NULL,
    id_commissariat      INT NOT NULL,
    id_plainte           INT DEFAULT NULL,
    date_heure_entree    DATETIME NOT NULL,
    date_heure_sortie    DATETIME DEFAULT NULL,
    type_sortie          ENUM('relache','transfere_tribunal','transfere_prison','en_cours') NOT NULL DEFAULT 'en_cours',
    observations         TEXT,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_garde_agent FOREIGN KEY (id_agent_responsable)
        REFERENCES agents(id_agent) ON DELETE RESTRICT,
    CONSTRAINT fk_garde_commissariat FOREIGN KEY (id_commissariat)
        REFERENCES commissariats(id_commissariat) ON DELETE RESTRICT,
    CONSTRAINT fk_garde_plainte FOREIGN KEY (id_plainte)
        REFERENCES plaintes(id_plainte) ON DELETE SET NULL,
    CONSTRAINT chk_garde_dates CHECK (date_heure_sortie IS NULL OR date_heure_sortie >= date_heure_entree)
) ENGINE=InnoDB;

-- ============================================================================
-- TABLE : rapports_interventions
-- ============================================================================
CREATE TABLE rapports_interventions (
    id_rapport           INT AUTO_INCREMENT PRIMARY KEY,
    reference             VARCHAR(30) NOT NULL UNIQUE,
    type_operation       VARCHAR(150) NOT NULL,
    description          TEXT,
    zone_geographique    VARCHAR(150) NOT NULL,
    id_commissariat      INT NOT NULL,
    id_agent_responsable INT NOT NULL,
    effectifs_deployes   INT NOT NULL DEFAULT 1,
    date_intervention    DATETIME NOT NULL,
    resultats            TEXT,
    statut               ENUM('planifiee','en_cours','terminee','annulee') NOT NULL DEFAULT 'planifiee',
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_rapport_commissariat FOREIGN KEY (id_commissariat)
        REFERENCES commissariats(id_commissariat) ON DELETE RESTRICT,
    CONSTRAINT fk_rapport_agent FOREIGN KEY (id_agent_responsable)
        REFERENCES agents(id_agent) ON DELETE RESTRICT,
    CONSTRAINT chk_effectifs CHECK (effectifs_deployes > 0)
) ENGINE=InnoDB;

-- ============================================================================
-- TABLE : equipements (armes, gilets, radios, véhicules, etc.)
-- ============================================================================
CREATE TABLE equipements (
    id_equipement        INT AUTO_INCREMENT PRIMARY KEY,
    numero_serie         VARCHAR(60) NOT NULL UNIQUE,
    type_equipement      ENUM('arme_de_poing','fusil','gilet_pare_balles','radio','vehicule','menottes','autre') NOT NULL,
    designation          VARCHAR(150) NOT NULL,
    id_commissariat      INT NOT NULL,
    etat                 ENUM('bon_etat','endommage','hors_service','perdu') NOT NULL DEFAULT 'bon_etat',
    date_acquisition     DATE DEFAULT NULL,
    created_at           TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_equip_commissariat FOREIGN KEY (id_commissariat)
        REFERENCES commissariats(id_commissariat) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================================================
-- TABLE : attributions_equipements (attribution à un agent, retour en armurerie)
-- ============================================================================
CREATE TABLE attributions_equipements (
    id_attribution       INT AUTO_INCREMENT PRIMARY KEY,
    id_equipement        INT NOT NULL,
    id_agent             INT NOT NULL,
    date_attribution      DATETIME NOT NULL,
    date_retour          DATETIME DEFAULT NULL,
    etat_retour          ENUM('bon_etat','endommage','hors_service','perdu') DEFAULT NULL,
    statut               ENUM('en_possession','retourne') NOT NULL DEFAULT 'en_possession',
    observations         VARCHAR(255),
    CONSTRAINT fk_attrib_equipement FOREIGN KEY (id_equipement)
        REFERENCES equipements(id_equipement) ON DELETE CASCADE,
    CONSTRAINT fk_attrib_agent FOREIGN KEY (id_agent)
        REFERENCES agents(id_agent) ON DELETE CASCADE,
    CONSTRAINT chk_attrib_dates CHECK (date_retour IS NULL OR date_retour >= date_attribution)
) ENGINE=InnoDB;

-- ============================================================================
-- INDEXES complémentaires pour la performance
-- ============================================================================
CREATE INDEX idx_agents_statut ON agents(statut);
CREATE INDEX idx_plaintes_statut ON plaintes(statut);
CREATE INDEX idx_gardes_type_sortie ON gardes_a_vue(type_sortie);
CREATE INDEX idx_rapports_date ON rapports_interventions(date_intervention);
CREATE INDEX idx_affectations_statut ON affectations(statut);

-- ============================================================================
-- DONNÉES INITIALES
-- ============================================================================

-- Commissariat par défaut
INSERT INTO commissariats (nom, code, departement, commune, adresse, telephone, date_creation)
VALUES ('Commissariat Central de Port-au-Prince', 'COM-PAP-01', 'Ouest', 'Port-au-Prince',
        'Rue du Centre, Port-au-Prince', '+509 2222-1111', '1995-01-01');

-- NOTE IMPORTANTE : Le compte super administrateur par défaut N'EST PAS créé ici.
-- Conformément au cahier des charges ("le système crée automatiquement un compte
-- super administrateur lors de la première installation"), ce compte est généré
-- dynamiquement par le script install.php (à la racine du projet) lors du tout
-- premier accès à l'application, avec un mot de passe correctement haché via
-- password_hash(). Après avoir importé ce script SQL, ouvrez simplement install.php
-- dans votre navigateur une seule fois pour finaliser l'installation.
