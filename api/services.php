<?php
require_once __DIR__ . '/../config/cors.php';
configureCors();

require_once __DIR__ . '/../config/database_mysql.php';
require_once __DIR__ . '/../config/validation.php';
require_once __DIR__ . '/../models/Service.php';

$database = new Database();
$db = $database->getConnection();
if(!$db) {
    http_response_code(503);
    echo json_encode(array("message" => "Database connection failed."));
    exit();
}

$service = new Service($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        if(isset($_GET['id'])) {
            $service->id = $_GET['id'];
            $service->readOne();
            
            if($service->name) {
                $service_arr = array(
                    "id" => $service->id,
                    "name" => $service->name,
                    "description" => $service->description,
                    "icon" => $service->icon,
                    "created_at" => $service->created_at
                );
                
                http_response_code(200);
                echo json_encode($service_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Service not found."));
            }
        } else {
            $stmt = $service->read();
            $num = $stmt->rowCount();
            
            if($num > 0) {
                $services_arr = array();
                $services_arr["records"] = array();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $service_item = array(
                        "id" => $id,
                        "name" => $name,
                        "description" => $description,
                        "icon" => $icon,
                        "created_at" => $created_at
                    );
                    
                    array_push($services_arr["records"], $service_item);
                }
                
                http_response_code(200);
                echo json_encode($services_arr);
            } else {
                http_response_code(200);
                echo json_encode(array("records" => array()));
            }
        }
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        
        if(!$data) {
            http_response_code(400);
            echo json_encode(array("message" => "Invalid JSON data."));
            break;
        }
        
        $validation_errors = validateServiceData($data);
        if(!empty($validation_errors)) {
            http_response_code(400);
            echo json_encode(array("message" => "Validation failed.", "errors" => $validation_errors));
            break;
        }
        
        $service->name = sanitizeInput($data->name);
        $service->description = sanitizeInput($data->description);
        $service->icon = isset($data->icon) ? sanitizeInput($data->icon) : null;
        
        if($service->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Service was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create service."));
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        
        if(!$data || !isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Invalid request. Missing ID or data."));
            break;
        }
        
        $validation_errors = validateServiceData($data);
        if(!empty($validation_errors)) {
            http_response_code(400);
            echo json_encode(array("message" => "Validation failed.", "errors" => $validation_errors));
            break;
        }
        
        $service->id = $_GET['id'];
        $service->name = sanitizeInput($data->name);
        $service->description = sanitizeInput($data->description);
        $service->icon = isset($data->icon) ? sanitizeInput($data->icon) : null;
        
        if($service->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Service was updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update service."));
        }
        break;
        
    case 'DELETE':
        if(!isset($_GET['id']) || !validateId($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Invalid or missing service ID."));
            break;
        }
        
        $service->id = $_GET['id'];
        
        if($service->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Service was deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete service."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}
?>
