<?php
require_once __DIR__ . '/../config/cors.php';
configureCors();

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../config/logger.php';
require_once __DIR__ . '/../config/rate_limiter.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Admin.php';

// Rate limiting pour l'authentification
if (!checkAuthRateLimit()) {
    sendRateLimitResponse();
}

$database = new Database();
$db = $database->getConnection();
if(!$db) {
    logError('Database connection failed in auth API');
    http_response_code(503);
    echo json_encode(array("message" => "Database connection failed."));
    exit();
}

$admin = new Admin($db);

$request_method = $_SERVER["REQUEST_METHOD"];

logApiRequest($request_method, 'auth', isAdminLoggedIn() ? $_SESSION['admin_id'] : null);

if($request_method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    if(!empty($data->username) && !empty($data->password)) {
        $admin->username = sanitizeInput($data->username);
        $admin->password = $data->password;
        
        if($admin->login()) {
            adminLogin($admin->id, $admin->username, $admin->email);
            logLoginAttempt($admin->username, true);
            
            http_response_code(200);
            echo json_encode(array(
                "message" => "Login successful.",
                "admin" => array(
                    "id" => $admin->id,
                    "username" => $admin->username,
                    "email" => $admin->email
                )
            ));
        } else {
            logLoginAttempt($admin->username, false);
            http_response_code(401);
            echo json_encode(array("message" => "Invalid credentials."));
        }
    } else {
        logWarning('Login attempt with incomplete data', ['username' => $data->username ?? '']);
        http_response_code(400);
        echo json_encode(array("message" => "Unable to login. Data is incomplete."));
    }
} elseif($request_method == 'GET') {
    if(isAdminLoggedIn()) {
        http_response_code(200);
        echo json_encode(array(
            "message" => "Admin is logged in.",
            "admin" => array(
                "id" => $_SESSION['admin_id'],
                "username" => $_SESSION['admin_username'],
                "email" => $_SESSION['admin_email']
            )
        ));
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Not logged in."));
    }
} elseif($request_method == 'DELETE') {
    $username = $_SESSION['admin_username'] ?? 'unknown';
    adminLogout();
    logInfo('Logout successful', ['username' => $username]);
    
    http_response_code(200);
    echo json_encode(array("message" => "Logged out successfully."));
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
