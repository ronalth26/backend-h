<?php
class Database {
    private $host = '127.0.0.1';
    private $db_name = 'u719040383_workitout';
    private $username = 'root';
    private $password = '';
    private $conn;
 
    public function getConnection() {
        $this->conn = null;
 
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>