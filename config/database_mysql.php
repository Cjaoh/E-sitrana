<?php
require_once __DIR__ . '/logger.php';

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->db_name = getenv('DB_NAME') ?: 'E_sitrana_db';
        $this->username = getenv('DB_USER') ?: 'esitrana';
        $this->password = getenv('DB_PASS') ?: 'E_sitrana@2024!';
    }

    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4", $this->username, $this->password);
            $this->conn->exec("set names utf8mb4");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            logInfo('Database connection successful', ['database' => $this->db_name]);
            
        } catch(PDOException $exception) {
            logDatabaseError('Connection failed', $exception->getMessage());
            error_log("Connection error: " . $exception->getMessage());
        }
        
        return $this->conn;
    }
}
?>
