<?php
require_once __DIR__ . '/../config/cors.php';
configureCors();

require_once __DIR__ . '/../config/database_mysql.php';
require_once __DIR__ . '/../config/validation.php';
require_once __DIR__ . '/../config/rate_limiter.php';
require_once __DIR__ . '/../models/Doctor.php';

// Rate limiting général pour l'API
if (!checkApiRateLimit()) {
    sendRateLimitResponse();
}

$database = new Database();
$db = $database->getConnection();
if(!$db) {
    http_response_code(503);
    echo json_encode(array("message" => "Database connection failed."));
    exit();
}

$doctor = new Doctor($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        if(isset($_GET['id'])) {
            $doctor->id = $_GET['id'];
            $doctor->readOne();
            
            if($doctor->first_name) {
                $doctor_arr = array(
                    "id" => $doctor->id,
                    "first_name" => $doctor->first_name,
                    "last_name" => $doctor->last_name,
                    "speciality" => $doctor->speciality,
                    "phone" => $doctor->phone,
                    "email" => $doctor->email,
                    "photo" => $doctor->photo,
                    "description" => $doctor->description,
                    "service_id" => $doctor->service_id,
                    "created_at" => $doctor->created_at
                );
                
                http_response_code(200);
                echo json_encode($doctor_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Doctor not found."));
            }
        } elseif(isset($_GET['service_id'])) {
            $stmt = $doctor->getByService($_GET['service_id']);
            $num = $stmt->rowCount();
            
            if($num > 0) {
                $doctors_arr = array();
                $doctors_arr["records"] = array();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $doctor_item = array(
                        "id" => $id,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "speciality" => $speciality,
                        "phone" => $phone,
                        "email" => $email,
                        "photo" => $photo,
                        "description" => $description,
                        "service_id" => $service_id,
                        "service_name" => $service_name,
                        "created_at" => $created_at
                    );
                    
                    array_push($doctors_arr["records"], $doctor_item);
                }
                
                http_response_code(200);
                echo json_encode($doctors_arr);
            } else {
                http_response_code(200);
                echo json_encode(array("records" => array()));
            }
        } else {
            $stmt = $doctor->read();
            $num = $stmt->rowCount();
            
            if($num > 0) {
                $doctors_arr = array();
                $doctors_arr["records"] = array();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $doctor_item = array(
                        "id" => $id,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "speciality" => $speciality,
                        "phone" => $phone,
                        "email" => $email,
                        "photo" => $photo,
                        "description" => $description,
                        "service_id" => $service_id,
                        "service_name" => $service_name,
                        "created_at" => $created_at
                    );
                    
                    array_push($doctors_arr["records"], $doctor_item);
                }
                
                http_response_code(200);
                echo json_encode($doctors_arr);
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
        
        $validation_errors = validateDoctorData($data);
        if(!empty($validation_errors)) {
            http_response_code(400);
            echo json_encode(array("message" => "Validation failed.", "errors" => $validation_errors));
            break;
        }
        
        $doctor->first_name = sanitizeInput($data->first_name);
        $doctor->last_name = sanitizeInput($data->last_name);
        $doctor->speciality = sanitizeInput($data->speciality);
        $doctor->phone = sanitizeInput($data->phone);
        $doctor->email = sanitizeInput($data->email);
        $doctor->photo = isset($data->photo) ? sanitizeInput($data->photo) : null;
        $doctor->description = isset($data->description) ? sanitizeInput($data->description) : null;
        $doctor->service_id = $data->service_id;
        
        if($doctor->create()) {
            http_response_code(201);
            echo json_encode(array("message" => "Doctor was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create doctor."));
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        
        if(!$data || !isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Invalid request. Missing ID or data."));
            break;
        }
        
        $validation_errors = validateDoctorData($data);
        if(!empty($validation_errors)) {
            http_response_code(400);
            echo json_encode(array("message" => "Validation failed.", "errors" => $validation_errors));
            break;
        }
        
        $doctor->id = $_GET['id'];
        $doctor->first_name = sanitizeInput($data->first_name);
        $doctor->last_name = sanitizeInput($data->last_name);
        $doctor->speciality = sanitizeInput($data->speciality);
        $doctor->phone = sanitizeInput($data->phone);
        $doctor->email = sanitizeInput($data->email);
        $doctor->photo = isset($data->photo) ? sanitizeInput($data->photo) : null;
        $doctor->description = isset($data->description) ? sanitizeInput($data->description) : null;
        $doctor->service_id = $data->service_id;
        
        if($doctor->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Doctor was updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update doctor."));
        }
        break;
        
    case 'DELETE':
        if(!isset($_GET['id']) || !validateId($_GET['id'])) {
            http_response_code(400);
            echo json_encode(array("message" => "Invalid or missing doctor ID."));
            break;
        }
        
        $doctor->id = $_GET['id'];
        
        if($doctor->delete()) {
            http_response_code(200);
            echo json_encode(array("message" => "Doctor was deleted."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to delete doctor."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}
?>
