<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Doctor.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Appointment.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorized."));
    exit();
}

$database = new Database();
$db = $database->getConnection();
if(!$db) {
    http_response_code(503);
    echo json_encode(array("message" => "Database connection failed."));
    exit();
}

// Get statistics
$stats = array();

// Count doctors
$doctor = new Doctor($db);
$doctors_stmt = $doctor->read();
$stats['total_doctors'] = $doctors_stmt->rowCount();

// Count patients
$patient = new Patient($db);
$patients_stmt = $patient->read();
$stats['total_patients'] = $patients_stmt->rowCount();

// Count appointments
$appointment = new Appointment($db);
$appointments_stmt = $appointment->read();
$stats['total_appointments'] = $appointments_stmt->rowCount();

// Count services
$services_stmt = $db->query("SELECT COUNT(*) as count FROM services");
$services_result = $services_stmt->fetch(PDO::FETCH_ASSOC);
$stats['total_services'] = $services_result ? $services_result['count'] : 0;

// Get recent appointments (last 7 days)
$query = "SELECT COUNT(*) as recent_appointments FROM appointments WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$stats['recent_appointments'] = $result['recent_appointments'];

// Get appointments by status
$query = "SELECT status, COUNT(*) as count FROM appointments GROUP BY status";
$stmt = $db->prepare($query);
$stmt->execute();
$status_counts = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $status_counts[$row['status']] = $row['count'];
}
$stats['appointments_by_status'] = $status_counts;

// Get recent appointments list (last 10)
$query = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name, p.phone as patient_phone, 
                d.first_name as doctor_first_name, d.last_name as doctor_last_name, d.speciality as doctor_speciality,
                s.name as service_name
          FROM appointments a
          LEFT JOIN patients p ON a.patient_id = p.id
          LEFT JOIN doctors d ON a.doctor_id = d.id
          LEFT JOIN services s ON a.service_id = s.id
          ORDER BY a.appointment_date DESC, a.appointment_time DESC
          LIMIT 10";
$stmt = $db->prepare($query);
$stmt->execute();

$recent_appointments_list = array();
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $appointment_item = array(
        "id" => $row['id'],
        "patient_first_name" => $row['patient_first_name'],
        "patient_last_name" => $row['patient_last_name'],
        "patient_phone" => $row['patient_phone'],
        "doctor_first_name" => $row['doctor_first_name'],
        "doctor_last_name" => $row['doctor_last_name'],
        "doctor_speciality" => $row['doctor_speciality'],
        "service_name" => $row['service_name'],
        "appointment_date" => $row['appointment_date'],
        "appointment_time" => substr($row['appointment_time'], 0, 5),
        "status" => $row['status']
    );
    array_push($recent_appointments_list, $appointment_item);
}
$stats['recent_appointments_list'] = $recent_appointments_list;

http_response_code(200);
echo json_encode($stats);
?>
