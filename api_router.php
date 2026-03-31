<?php
// api_router.php
require_once __DIR__ . '/config/cors.php';
configureCors();

$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = explode('?', $request_uri)[0];

// On retire le préfixe /api/ pour trouver le nom de l'endpoint
$api_endpoint = str_replace('/api/', '', $request_uri);

$routes = [
    'auth' => 'auth.php',
    'services' => 'services.php',
    'doctors' => 'doctors.php',
    'patients' => 'patients.php',
    'appointments' => 'appointments.php',
    'dashboard' => 'dashboard.php',
];

if (isset($routes[$api_endpoint])) {
    $file = __DIR__ . '/api/' . $routes[$api_endpoint];
    if (file_exists($file)) {
        require_once $file;
    } else {
        http_response_code(404 );
        echo json_encode(['error' => 'Fichier API introuvable']);
    }
} else {
    http_response_code(404 );
    echo json_encode(['error' => 'Endpoint API inconnu', 'uri' => $request_uri]);
}
?>
