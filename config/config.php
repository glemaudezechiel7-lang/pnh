<?php
/**
 * Configuration générale de l'application
 * Gestion PNH — Police Nationale d'Haïti
 */

// Démarrage de la session PHP (utilisée pour l'authentification et le contrôle d'accès)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Fuseau horaire d'Haïti
date_default_timezone_set('America/Port-au-Prince');

// Constantes de connexion à la base de données (MySQL / MariaDB)
define('DB_HOST', 'localhost');
define('DB_NAME', 'pnh_gestion');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Chemin racine de l'application (à ajuster selon le déploiement)
define('BASE_URL', '/pnh-app/');
define('APP_NAME', "Gestion PNH — Police Nationale d'Haïti");

// Autoload simple des classes par package (entites, dao, controller)
spl_autoload_register(function ($class) {
    $dirs = ['entites', 'dao', 'controller'];
    $root = dirname(__DIR__);
    foreach ($dirs as $dir) {
        $file = $root . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

/**
 * Vérifie qu'un utilisateur est authentifié, sinon redirige vers le login.
 */
function requireAuth(): void
{
    if (empty($_SESSION['utilisateur_id'])) {
        header('Location: ' . BASE_URL . 'index.php?page=login');
        exit;
    }
}

/**
 * Vérifie que l'utilisateur connecté possède un des rôles autorisés.
 * @param array $rolesAutorises
 */
function requireRole(array $rolesAutorises): void
{
    requireAuth();
    if (!in_array($_SESSION['utilisateur_role'], $rolesAutorises, true)) {
        http_response_code(403);
        echo "<div style='padding:40px;font-family:sans-serif'>
                <h2>Accès refusé</h2>
                <p>Vous n'avez pas la permission d'accéder à cette ressource.</p>
                <a href='" . BASE_URL . "index.php?page=dashboard'>Retour au tableau de bord</a>
              </div>";
        exit;
    }
}

/**
 * Nettoie une chaîne pour l'affichage HTML (protection XSS).
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}
