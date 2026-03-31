<?php
// index.php - Routeur Principal Durable E-sitrana
require_once __DIR__ . '/config/session.php';

// 1. Analyse de l'URL demandée
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = explode('?', $request_uri)[0];

// 2. Gestion des fichiers statiques (CSS, JS, Images)
// On laisse Apache ou PHP servir directement les fichiers s'ils existent physiquement
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/', $request_uri)) {
    $file_path = __DIR__ . $request_uri;
    if (file_exists($file_path)) {
        return false; // Laisse Apache servir le fichier normalement
    }
}

// 3. ROUTAGE API (Si l'URL commence par /api/)
if (strpos($request_uri, '/api/') === 0) {
    // On appelle votre routeur d'API dédié
    if (file_exists(__DIR__ . '/api_router.php')) {
        require_once __DIR__ . '/api_router.php';
    } else {
        header('Content-Type: application/json');
        http_response_code(404 );
        echo json_encode(["error" => "Routeur API introuvable"]);
    }
    exit();
}

// 4. ROUTAGE ADMIN (Si l'URL commence par /admin)
if (strpos($request_uri, '/admin') === 0) {
    if ($request_uri === '/admin/login' || $request_uri === '/admin/') {
        require_once __DIR__ . '/views/admin/login.php';
    } else {
        // Protection simple : redirection vers login si pas de session admin
        if (!isAdminLoggedIn()) {
            header('Location: /admin/login');
        } else {
            // Charge le fichier correspondant dans views/admin/ (ex: /admin/doctors -> views/admin/doctors.php)
            $admin_file = __DIR__ . '/views/admin' . str_replace('/admin', '', $request_uri) . '.php';
            if (file_exists($admin_file)) {
                require_once $admin_file;
            } else {
                require_once __DIR__ . '/views/admin/dashboard.php';
            }
        }
    }
    exit();
}

// 5. ROUTAGE FRONTEND (Par défaut)
// On définit les pages publiques autorisées
$public_pages = [
    '/'             => 'views/public/index.php',
    '/index.php'    => 'views/public/index.php',
    '/services'     => 'views/public/services.php',
    '/doctors'      => 'views/public/doctors.php',
    '/appointment'  => 'views/public/appointment.php',
    '/contact'      => 'views/public/contact.php',
    '/user-dashboard' => 'views/public/user-dashboard.php'
];

if (isset($public_pages[$request_uri])) {
    $file = __DIR__ . '/' . $public_pages[$request_uri];
    if (file_exists($file)) {
        require_once $file;
        exit();
    }
}

// Si aucune route ne correspond, on charge l'accueil par défaut
if (file_exists(__DIR__ . '/views/public/index.php')) {
    require_once __DIR__ . '/views/public/index.php';
} else {
    echo "<h1>Erreur Critique</h1><p>Le fichier views/public/index.php est introuvable.</p>";
}
?>
