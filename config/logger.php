<?php
// Système de logging centralisé pour E-sitrana

/**
 * Enregistre un message dans le log
 * @param string $level - DEBUG, INFO, WARNING, ERROR, CRITICAL
 * @param string $message
 * @param array $context - données additionnelles
 */
function logMessage($level, $message, $context = []) {
    $log_dir = __DIR__ . '/../logs';
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $log_file = $log_dir . '/app_' . date('Y-m-d') . '.log';
    $timestamp = date('Y-m-d H:i:s');
    $context_str = !empty($context) ? ' | ' . json_encode($context) : '';
    
    $log_entry = "[{$timestamp}] {$level}: {$message}{$context_str}" . PHP_EOL;
    
    file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
}

/**
 * Log un message de debug
 */
function logDebug($message, $context = []) {
    logMessage('DEBUG', $message, $context);
}

/**
 * Log un message d'information
 */
function logInfo($message, $context = []) {
    logMessage('INFO', $message, $context);
}

/**
 * Log un avertissement
 */
function logWarning($message, $context = []) {
    logMessage('WARNING', $message, $context);
}

/**
 * Log une erreur
 */
function logError($message, $context = []) {
    logMessage('ERROR', $message, $context);
}

/**
 * Log une erreur critique
 */
function logCritical($message, $context = []) {
    logMessage('CRITICAL', $message, $context);
}

/**
 * Log les requêtes API
 */
function logApiRequest($method, $endpoint, $user_id = null, $ip = null) {
    $context = [
        'method' => $method,
        'endpoint' => $endpoint,
        'user_id' => $user_id,
        'ip' => $ip ?: $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ];
    logInfo('API Request: ' . $method . ' ' . $endpoint, $context);
}

/**
 * Log les erreurs de base de données
 */
function logDatabaseError($query, $error) {
    $context = [
        'query' => $query,
        'error' => $error,
        'file' => basename(debug_backtrace()[1]['file']),
        'line' => debug_backtrace()[1]['line']
    ];
    logError('Database error: ' . $error, $context);
}

/**
 * Log les tentatives de connexion
 */
function logLoginAttempt($username, $success, $ip = null) {
    $context = [
        'username' => $username,
        'success' => $success,
        'ip' => $ip ?: $_SERVER['REMOTE_ADDR'] ?? 'unknown'
    ];
    
    if ($success) {
        logInfo('Login successful', $context);
    } else {
        logWarning('Login failed', $context);
    }
}

/**
 * Nettoie les anciens fichiers de log (garde 30 jours)
 */
function cleanupLogs() {
    $log_dir = __DIR__ . '/../logs';
    $files = glob($log_dir . '/app_*.log');
    
    foreach ($files as $file) {
        if (filemtime($file) < strtotime('-30 days')) {
            unlink($file);
        }
    }
}
?>
