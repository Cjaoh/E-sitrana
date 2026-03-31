<?php
// Configuration CORS dynamique pour E-sitrana

/**
 * Configure les headers CORS en fonction de l'environnement
 */
function configureCors() {
    $app_env = getenv('APP_ENV') ?: 'development';
    $app_url = getenv('APP_URL') ?: 'http://localhost';
    
    // En production, restreindre aux domaines autorisés
    if ($app_env === 'production') {
        $allowed_origins = [$app_url];
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
        
        if (in_array($origin, $allowed_origins)) {
            header("Access-Control-Allow-Origin: $origin");
        }
    } else {
        // En développement, autoriser tout
        header("Access-Control-Allow-Origin: *");
    }
    
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 3600");
    
    // Gérer les requêtes OPTIONS (pre-flight)
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
}

/**
 * Vérifie si la requête vient d'une origine autorisée
 */
function isOriginAllowed() {
    $app_env = getenv('APP_ENV') ?: 'development';
    
    if ($app_env !== 'production') {
        return true; // En développement, tout autoriser
    }
    
    $app_url = getenv('APP_URL') ?: 'http://localhost';
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    
    return $origin === $app_url;
}
?>
