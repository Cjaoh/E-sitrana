<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Doctor.php';

$database = new Database();
$db = $database->getConnection();

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
        
        if(!empty($data->first_name) && !empty($data->last_name) && !empty($data->speciality) && 
           !empty($data->phone) && !empty($data->email) && !empty($data->service_id)) {
            
            $doctor->first_name = $data->first_name;
            $doctor->last_name = $data->last_name;
            $doctor->speciality = $data->speciality;
            $doctor->phone = $data->phone;
            $doctor->email = $data->email;
            $doctor->photo = isset($data->photo) ? $data->photo : null;
            $doctor->description = isset($data->description) ? $data->description : null;
            $doctor->service_id = $data->service_id;
            
            if($doctor->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Doctor was created."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create doctor."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create doctor. Data is incomplete."));
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        
        if(isset($_GET['id']) && !empty($data->first_name) && !empty($data->last_name) && 
           !empty($data->speciality) && !empty($data->phone) && !empty($data->email) && !empty($data->service_id)) {
            
            $doctor->id = $_GET['id'];
            $doctor->first_name = $data->first_name;
            $doctor->last_name = $data->last_name;
            $doctor->speciality = $data->speciality;
            $doctor->phone = $data->phone;
            $doctor->email = $data->email;
            $doctor->photo = isset($data->photo) ? $data->photo : null;
            $doctor->description = isset($data->description) ? $data->description : null;
            $doctor->service_id = $data->service_id;
            
            if($doctor->update()) {
                http_response_code(200);
                echo json_encode(array("message" => "Doctor was updated."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to update doctor."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to update doctor. Data is incomplete."));
        }
        break;
        
    case 'DELETE':
        if(isset($_GET['id'])) {
            $doctor->id = $_GET['id'];
            
            if($doctor->delete()) {
                http_response_code(200);
                echo json_encode(array("message" => "Doctor was deleted."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to delete doctor."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to delete doctor. ID is missing."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}
?>
