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
        } elseif(isset($_GET['email']) && isset($_GET['phone'])) {
            // Search patient by email and phone for login
            $query = "SELECT * FROM " . "patients" . " WHERE email = ? AND phone = ? LIMIT 0,1";
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $_GET['email']);
            $stmt->bindParam(2, $_GET['phone']);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($row) {
                $patient_arr = array(
                    "id" => $row['id'],
                    "first_name" => $row['first_name'],
                    "last_name" => $row['last_name'],
                    "phone" => $row['phone'],
                    "email" => $row['email'],
                    "address" => $row['address'],
                    "birth_date" => $row['birth_date'],
                    "created_at" => $row['created_at']
                );
                
                http_response_code(200);
                echo json_encode(array("records" => array($patient_arr)));
            } else {
                http_response_code(200);
                echo json_encode(array("records" => array()));
            }
        } elseif(isset($_GET['patient_id'])) {
            // Get appointments for specific patient
            $query = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name, p.phone as patient_phone, 
                            d.first_name as doctor_first_name, d.last_name as doctor_last_name, d.speciality as doctor_speciality,
                            s.name as service_name
                      FROM appointments a
                      LEFT JOIN patients p ON a.patient_id = p.id
                      LEFT JOIN doctors d ON a.doctor_id = d.id
                      LEFT JOIN services s ON a.service_id = s.id
                      WHERE a.patient_id = ?
                      ORDER BY a.appointment_date DESC, a.appointment_time DESC";
            $stmt = $db->prepare($query);
            $stmt->bindParam(1, $_GET['patient_id']);
            $stmt->execute();
            
            $appointments_arr = array();
            $appointments_arr["records"] = array();
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $appointment_item = array(
                    "id" => $id,
                    "patient_first_name" => $patient_first_name,
                    "patient_last_name" => $patient_last_name,
                    "patient_phone" => $patient_phone,
                    "doctor_first_name" => $doctor_first_name,
                    "doctor_last_name" => $doctor_last_name,
                    "doctor_speciality" => $doctor_speciality,
                    "service_name" => $service_name,
                    "appointment_date" => $appointment_date,
                    "appointment_time" => substr($appointment_time, 0, 5),
                    "status" => $status,
                    "created_at" => $created_at
                );
                
                array_push($appointments_arr["records"], $appointment_item);
            }
            
            http_response_code(200);
            echo json_encode($appointments_arr);
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
