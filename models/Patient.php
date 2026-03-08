<?php
class Patient {
    private $conn;
    private $table_name = "patients";

    public $id;
    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $address;
    public $birth_date;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET first_name=:first_name, last_name=:last_name, phone=:phone, email=:email, address=:address, birth_date=:birth_date";
        
        $stmt = $this->conn->prepare($query);
        
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->birth_date=htmlspecialchars(strip_tags($this->birth_date));
        
        // Handle empty birth_date
        $birth_date = !empty($this->birth_date) ? $this->birth_date : null;
        $address = !empty($this->address) ? $this->address : null;
        
        $stmt->bindParam(":first_name", $this->first_name);
        $stmt->bindParam(":last_name", $this->last_name);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":birth_date", $birth_date);
        
        if($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->first_name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->phone = $row['phone'];
        $this->email = $row['email'];
        $this->address = $row['address'];
        $this->birth_date = $row['birth_date'];
    }

    public function checkIfExists() {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row) {
            $this->id = $row['id'];
            return true;
        }
        return false;
    }

    public function getOrCreate() {
        if($this->checkIfExists()) {
            $this->readOne();
            return $this->id;
        } else {
            if($this->create()) {
                return $this->id;
            }
        }
        return false;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET first_name = :first_name, last_name = :last_name, phone = :phone, email = :email, address = :address, birth_date = :birth_date WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->first_name=htmlspecialchars(strip_tags($this->first_name));
        $this->last_name=htmlspecialchars(strip_tags($this->last_name));
        $this->phone=htmlspecialchars(strip_tags($this->phone));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->birth_date=htmlspecialchars(strip_tags($this->birth_date));
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        // Handle empty birth_date and address
        $birth_date = !empty($this->birth_date) ? $this->birth_date : null;
        $address = !empty($this->address) ? $this->address : null;
        
        $stmt->bindParam(':first_name', $this->first_name);
        $stmt->bindParam(':last_name', $this->last_name);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':birth_date', $birth_date);
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
}
?>
