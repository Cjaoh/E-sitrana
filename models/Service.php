<?php
class Service {
    private $conn;
    private $table_name = "services";

    public $id;
    public $name;
    public $description;
    public $icon;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, description=:description, icon=:icon";
        
        $stmt = $this->conn->prepare($query);
        
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $icon = $this->icon !== null ? htmlspecialchars(strip_tags($this->icon)) : null;
        
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":icon", $icon);
        
        if($stmt->execute()) {
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
        if(!$row) {
            return false;
        }
        
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->icon = $row['icon'];
        return true;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET name = :name, description = :description, icon = :icon WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $icon = $this->icon !== null ? htmlspecialchars(strip_tags($this->icon)) : null;
        $this->id=htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':icon', $icon);
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
