<?php
// Simple router
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = explode('?', $request_uri)[0];

// Remove base path if present
$base_path = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
if (strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

// Route to API endpoints
if (strpos($request_uri, '/api/') === 0) {
    $api_file = __DIR__ . $request_uri . '.php';
    if (file_exists($api_file)) {
        require_once $api_file;
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "API endpoint not found."));
    }
} else {
    // For now, serve a simple info page
    echo "<h1>E-sitrana API</h1>";
    echo "<p>Backend is running!</p>";
    echo "<h2>Available endpoints:</h2>";
    echo "<ul>";
    echo "<li><strong>GET/POST/PUT/DELETE</strong> /api/services - Manage services</li>";
    echo "<li><strong>GET/POST/PUT/DELETE</strong> /api/doctors - Manage doctors</li>";
    echo "<li><strong>GET/POST/PUT/DELETE</strong> /api/appointments - Manage appointments</li>";
    echo "<li><strong>GET/POST/DELETE</strong> /api/auth - Authentication</li>";
    echo "<li><strong>GET</strong> /api/dashboard - Dashboard statistics</li>";
    echo "</ul>";
}
?>
