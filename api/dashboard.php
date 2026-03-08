<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Doctor.php';
require_once __DIR__ . '/../models/Patient.php';
require_once __DIR__ . '/../models/Appointment.php';

session_start();

if(!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(array("message" => "Unauthorized."));
    exit();
}

$database = new Database();
$db = $database->getConnection();

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
$stats['total_services'] = 5; // From database_setup.sql

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

http_response_code(200);
echo json_encode($stats);
?>
