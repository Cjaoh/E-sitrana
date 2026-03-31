<?php
// Système simple de rate limiting pour E-sitrana

/**
 * Vérifie le rate limiting pour une IP
 * @param int $max_requests - Nombre max de requêtes
 * @param int $window_seconds - Période en secondes
 * @return bool - true si autorisé, false si limité
 */
function checkRateLimit($max_requests = 60, $window_seconds = 60) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $cache_file = __DIR__ . '/../logs/rate_limit_' . md5($ip) . '.json';
    
    // Lire le cache existant
    $data = [];
    if (file_exists($cache_file)) {
        $json_data = file_get_contents($cache_file);
        $data = json_decode($json_data, true) ?: [];
    }
    
    $current_time = time();
    
    // Nettoyer les anciennes entrées
    $data = array_filter($data, function($timestamp) use ($current_time, $window_seconds) {
        return ($current_time - $timestamp) < $window_seconds;
    });
    
    // Vérifier la limite
    if (count($data) >= $max_requests) {
        logWarning('Rate limit exceeded', [
            'ip' => $ip,
            'requests' => count($data),
            'max_requests' => $max_requests,
            'window' => $window_seconds
        ]);
        return false;
    }
    
    // Ajouter la requête actuelle
    $data[] = $current_time;
    
    // Sauvegarder le cache
    file_put_contents($cache_file, json_encode(array_values($data)), LOCK_EX);
    
    return true;
}

/**
 * Vérifie le rate limiting pour l'API auth (plus strict)
 */
function checkAuthRateLimit() {
    return checkRateLimit(5, 300); // 5 requêtes par 5 minutes pour l'auth
}

/**
 * Vérifie le rate limiting pour les autres endpoints API
 */
function checkApiRateLimit() {
    return checkRateLimit(100, 60); // 100 requêtes par minute
}

/**
 * Envoie une réponse de rate limit exceeded
 */
function sendRateLimitResponse() {
    http_response_code(429);
    header('Retry-After: 60');
    echo json_encode([
        'error' => 'Too Many Requests',
        'message' => 'Rate limit exceeded. Please try again later.',
        'retry_after' => 60
    ]);
    exit();
}

/**
 * Nettoie les anciens fichiers de rate limiting
 */
function cleanupRateLimitFiles() {
    $cache_dir = __DIR__ . '/../logs';
    $files = glob($cache_dir . '/rate_limit_*.json');
    
    foreach ($files as $file) {
        if (filemtime($file) < strtotime('-1 hour')) {
            unlink($file);
        }
    }
}
?>
