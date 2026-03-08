<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../models/Doctor.php';
require_once '../models/Patient.php';
require_once '../models/Appointment.php';

session_start();

if(!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorized."));
    exit();
}

$database = new Database();
$db = $database->getConnection();

$doctor = new Doctor($db);
$patient = new Patient($db);
$appointment = new Appointment($db);

$request_method = $_SERVER["REQUEST_METHOD"];

if($request_method == 'GET') {
    $stats = array();
    
    // Total doctors
    $stmt = $doctor->read();
    $stats['total_doctors'] = $stmt->rowCount();
    
    // Total patients
    $stmt = $patient->read();
    $stats['total_patients'] = $stmt->rowCount();
    
    // Today's appointments
    $stats['today_appointments'] = $appointment->getTodayAppointments();
    
    // Total appointments
    $stats['total_appointments'] = $appointment->getTotalAppointments();
    
    // Recent appointments (last 5)
    $stmt = $appointment->read();
    $recent_appointments = array();
    $count = 0;
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC) && $count < 5) {
        extract($row);
        $appointment_item = array(
            "id" => $id,
            "patient_name" => $patient_first_name . ' ' . $patient_last_name,
            "doctor_name" => $doctor_first_name . ' ' . $doctor_last_name,
            "service_name" => $service_name,
            "appointment_date" => $appointment_date,
            "appointment_time" => $appointment_time,
            "status" => $status
        );
        array_push($recent_appointments, $appointment_item);
        $count++;
    }
    
    $stats['recent_appointments'] = $recent_appointments;
    
    http_response_code(200);
    echo json_encode($stats);
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
