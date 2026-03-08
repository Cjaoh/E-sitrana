<?php
class Admin {
    private $conn;
    private $table_name = "admins";

    public $id;
    public $username;
    public $password;
    public $email;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = "SELECT id, username, password, email FROM " . $this->table_name . " WHERE username = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->username);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row && password_verify($this->password, $row['password'])) {
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            return true;
        }
        return false;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->username = $row['username'];
        $this->email = $row['email'];
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (username, password, email) VALUES (:username, :password, :email)";
        
        $stmt = $this->conn->prepare($query);
        
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->password=password_hash($this->password, PASSWORD_DEFAULT);
        $this->email=htmlspecialchars(strip_tags($this->email));
        
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":email", $this->email);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
