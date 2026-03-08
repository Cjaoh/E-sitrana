<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Admin.php';

$database = new Database();
$db = $database->getConnection();

$admin = new Admin($db);

$request_method = $_SERVER["REQUEST_METHOD"];

if($request_method == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    
    if(!empty($data->username) && !empty($data->password)) {
        $admin->username = $data->username;
        $admin->password = $data->password;
        
        if($admin->login()) {
            $_SESSION['admin_id'] = $admin->id;
            $_SESSION['admin_username'] = $admin->username;
            $_SESSION['admin_email'] = $admin->email;
            
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
            http_response_code(401);
            echo json_encode(array("message" => "Invalid credentials."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Unable to login. Data is incomplete."));
    }
} elseif($request_method == 'GET') {
    if(isset($_SESSION['admin_id'])) {
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
    session_destroy();
    
    http_response_code(200);
    echo json_encode(array("message" => "Logged out successfully."));
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
