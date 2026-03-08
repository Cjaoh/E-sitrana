<?php
// API Entry Point
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();

// Get the endpoint from URL parameter
$endpoint = $_GET['endpoint'] ?? '';

// Remove leading slash if present
$endpoint = ltrim($endpoint, '/');

// Set default request method if not set
if (!isset($_SERVER['REQUEST_METHOD'])) {
    $_SERVER['REQUEST_METHOD'] = 'GET';
}

// Define API routes
$routes = [
    'auth' => 'api/auth.php',
    'services' => 'api/services.php',
    'doctors' => 'api/doctors.php',
    'appointments' => 'api/appointments.php',
    'patients' => 'api/patients.php',
    'dashboard' => 'api/dashboard.php',
];

// Route to appropriate file
if (isset($routes[$endpoint])) {
    $file = $routes[$endpoint];
    if (file_exists($file)) {
        require_once $file;
    } else {
        http_response_code(404);
        echo json_encode(['message' => 'API file not found']);
    }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'API endpoint not found', 'available' => array_keys($routes), 'received' => $endpoint]);
}
?>
