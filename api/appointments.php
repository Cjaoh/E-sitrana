<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../models/Appointment.php';
require_once '../models/Patient.php';

$database = new Database();
$db = $database->getConnection();

$appointment = new Appointment($db);
$patient = new Patient($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch($request_method) {
    case 'GET':
        if(isset($_GET['id'])) {
            $appointment->id = $_GET['id'];
            $appointment->readOne();
            
            if($appointment->patient_id) {
                $appointment_arr = array(
                    "id" => $appointment->id,
                    "patient_id" => $appointment->patient_id,
                    "doctor_id" => $appointment->doctor_id,
                    "service_id" => $appointment->service_id,
                    "appointment_date" => $appointment->appointment_date,
                    "appointment_time" => $appointment->appointment_time,
                    "status" => $appointment->status,
                    "created_at" => $appointment->created_at
                );
                
                http_response_code(200);
                echo json_encode($appointment_arr);
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Appointment not found."));
            }
        } else {
            $stmt = $appointment->read();
            $num = $stmt->rowCount();
            
            if($num > 0) {
                $appointments_arr = array();
                $appointments_arr["records"] = array();
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $appointment_item = array(
                        "id" => $id,
                        "patient_id" => $patient_id,
                        "doctor_id" => $doctor_id,
                        "service_id" => $service_id,
                        "appointment_date" => $appointment_date,
                        "appointment_time" => $appointment_time,
                        "status" => $status,
                        "patient_first_name" => $patient_first_name,
                        "patient_last_name" => $patient_last_name,
                        "patient_phone" => $patient_phone,
                        "patient_email" => $patient_email,
                        "doctor_first_name" => $doctor_first_name,
                        "doctor_last_name" => $doctor_last_name,
                        "doctor_speciality" => $doctor_speciality,
                        "service_name" => $service_name,
                        "created_at" => $created_at
                    );
                    
                    array_push($appointments_arr["records"], $appointment_item);
                }
                
                http_response_code(200);
                echo json_encode($appointments_arr);
            } else {
                http_response_code(200);
                echo json_encode(array("records" => array()));
            }
        }
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        
        if(!empty($data->first_name) && !empty($data->last_name) && !empty($data->phone) && 
           !empty($data->email) && !empty($data->doctor_id) && !empty($data->service_id) && 
           !empty($data->appointment_date) && !empty($data->appointment_time)) {
            
            $patient->first_name = $data->first_name;
            $patient->last_name = $data->last_name;
            $patient->phone = $data->phone;
            $patient->email = $data->email;
            
            $patient_id = $patient->getOrCreate();
            
            if($patient_id) {
                $appointment->patient_id = $patient_id;
                $appointment->doctor_id = $data->doctor_id;
                $appointment->service_id = $data->service_id;
                $appointment->appointment_date = $data->appointment_date;
                $appointment->appointment_time = $data->appointment_time;
                $appointment->status = 'en attente';
                
                if($appointment->checkAvailability()) {
                    if($appointment->create()) {
                        http_response_code(201);
                        echo json_encode(array("message" => "Appointment was created."));
                    } else {
                        http_response_code(503);
                        echo json_encode(array("message" => "Unable to create appointment."));
                    }
                } else {
                    http_response_code(409);
                    echo json_encode(array("message" => "Doctor is not available at this time."));
                }
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create or find patient."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create appointment. Data is incomplete."));
        }
        break;
        
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        
        if(isset($_GET['id']) && !empty($data->status)) {
            $appointment->id = $_GET['id'];
            $appointment->status = $data->status;
            
            if($appointment->updateStatus()) {
                http_response_code(200);
                echo json_encode(array("message" => "Appointment status was updated."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to update appointment status."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to update appointment. Data is incomplete."));
        }
        break;
        
    case 'DELETE':
        if(isset($_GET['id'])) {
            $appointment->id = $_GET['id'];
            
            if($appointment->delete()) {
                http_response_code(200);
                echo json_encode(array("message" => "Appointment was deleted."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to delete appointment."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to delete appointment. ID is missing."));
        }
        break;
        
    default:
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        break;
}
?>
