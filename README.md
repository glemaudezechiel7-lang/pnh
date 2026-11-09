# Projet N°11 — Gestion de la PNH (Police Nationale d'Haïti)

Application web PHP en architecture **MVC stricte** (packages `entites`, `dao`, `controller`, `vue`)
pour la gestion d'un commissariat : agents, affectations, plaintes, gardes à vue, rapports
d'intervention, armement/équipements, et comptes utilisateurs.

## 1. Prérequis

- PHP >= 8.1 (utilisation de `match`, types de propriétés typées)
- MySQL ou MariaDB
- Extension PHP `pdo_mysql` activée
- Un serveur web (Apache/Nginx) ou le serveur intégré de PHP pour les tests

## 2. Installation

### a) Base de données

1. Créez une base de données (ou laissez le script le faire) en important le script SQL :
   ```bash
   mysql -u root -p < sql/pnh_database.sql
   ```
   Ce script crée la base `pnh_gestion`, toutes les tables avec leurs contraintes
   (clés étrangères, `CHECK`, `ENUM`, index) ainsi qu'un commissariat par défaut.

### b) Configuration

2. Ouvrez `config/config.php` et ajustez si nécessaire :
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'pnh_gestion');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   ```

### c) Création automatique du super administrateur

3. Placez le dossier du projet dans le répertoire servi par votre serveur web
   (ex. `htdocs/pnh-app` pour XAMPP/WAMP, ou `/var/www/html/pnh-app`).
4. Ouvrez **une seule fois** `http://localhost/pnh-app/install.php` dans votre navigateur.
   Ce script crée automatiquement le compte **super administrateur** par défaut :
   - Identifiant : `superadmin`
   - Mot de passe : `Admin@2026`

   ⚠️ Changez ce mot de passe dès la première connexion, puis supprimez `install.php`.

### d) Accès à l'application

5. Rendez-vous sur `http://localhost/pnh-app/index.php` :
   - La page d'accueil présente l'institution (services, commissariats, contact).
   - Cliquez sur **« Accéder à la plateforme »** pour être redirigé vers la connexion
     (ou directement vers le tableau de bord si une session est déjà active).

## 3. Architecture MVC

```
pnh-app/
├── index.php              # Front controller unique (point d'entrée)
├── install.php            # Script d'installation (crée le super admin)
├── config/
│   └── config.php         # Connexion, session, autoload, contrôle d'accès
├── entites/                # Classes métier (attributs privés + getters/setters)
├── dao/                     # Accès aux données (PDO, requêtes préparées)
├── controller/              # Validation métier, coordination
├── vue/                     # Présentation HTML/PHP (aucune logique métier)
│   ├── layout/               # En-tête / pied de page communs (sidebar, topbar)
│   ├── agents/ affectations/ plaintes/ gardes/ rapports/ equipements/
│   ├── commissariats/ utilisateurs/
│   ├── accueil.php          # Page publique
│   ├── login.php
│   └── dashboard.php
├── public/
│   ├── css/style.css        # Thème moderne (bleu marine institutionnel)
│   ├── js/app.js
│   └── img/                 # Logo, avatars, photos uploadées
└── sql/pnh_database.sql     # Script SQL complet (9 tables, contraintes, index)
```

## 4. Rôles et permissions

| Rôle           | Permissions                                                        |
|----------------|---------------------------------------------------------------------|
| `super_admin`  | Accès complet : gestion des utilisateurs, suppression de comptes/commissariats |
| `admin`        | Gestion des agents, plaintes, gardes, rapports, équipements, utilisateurs (hors suppression de comptes super admin) |
| `gestionnaire` | Création/modification des agents, affectations, rapports, équipements |
| `operateur`    | Enregistrement des plaintes et gardes à vue, consultation générale |

Le contrôle d'accès est appliqué **côté serveur** dans chaque contrôleur via
`requireAuth()` / `requireRole([...])` (voir `config/config.php`), jamais uniquement côté vue.

## 5. Modules fonctionnels

- **Agents** : fiche complète (matricule, grade, unité, statut, photo), historique des affectations.
- **Affectations** : postes, rotations, mutations — une seule affectation active par agent.
- **Plaintes citoyennes** : numéro auto-généré, déclarant, nature, statut de traitement.
- **Gardes à vue** : identité du suspect, motif, entrée/sortie, lien optionnel avec une plainte.
- **Rapports d'intervention** : type d'opération, effectifs, zone, résultats.
- **Armement & équipements** : inventaire + attributions/retours en armurerie avec suivi d'état.
- **Utilisateurs** : CRUD complet avec rôles, activation/désactivation, mots de passe hachés.
- **Tableau de bord** : statistiques en temps réel (plaintes ouvertes, gardes en cours, agents en service, opérations du mois).

## 6. Sécurité

- Mots de passe hachés avec `password_hash()` / vérifiés avec `password_verify()`.
- Requêtes SQL exclusivement préparées (PDO, `ATTR_EMULATE_PREPARES => false`).
- Échappement systématique des sorties HTML via la fonction `e()`.
- Sessions PHP pour l'authentification ; contrôle d'accès par rôle sur chaque action sensible.
- Toutes les validations métier (champs obligatoires, unicité, cohérence des dates) sont
  effectuées dans les contrôleurs — jamais dans les vues.

## 7. Notes

- Les photos (agents, commissariats) sont optionnelles et stockées dans `public/img/`.
- Le logo utilisé est une création originale (badge stylisé) et non le logo officiel réel de la PNH.
- Les images de commissariats sur la page d'accueil sont des photographies libres de droit
  (Unsplash) à titre illustratif — à remplacer par vos propres photos en production.
