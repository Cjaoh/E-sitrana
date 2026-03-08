<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Service.php';

$database = new Database();
$db = $database->getConnection();

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
        
        if(!empty($data->name) && !empty($data->description)) {
            $service->name = $data->name;
            $service->description = $data->description;
            $service->icon = isset($data->icon) ? $data->icon : null;
            
            if($service->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Service was created."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create service."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create service. Data is incomplete."));
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        
        if(isset($_GET['id']) && !empty($data->name) && !empty($data->description)) {
            $service->id = $_GET['id'];
            $service->name = $data->name;
            $service->description = $data->description;
            $service->icon = isset($data->icon) ? $data->icon : null;
            
            if($service->update()) {
                http_response_code(200);
                echo json_encode(array("message" => "Service was updated."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to update service."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to update service. Data is incomplete."));
        }
        break;
        
    case 'DELETE':
        if(isset($_GET['id'])) {
            $service->id = $_GET['id'];
            
            if($service->delete()) {
                http_response_code(200);
                echo json_encode(array("message" => "Service was deleted."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to delete service."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to delete service. ID is missing."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}
?>
