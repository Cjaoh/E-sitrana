<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Patient.php';

$database = new Database();
$db = $database->getConnection();

$patient = new Patient($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        if(isset($_GET['id'])) {
            $patient->id = $_GET['id'];
            $patient->readOne();
            
            if($patient->first_name) {
                $patient_arr = array(
                    "id" => $patient->id,
                    "first_name" => $patient->first_name,
                    "last_name" => $patient->last_name,
                    "phone" => $patient->phone,
                    "email" => $patient->email,
                    "address" => $patient->address,
                    "birth_date" => $patient->birth_date,
                    "created_at" => $patient->created_at
                );
                
                http_response_code(200);
                echo json_encode($patient_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Patient not found."));
            }
        } else {
            $stmt = $patient->read();
            $num = $stmt->rowCount();
            
            if($num > 0) {
                $patients_arr = array();
                $patients_arr["records"] = array();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $patient_item = array(
                        "id" => $id,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "phone" => $phone,
                        "email" => $email,
                        "address" => $address,
                        "birth_date" => $birth_date,
                        "created_at" => $created_at
                    );
                    
                    array_push($patients_arr["records"], $patient_item);
                }
                
                http_response_code(200);
                echo json_encode($patients_arr);
            } else {
                http_response_code(200);
                echo json_encode(array("records" => array()));
            }
        }
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->first_name) && !empty($data->last_name) && !empty($data->phone) && !empty($data->email)) {
            
            $patient->first_name = $data->first_name;
            $patient->last_name = $data->last_name;
            $patient->phone = $data->phone;
            $patient->email = $data->email;
            $patient->address = isset($data->address) ? $data->address : null;
            $patient->birth_date = isset($data->birth_date) ? $data->birth_date : null;
            
            if($patient->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "Patient was created."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create patient."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create patient. Data is incomplete."));
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        
        if(isset($_GET['id']) && !empty($data->first_name) && !empty($data->last_name) && !empty($data->phone) && !empty($data->email)) {
            
            $patient->id = $_GET['id'];
            $patient->first_name = $data->first_name;
            $patient->last_name = $data->last_name;
            $patient->phone = $data->phone;
            $patient->email = $data->email;
            $patient->address = isset($data->address) ? $data->address : null;
            $patient->birth_date = isset($data->birth_date) ? $data->birth_date : null;
            
            if($patient->update()) {
                http_response_code(200);
                echo json_encode(array("message" => "Patient was updated."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to update patient."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to update patient. Data is incomplete."));
        }
        break;
        
    case 'DELETE':
        if(isset($_GET['id'])) {
            $patient->id = $_GET['id'];
            
            if($patient->delete()) {
                http_response_code(200);
                echo json_encode(array("message" => "Patient was deleted."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to delete patient."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to delete patient. ID is missing."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}
?>
