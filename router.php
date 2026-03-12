<?php
// Main router for E-sitrana application
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get the requested path
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = explode('?', $request_uri)[0];

// Remove base path if present
$base_path = str_replace('/router.php', '', $_SERVER['SCRIPT_NAME']);
if (strpos($request_uri, $base_path) === 0) {
    $request_uri = substr($request_uri, strlen($base_path));
}

// Handle static files (CSS, JS, images, etc.)
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/', $request_uri)) {
    $file_path = __DIR__ . '/' . ltrim($request_uri, '/');
    
    if (file_exists($file_path)) {
        // Set appropriate content type
        $extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $content_types = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'ico' => 'image/x-icon',
            'svg' => 'image/svg+xml',
            'woff' => 'font/woff',
            'woff2' => 'font/woff2',
            'ttf' => 'font/ttf',
            'eot' => 'application/vnd.ms-fontobject'
        ];
        
        if (isset($content_types[$extension])) {
            header('Content-Type: ' . $content_types[$extension]);
        }
        
        // Enable caching
        header('Cache-Control: public, max-age=3600');
        
        // Output file content
        readfile($file_path);
        exit();
    }
}

// Define routes
$public_routes = [
    '/' => 'views/public/index.php',
    '/index.php' => 'views/public/index.php',
    '/services' => 'views/public/services.php',
    '/doctors' => 'views/public/doctors.php',
    '/appointment' => 'views/public/appointment.php',
    '/contact' => 'views/public/contact.php',
];

$admin_routes = [
    '/admin' => 'views/admin/dashboard.php',
    '/admin/login' => 'views/admin/login.php',
    '/admin/dashboard' => 'views/admin/dashboard.php',
    '/admin/doctors' => 'views/admin/doctors.php',
    '/admin/services' => 'views/admin/services.php',
    '/admin/appointments' => 'views/admin/appointments.php',
    '/admin/patients' => 'views/admin/patients.php',
];

// API routes
$api_routes = [
    '/api/auth' => 'api/auth.php',
    '/api/services' => 'api/services.php',
    '/api/doctors' => 'api/doctors.php',
    '/api/appointments' => 'api/appointments.php',
    '/api/dashboard' => 'api/dashboard.php',
];

// Check if it's an API route
if (strpos($request_uri, '/api/') === 0) {
    // Redirect to API router
    require_once 'api_router.php';
    exit();
}

// Check if it's an admin route
if (strpos($request_uri, '/admin') === 0) {
    // Allow login page without authentication
    if ($request_uri === '/admin/login') {
        require_once 'views/admin/login.php';
        exit();
    }
    
    // Check authentication for other admin routes
    if (!isset($_SESSION['admin_id'])) {
        header('Location: /admin/login');
        exit();
    }
    
    // Find matching admin route
    foreach ($admin_routes as $pattern => $file) {
        if ($request_uri === $pattern) {
            if (file_exists($file)) {
                require_once $file;
                exit();
            }
        }
    }
    
    // Admin route not found, redirect to dashboard
    header('Location: /admin/dashboard');
    exit();
}

// Check public routes
foreach ($public_routes as $pattern => $file) {
    if ($request_uri === $pattern) {
        if (file_exists($file)) {
            require_once $file;
            exit();
        }
    }
}

// Default route - redirect to home
if ($request_uri === '') {
    require_once 'views/public/index.php';
    exit();
}

// 404 - Page not found
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page non trouvée - E-sitrana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="text-center">
            <i class="fas fa-hospital fa-4x text-primary mb-4"></i>
            <h1 class="display-4">404</h1>
            <h2>Page non trouvée</h2>
            <p class="lead">La page que vous recherchez n'existe pas.</p>
            <a href="/" class="btn btn-primary">
                <i class="fas fa-home me-2"></i>Retour à l'accueil
            </a>
        </div>
    </div>
</body>
</html>
