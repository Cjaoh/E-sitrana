<?php
// API Router - Gère toutes les requêtes API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();

// Get the requested path
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = explode('?', $request_uri)[0];

// Remove /api/ prefix
$api_path = str_replace('/api/', '', $request_uri);

// Define API routes
$routes = [
    'auth' => 'auth.php',
    'services' => 'services.php',
    'doctors' => 'doctors.php',
    'appointments' => 'appointments.php',
    'dashboard' => 'dashboard.php',
];

// Route to appropriate file
if (isset($routes[$api_path])) {
    $file = $routes[$api_path];
    if (file_exists($file)) {
        require_once $file;
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'API file not found']);
    }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'API endpoint not found']);
}
?>
