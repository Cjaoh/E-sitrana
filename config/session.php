<?php
// Gestion centralisée des sessions pour E-sitrana

// Démarrage sécurisé de la session
if (session_status() === PHP_SESSION_NONE) {
    // Configuration sécurisée de la session
    ini_set('session.cookie_httponly', 1);
    
    // HTTPS automatique ou basé sur la configuration
    $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') 
                || $_SERVER['SERVER_PORT'] == 443 
                || (getenv('APP_ENV') === 'production');
    
    ini_set('session.cookie_secure', $is_https ? 1 : 0);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.cookie_samesite', $is_https ? 'Strict' : 'Lax');
    
    // Durée de vie de la session (1 heure par défaut)
    $session_lifetime = getenv('SESSION_LIFETIME') ?: 3600;
    ini_set('session.gc_maxlifetime', $session_lifetime);
    
    session_start();
    
    // Régénération de l'ID de session pour la sécurité
    if (!isset($_SESSION['regenerated'])) {
        session_regenerate_id(true);
        $_SESSION['regenerated'] = true;
    }
}

/**
 * Vérifie si l'administrateur est connecté
 * @return bool
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

/**
 * Déconnecte l'administrateur et détruit la session
 */
function adminLogout() {
    session_unset();
    session_destroy();
    
    // Suppression du cookie de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
}

/**
 * Connecte un administrateur
 * @param int $admin_id
 * @param string $username
 * @param string $email
 */
function adminLogin($admin_id, $username, $email) {
    $_SESSION['admin_id'] = $admin_id;
    $_SESSION['admin_username'] = $username;
    $_SESSION['admin_email'] = $email;
    $_SESSION['login_time'] = time();
}

/**
 * Vérifie si la session a expiré
 * @return bool
 */
function isSessionExpired() {
    $session_lifetime = getenv('SESSION_LIFETIME') ?: 3600;
    return isset($_SESSION['login_time']) && 
           (time() - $_SESSION['login_time'] > $session_lifetime);
}
?>
