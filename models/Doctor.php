<?php
class Doctor {
    private $conn;
    private $table_name = "doctors";

    public $id;
    public $first_name;
    public $last_name;
    public $speciality;
    public $phone;
    public $email;
    public $photo;
    public $description;
    public $service_id;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET first_name=:first_name, last_name=:last_name, speciality=:speciality, phone=:phone, email=:email, photo=:photo, description=:description, service_id=:service_id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->speciality=htmlspecialchars(strip_tags($this->speciality));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->photo=htmlspecialchars(strip_tags($this->photo));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->service_id=htmlspecialchars(strip_tags($this->service_id));
        
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":speciality", $this->speciality);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":photo", $this->photo);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":service_id", $this->service_id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT d.*, s.name as service_name FROM " . $this->table_name . " d LEFT JOIN services s ON d.service_id = s.id ORDER BY d.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT d.*, s.name as service_name FROM " . $this->table_name . " d LEFT JOIN services s ON d.service_id = s.id WHERE d.id = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->speciality = $row['speciality'];
        $this->phone = $row['phone'];
        $this->email = $row['email'];
        $this->photo = $row['photo'];
        $this->description = $row['description'];
        $this->service_id = $row['service_id'];
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET first_name = :first_name, last_name = :last_name, speciality = :speciality, phone = :phone, email = :email, photo = :photo, description = :description, service_id = :service_id WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->speciality=htmlspecialchars(strip_tags($this->speciality));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->photo=htmlspecialchars(strip_tags($this->photo));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->service_id=htmlspecialchars(strip_tags($this->service_id));
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':speciality', $this->speciality);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':photo', $this->photo);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':service_id', $this->service_id);
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

    public function getByService($service_id) {
        $query = "SELECT d.*, s.name as service_name FROM " . $this->table_name . " d LEFT JOIN services s ON d.service_id = s.id WHERE d.service_id = ? ORDER BY d.last_name ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $service_id);
        $stmt->execute();
        
        return $stmt;
    }
}
?>
