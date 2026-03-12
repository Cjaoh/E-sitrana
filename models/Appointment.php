<?php
class Appointment {
    private $conn;
    private $table_name = "appointments";

    public $id;
    public $patient_id;
    public $doctor_id;
    public $service_id;
    public $appointment_date;
    public $appointment_time;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET patient_id=:patient_id, doctor_id=:doctor_id, service_id=:service_id, appointment_date=:appointment_date, appointment_time=:appointment_time, status=:status";
        
        $stmt = $this->conn->prepare($query);
        
        $this->patient_id=htmlspecialchars(strip_tags($this->patient_id));
        $this->doctor_id=htmlspecialchars(strip_tags($this->doctor_id));
        $this->service_id=htmlspecialchars(strip_tags($this->service_id));
        $this->appointment_date=htmlspecialchars(strip_tags($this->appointment_date));
        $this->appointment_time=htmlspecialchars(strip_tags($this->appointment_time));
        $this->status=htmlspecialchars(strip_tags($this->status));
        
        $stmt->bindParam(":patient_id", $this->patient_id);
        $stmt->bindParam(":doctor_id", $this->doctor_id);
        $stmt->bindParam(":service_id", $this->service_id);
        $stmt->bindParam(":appointment_date", $this->appointment_date);
        $stmt->bindParam(":appointment_time", $this->appointment_time);
        $stmt->bindParam(":status", $this->status);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name, p.phone as patient_phone, p.email as patient_email, d.first_name as doctor_first_name, d.last_name as doctor_last_name, d.speciality as doctor_speciality, s.name as service_name FROM " . $this->table_name . " a LEFT JOIN patients p ON a.patient_id = p.id LEFT JOIN doctors d ON a.doctor_id = d.id LEFT JOIN services s ON a.service_id = s.id ORDER BY a.appointment_date DESC, a.appointment_time DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT a.*, p.first_name as patient_first_name, p.last_name as patient_last_name, p.phone as patient_phone, p.email as patient_email, d.first_name as doctor_first_name, d.last_name as doctor_last_name, d.speciality as doctor_speciality, s.name as service_name FROM " . $this->table_name . " a LEFT JOIN patients p ON a.patient_id = p.id LEFT JOIN doctors d ON a.doctor_id = d.id LEFT JOIN services s ON a.service_id = s.id WHERE a.id = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) {
            return false;
        }
        
        $this->patient_id = $row['patient_id'];
        $this->doctor_id = $row['doctor_id'];
        $this->service_id = $row['service_id'];
        $this->appointment_date = $row['appointment_date'];
        $this->appointment_time = $row['appointment_time'];
        $this->status = $row['status'];
        return true;
    }

    public function updateStatus() {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(1, $this->id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getTodayAppointments() {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE appointment_date = CURDATE()";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    public function getTotalAppointments() {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    public function checkAvailability() {
        $query = "SELECT COUNT(*) as count FROM " . $this->table_name . " WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? AND status != 'annulé'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->doctor_id);
        $stmt->bindParam(2, $this->appointment_date);
        $stmt->bindParam(3, $this->appointment_time);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] == 0;
    }
}
?>
